@extends('layouts.admin')

@section('title', 'Welcome to MillionK')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
<link rel="stylesheet" href="{{ asset('assets/css/datatable/datatables.min.css') }}">

<style>
.custom-select1 {
    color: #2b2b2b!important;
    padding: 8px 5px!important;
    background: #e5e5e5;
}
.registered-date {
    border-radius: 14px;
    padding-left: 12px;
    background: #e5e5e5;
    border: 1px solid #767676;
    height: 40px;
    padding-right: 35px;
    width: 165px;
}
.date-part {
    position: relative;
}
.date-part > img {
    position: absolute;
    right: 20px;
    top: 12px;
    width: 16px;
}
td.details-control {
    background: url('/assets/images/icons/plus.png') no-repeat center center;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url('/assets/images/icons/minus.png') no-repeat center center;
}
#example tr td:nth-child(5) {
    width: 200px;
}
#example th {
    color: #FF335C;
}
.order-id-group .col-3,
.expand-content .fans:last-child {
    border-right: 0px!important;
}
.view-all {
    color: #2178F9;
}
#example_wrapper .row:nth-child(2) {
    overflow: auto;
    margin: 0;
}

</style>
@endsection

@section('content')
<div class="top-header">
    <h4 class="text-white my-auto">Idol List</h4>
    <div class="custom-breadcrumb my-auto">
        <h4 class="text-white mb-0"><span style="font-weight: normal!important">Dashboard</span> > Idol List</h4>
    </div>
</div>
<div class="row m-auto">
    <div class="col-12 col-sm-12 col-md-12 d-flex mt-2 mb-3" style="position:relative">
        <div class="add-new-idol">
            <button class="btn custom-btn add-idol"><img src="{{ asset('assets/images/icons/add-user.png') }}" class="mr-3">Add New Idols</button>
        </div>
        <div class="d-flex custom-select-group">
            <select class="custom-select1 mr-2 idol_user_name desktop" name="idol_user_name">
                <option value="">Idol Username</option>
                @foreach(DB::table('idol_info')->get() as $idol)
                <option value="{{ $idol->idol_user_name }}">{{ $idol->idol_user_name }}</option>
                @endforeach
            </select>
            <select class="custom-select1 mr-2 idol_full_name desktop" name="idol_full_name">
                <option value="">Idol Name</option>
                @foreach(DB::table('idol_info')->get() as $idol)
                <option value="{{ $idol->idol_user_name }}">{{ $idol->idol_full_name }}</option>
                @endforeach
            </select>
            <div class="date-part desktop">
                <input class="mr-2 registered-date" type="text" name="registered_date" value="Registered Date" id="datepicker">
                <img src="{{ asset('assets/images/icons/calendar.png') }}">
            </div>
            <select class="custom-select1 mr-2 status desktop" name="status">
                <option value="">Status</option>
                <option value="1">Active</option>
                <option value="0">Deactive</option>
            </select>
            <button class="btn custom-btn px-5">Filter</button>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-md-12 custom-card">
        <div class="chart">
            <div class="datatable">
                <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Idol Username</th>
                            <th>Idol Name</th>
                            <th>Email</th>
                            <th>Join Date</th>
                            <th>Fans</th>
                            <th>Total Order</th>
                            <th>Pending Order</th>
                            <th>Perc(%)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Idol Username</th>
                            <th>Idol Name</th>
                            <th>Email</th>
                            <th>Join Date</th>
                            <th>Fans</th>
                            <th>Total Order</th>
                            <th>Pending Order</th>
                            <th>Perc(%)</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('assets/js/datatable/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable.js') }}"></script>

