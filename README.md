## Mikhail Buryak ##
=================
### [Tallium](https://tallium.com/) Code Demonstration ###

### Task Description (Language: Russian)

Написать простую систему бронирования билетов на футбол.
Подробности:
1) Отображения мест (ряд, место, сектор) - Визуально воспроизводить стадион не обязательно, достаточно сделать таблицами (списки секторов, рядов, мест).
2) Отображение в реальном времени:
- Мест которые уже забронированы кем-либо (одно место - один человек - одна бронь)
- Мест которые сейчас в процессе брони
- Общее кол-во свободных мест в целом, в выбранном секторе (если выбран)
3) Два и более людей могу одновременно проходить процесс бронирования одного и того же места, но в случае если бронь на данное место прошла (один пользователь подтвердил ее), необходимо в реальном времени уведомлять всех кто пытается забронировать данное место, что место больше не доступно.

#### [routes](app/app/Http/routes.php)
#### [migrations](app/database/migrations/)
#### [seeds](app/database/seeds/DatabaseSeeder.php)

**Stack**

* [Docker](https://docs.docker.com/engine/)
* [Nginx](https://www.nginx.com/resources/admin-guide/)
* [PostgreSQL](https://www.postgresql.org/docs/)
* [Redis](http://redis.io/documentation)
* [Lumen](https://lumen.laravel.com/docs/5.2)
* [Node.js](https://nodejs.org/en/docs/)
* [Socket.io](http://socket.io/docs/)
* [Express](http://expressjs.com/)
* [Bootstrap](http://www.w3schools.com/bootstrap/)
* [jQuery](http://api.jquery.com/)