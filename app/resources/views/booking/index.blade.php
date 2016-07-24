@extends('layouts.app')

@push('styles')
<link href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<link href="//cdn.datatables.net/responsive/1.0.0/css/dataTables.responsive.css" rel="stylesheet" type="text/css">
@endpush

@push('scripts')
<script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.js"></script>
<script type="text/javascript">

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
