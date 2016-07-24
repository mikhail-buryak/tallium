@extends('layouts.app')

@push('styles')
<link href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<link href="//cdn.datatables.net/responsive/1.0.0/css/dataTables.responsive.css" rel="stylesheet" type="text/css">
@endpush

@push('scripts')
<script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.js"></script>
<script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>
<script src="/assets/client.js"></script>
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
