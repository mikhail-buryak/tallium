var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');

server.listen(8080);

io.on('connection', function (socket) {

    console.log('client connected');
    var redisClientProcess = redis.createClient(6379, '192.168.99.100');
    var redisClientSubscrible = redis.createClient(6379, '192.168.99.100');
    redisClientSubscrible.subscribe('message');

    redisClientSubscrible.on('message', function(channel, data) {
        socket.emit(channel, data);
    });

    socket.on('booking.process', function (data) {
        redisClientProcess.keys('sid:'+socket.id+'*', function(err, rows) {
            for(var i = 0, j = rows.length; i < j; ++i)
                redisClientProcess.del(rows[i]);
        });
        redisClientProcess.set('sid:'+socket.id+'pid:'+data.placeId, data.placeId, function() {
            socket.broadcast.emit('message', JSON.stringify({ placeId: data.placeId, status: 'process' }));
        });

        console.log('process '+'sid:'+socket.id+'pid:'+data.placeId);
    });

    socket.on('booking.unprocess', function (data) {
        redisClientProcess.del('sid:'+socket.id+'pid:'+data.placeId, function() {});
        redisClientProcess.keys('*pid:'+data.placeId, function(err, rows) {
            if(rows.length == 0)
                io.emit('message', JSON.stringify({ placeId: data.placeId, status: 'unprocess' }));
        });

        console.log('unprocess '+'sid:'+socket.id+'pid:'+data.placeId);
    });

    socket.on('booking.busy', function (data) {
        redisClientProcess.keys('sid:'+socket.id+'*', function(err, rows) {
            for(var i = 0, j = rows.length; i < j; ++i)
                redisClientProcess.del(rows[i]);
        });
        redisClientProcess.set('sid:'+socket.id+'pid:'+data.placeId, data.placeId, function() {
            socket.broadcast.emit('message', JSON.stringify({ placeId: data.placeId, status: 'process' }));
        });

        console.log('busy '+'sid:'+socket.id+'pid:'+data.placeId);
    });


    socket.on('disconnect', function() {
        redisClientProcess.keys('sid:'+socket.id+'*', function(err, rows) {
            if(rows.length == 0) {
                redisClientProcess.quit();
                redisClientSubscrible.quit();
            }

            for(var i = 0, j = rows.length; i < j; ++i) {
                var sidPidRow = rows[i];
                var pid = sidPidRow.split('sid:'+socket.id+'pid:')[1];

                redisClientProcess.del(sidPidRow);
                redisClientProcess.keys('*pid:'+pid, function(err, rows) {
                    if(rows.length == 0)
                        socket.broadcast.emit('message', JSON.stringify({ placeId: pid, status: 'unprocess' }));

                    redisClientProcess.quit();
                    redisClientSubscrible.quit();
                });
            }
        });

        console.log('client disconnected');
    });

});

console.log('server running...');