@extends('layouts.master')
@section('title', 'Bookings')
@section('content')
    <div>
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
                            Bookings
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <i class="bi bi-chevron-right fs-4 text-gray-700 mx-n1"></i>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-gray-700">
                            Manage Bookings
                        </li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0 mb-3">
                        Bookings
                    </h1>
                    <p class="text-muted">
                        Here you can manage bookings. You can add, edit and delete bookings.
                    </p>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <a href="{{ route('admin.bookings.create') }}" class="btn btn-sm btn-primary px-4 py-3">
                    <i class="bi bi-plus fs-3"></i>
                    New Booking
                </a>
                <!--end::Actions-->
            </div>
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div class="my-3">
            <div class="table-responsive">
                <table class="table ps-2 align-middle border rounded table-row-dashed fs-6 g-5" id="myTable">
                    <thead>
                    <tr class="text-start text-gray-800 fw-bold fs-7 text-uppercase">
                        <th>Room</th>
                        <th>Building</th>
                        <th>Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!--end::Content-->
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            window.dt = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! request()->fullUrl() !!}',
                columns: [
                    {data: 'room.name', name: 'room.name'},
                    {data: 'room.building.name', name: 'room.building.name'},
                    {data: 'room.room_type.name', name: 'room.roomType.name'},
                    {data: 'start_date', name: 'start_date',
                        render: function (data, type, row) {
                            return (new Date(data)).toISOString().slice(0, 10);
                        }
                    },
                    {data: 'end_date', name: 'end_date',
                        render: function (data, type, row) {
                            return (new Date(data)).toISOString().slice(0, 10);
                        }
                    },
                    {
                        data: 'status', name: 'status',
                        render: function (data, type, row) {
                            return `<span class="badge text-${row.status_color} bg-${row.status_color}-subtle rounded-pill">${data}</span>`;
                        }
                    },
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $(document).on('click', '.js-cancel', function (e) {
                e.preventDefault();
                let url = $(this).attr('href');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to cancel this booking!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Cancel it!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                Swal.fire(
                                    'Cancelled!',
                                    'Booking has been cancelled.',
                                    'success'
                                );
                                dt.ajax.reload();
                            },
                            error: function (xhr, status, error) {
                                Swal.fire(
                                    'Error!',
                                    'An error occurred. Please try again.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

        });
    </script>
@endpush