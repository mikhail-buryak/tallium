<div class="modal-dialog">
    <!-- Booking Place -->
    <div class="modal-content">
        <form id="handleBooking" action="/booking/{{ $place->id }}" data-id="{{ $place->id }}" method="post">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Booking place #{{ $place->id }}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <p>Сost of place is {{ $place->price }} bottle caps)</p>
                </div>
                <div class="form-group">
                    <label for="user_info">Your name</label>
                    <input class="form-control" type="text" name="user_info" value="">
                    <input type="hidden" name="place_id" value="{{ $place->id }}">
                </div>
                <div class="form-group">
                    <div class="alerts"></div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary submit disabled" type="submit">Buy for {{ $place->price }} BC</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </form>
    </div>
</div>