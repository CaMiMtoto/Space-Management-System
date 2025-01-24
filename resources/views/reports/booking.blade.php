@extends('layouts.master')
@section('title', 'Booking Report')
@section('content')
    <!--begin::Toolbar-->
    <div class="mb-5">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column gap-1 me-3 mb-2">
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-6">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-500">
                            <i class="bi bi-house fs-3 text-gray-400 me-n1"></i>
                        </a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                        Reports
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <i class="bi bi-chevron-right fs-4 text-gray-700 mx-n1"></i>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-700">
                        Booking Report
                    </li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
                <!--begin::Title-->
                <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0 mb-3">
                    Booking Report
                </h1>
                <p class="text-muted">
                    View the booking report for a specific time period.
                </p>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->

            <div class="d-flex align-items-center flex-wrap gap-3">
                <button type="button" class="btn btn-light border btn-sm" id="clear-filters">
                    Clear Filters
                </button>
                   <a href="{{ route('admin.booking.export') }}" class="btn btn-success btn-sm js-export">
                       Export
                       <x-lucide-cloud-download class="ms-2 tw-h-5 tw-w-5"/>
                   </a>
            </div>
            <!--end::Actions-->
        </div>
    </div>
    <!--end::Toolbar-->
    <form class="d-flex flex-row w-100 align-items-end gap-3" action="" method="GET">
        <div class="col-md-3">
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control form-control-sm" name="start_date" id="start_date"
                       value="{{ $startDate }}"/>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control form-control-sm" name="end_date" id="end_date"
                       value="{{ $endDate }}"/>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="room_type" class="form-label">Room Type</label>
                <select class="form-select form-select-sm" name="room_type" id="room_type">
                    <option value="">Select Room Type</option>
                    @foreach($roomTypes as $roomType)
                        <option
                            {{ request('room_type') == $roomType->id ?'selected' : '' }}
                            value="{{ $roomType->id }}">{{ $roomType->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select form-select-sm" name="status" id="status">
                    <option value="">Select Status</option>
                    <option {{ request('status') == 'pending' ?'selected' : '' }} value="pending">Pending</option>
                    <option {{ request('status') == 'cancelled' ?'selected' : '' }} value="cancelled">Cancelled</option>
                    <option {{ request('status') == 'completed' ?'selected' : '' }} value="approved">Approved</option>
                    <option {{ request('status') == 'completed' ?'selected' : '' }} value="rejected">Rejected</option>
                </select>
            </div>
        </div>

    </form>
    <div class="my-3">
        <div>

            <div class="table-responsive">
                <table class="table table-row-dashed table-row-gray-300 gy-4" id="myTable">
                    <thead>
                    <tr class="text-start text-gray-800 fw-bold fs-7 text-uppercase">
                        <th class="tw-min-w-[100px]">Created At</th>
                        <th class="tw-min-w-[100px]">Check In</th>
                        <th class="tw-min-w-[100px]">Check Out</th>
                        <th class="tw-min-w-[100px]">Booking Code</th>
                        <th class="tw-min-w-[100px]">Room Type</th>
                        <th class="tw-min-w-[100px]">Room Number</th>
                        <th class="tw-min-w-[100px]">Building</th>
                        <th class="tw-min-w-[100px]"># of Guests</th>
                        <th class="tw-min-w-[100px]">Guest Name</th>
                        <th class="tw-min-w-[100px]">Guest Phone</th>
                        <th class="tw-min-w-[100px]">Guest Email</th>
                        <th class="tw-min-w-[100px]">Status</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            const table = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{!! request()->fullUrl() !!}',
                    data: function (d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                        d.room_type = $('#room_type').val();
                        d.status = $('#status').val();
                    }
                },
                columns: [
                    {
                        data: 'created_at', name: 'created_at',
                        render: function (data, type, row) {
                            return moment(data).format('DD-MM-YYYY');
                        }
                    },
                    {
                        data: 'start_date', name: 'start_date',
                        render: function (data, type, row) {
                            return moment(data).format('DD-MM-YYYY HH:mm');
                        }
                    },
                    {
                        data: 'end_date', name: 'end_date',
                        render: function (data, type, row) {
                            return moment(data).format('DD-MM-YYYY HH:mm');
                        }
                    },
                    {data: 'booking_code', name: 'booking_code'},
                    {data: 'room.room_type.name', name: 'room.room_type.name'},
                    {data: 'room.room_number', name: 'room.room_number'},
                    {data: 'room.building.name', name: 'room.building.name'},
                    {data: 'guests', name: 'guests'},
                    {data: 'guest_name', name: 'guest_name'},
                    {data: 'guest_phone', name: 'guest_phone'},
                    {data: 'guest_email', name: 'guest_email'},
                    {data: 'status', name: 'status'},
                ],
                order: [[0, 'desc']]
            });
            $('#start_date, #end_date, #room_type, #status').on('change', function () {
                table.ajax.reload();
                // change url to reload data
                window.history.replaceState({}, '', '{!! request()->fullUrl() !!}' +
                    '?start_date=' + $('#start_date').val() +
                    '&end_date=' + $('#end_date').val() +
                    '&room_type=' + $('#room_type').val() +
                    '&status=' + $('#status').val()
                );

            });

            $('#clear-filters').on('click', function () {
                $('#start_date').val('');
                $('#end_date').val('');
                $('#room_type').val('');
                $('#status').val('');
                table.ajax.reload();
                // change url to reload data
                window.history.replaceState({}, '', '{!! route('admin.reports.booking') !!}');
            });

            $('.js-export').on('click', function (e) {
                e.preventDefault();
                window.location.href = '{!! route('admin.booking.export') !!}' +
                    '?start_date=' + $('#start_date').val() +
                    '&end_date=' + $('#end_date').val() +
                    '&room_type=' + $('#room_type').val() +
                    '&status=' + $('#status').val();
            });

        });
    </script>
@endpush