<script>
function format ( d ) {
    let completed_orders = '';
    if(d.completed_orders.length) {
        for (let i = 0; i < d.completed_orders.length; i++) {
            completed_orders += '<div class="col-3 col-md-3 col-sm-3 mb-2">' +
                                    '<p class="mb-0 text-main-color">#' + d.completed_orders[i].order_id + '</p>' +
                                '</div>';
        }
    }

    let pending_orders = '';
    if(d.pending_orders.length) {
        for (let i = 0; i < d.pending_orders.length; i++) {
            pending_orders += '<div class="col-3 col-md-3 col-sm-3 mb-2">' +
                                    '<p class="mb-0 text-main-color">#' + d.pending_orders[i].order_id + '</p>' +
                                '</div>';
        }
    }

    let refuned_orders = '';
    if(d.refuned_orders.length) {
        for (let i = 0; i < d.refuned_orders.length; i++) {
            refuned_orders += '<div class="col-3 col-md-3 col-sm-3 mb-2">' +
                                    '<p class="mb-0 text-main-color">#' + d.refuned_orders[i].order_id + '</p>' +
                                '</div>';
        }
    }

    // `d` is the original data object for the row
    return '<table cellpadding="10" class="w-100" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr class="expand">' +
            '<td colspan="10">' +
                '<div class="row m-0 expand-content">' +
                    '<div class="col-4 col-sm-4 col-md-4 fans">' +
                        '<h4 class="mb-0">Pending Orders</h4>' +
                        '<div class="divider"></div>' +
                        '<div class="fans-content mb-2">' +
                            '<div class="row m-0 w-100 mb-2 order-id-group">' +
                                pending_orders +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-4 col-sm-4 col-md-4 fans">' +
                        '<h4 class="mb-0">Completed Orders</h4>' +
                        '<div class="divider"></div>' +
                        '<div class="fans-content mb-2">' +
                            '<div class="row m-0 w-100 mb-2 order-id-group">' +
                                completed_orders +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-4 col-sm-4 col-md-4 fans">' +
                        '<h4 class="mb-0">Refuned Orders</h4>' +
                        '<div class="divider"></div>' +
                        '<div class="fans-content mb-2">' +
                            '<div class="row m-0 w-100 mb-2 order-id-group">' +
                                refuned_orders +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</td>' +
        '</tr>' +
    '</table>';
}

$(document).ready(function() {
    $('#datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });
    $('.add-idol').click(function() {
        location.href = "{{ route('admin-add-idol') }}"
    })

    var table = $('#example').DataTable({
        'ajax': "{{ route('admin-idol-list') }}",
        'columns': [
            {
                'className':      'details-control',
                'orderable':      false,
                'data':           null,
                'defaultContent': ''
            },
            { 'data': 'idol_user_name' },
            { 'data': 'idol_full_name' },
            { 'data': 'email' },
            { 'data': 'join_date' },
            { 'data': 'fans_count' },
            { 'data': 'total_order_count' },
            { 'data': 'pending_order_count' },
            { 'data': 'perc' },
            { 'data': 'status' },
        ],
        'order': [[4, 'desc']]
    } );

    // Add event listener for opening and closing details
    $('#example tbody').on('click', 'td.details-control', function(){
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        // console.log(row.data())

        if(row.child.isShown()){
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });

    $(".idol_user_name, .idol_full_name, .registered-date, .status").on('change', function() {
        let filterlink = '';

        $(".idol_user_name, .idol_full_name, .registered-date, .status").each(function() {
            if (filterlink == '') {
            filterlink += "{{ route('admin-filter-idol') }}" + '?'+ $(this).attr('name') + '=' + $(this).val();
            } else {
                filterlink += '&' + $(this).attr('name') + '=' + $(this).val();
            }
        })
        
        console.log(encodeURI(filterlink))

        table.destroy();
        table = $('#example').DataTable({
            'ajax': encodeURI(filterlink),
            'columns': [
                {
                    'className':      'details-control',
                    'orderable':      false,
                    'data':           null,
                    'defaultContent': ''
                },
                { 'data': 'idol_user_name' },
                { 'data': 'idol_full_name' },
                { 'data': 'email' },
                { 'data': 'join_date' },
                { 'data': 'fans_count' },
                { 'data': 'total_order_count' },
                { 'data': 'pending_order_count' },
                { 'data': 'perc' },
                { 'data': 'status' },
            ],
            'order': [[4, 'desc']]
        } );
    })
});
</script>
@endsection