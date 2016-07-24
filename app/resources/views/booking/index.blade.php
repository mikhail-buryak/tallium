@extends('layouts.app')

@push('styles')
<link href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<link href="//cdn.datatables.net/responsive/1.0.0/css/dataTables.responsive.css" rel="stylesheet" type="text/css">
@endpush

@push('scripts')
<script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.js"></script>
<script type="text/javascript">

    var place = { id: null, busyId: null };
    var table = $('#places-table').DataTable({
        stateSave: true,
        processing: true,
        serverSide: true,
        searching: true,
        responsive: true,
        ajax: '/places/unbooking',
        columns: [
            {data: 'id', name: 'places.id'},
            {data: 'section', name: 'sections.title'},
            {data: 'row', name: 'places.row'},
            {data: 'place', name: 'places.place'},
            {data: 'price', name: 'places.price'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                $(column.footer()).children('input').on('change keyup', function () {
                    column.search($(this).val(), false, false, true).draw();
                });
            });
        }
    });

    function setPlaceStatus(placeId, status) {
        $buttonAction = $('#places-table button[data-id="'+placeId+'"]');
        $formBooking = $('#myModal form[data-id="'+placeId+'"]');

        switch (status) {
            case 'process':
                $buttonAction.removeClass('btn-primary').addClass('btn-warning').text('Process');
                break

            case 'unprocess':
                $buttonAction.removeClass('btn-warning').addClass('btn-primary').text('Booking');
                break

            case 'busy':
                $buttonAction.removeAttr('data-id data-action style').removeClass('btn-warning btn-modal').addClass('btn-danger').text('Busy');
                if($formBooking.length > 0 && place.busyId != placeId) {
                    $formBooking.find('div.alerts').prepend('<div class="alert alert-danger fade in">Oops...this place is already taken.</div>')
                    $formBooking.find('button.submit').attr('disabled', 'disabled').button('refresh');
                }
                break
        }
    }

    $(function() {
        $('div.container table#places-table').on('click', 'button.btn-modal', function() {
            $('#myModal').remove();

            var $this = $(this);
            var $modal = $('<div class="modal fade" id="myModal" role="dialog"></div>');
            place.id = $this.attr('data-id');

            $('body').append($modal);
            $modal.load($this.attr('data-action'), function() { $modal.modal({ keyboard: true }) });
            setPlaceStatus(place.id, 'process');
        });

        $('body').on('submit', 'form#handleBooking', function(e) {
            e.preventDefault();
            var $this = $(this);
            place.busyId = $this.attr('data-id');
            $this.find('button.submit').attr('disabled', 'disabled').button('refresh');
            $('div.alerts').empty();

            $.ajax({
                url: $this.attr('action'),
                data: $this.serialize(),
                type: $this.attr('method'),
                dataType: 'JSON',
                success: function() {
                    $('div.alerts').prepend('<div class="alert alert-success fade in">You have successfully booked a place.</div>');
                },
                error: function(response) {
                    for(var e in response.responseJSON.data)
                        $('div.alerts').append('<div class="alert alert-danger fade in">'+response.responseJSON.data[e]+'</div>');
                    $this.find('button.submit').removeAttr('disabled').button('refresh');
                }
            });
            return false;
        });

        $('body').on('input', 'input[name="user_info"]', function() {
            $button = $(this).closest('#handleBooking').find('button.submit');

            if($(this).val() == '')
                $button.addClass('disabled');
            else
                $button.removeClass('disabled');
        });
    });
</script>
@endpush

@section('content')
    <div class="container" id="pictures">
        <div class="row">
            <h2>Places</h2>

            <table class="table table-bordered display" id="places-table" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Sector</th>
                    <th>Row</th>
                    <th>Place</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tfoot>
                <tr>
                    <th rowspan="1" colspan="1"><input type="text" placeholder="Search by Id"></th>
                    <th rowspan="1" colspan="1"><input type="text" placeholder="Search by Sector"></th>
                    <th rowspan="1" colspan="1"><input type="text" placeholder="Search by Row"></th>
                    <th rowspan="1" colspan="1"><input type="text" placeholder="Search by Place"></th>
                    <th rowspan="1" colspan="1"><input type="text" placeholder="Search by Price"></th>
                    <th></th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="modal-container"></div>

@endsection
