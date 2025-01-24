@extends('layouts.master')
@section('title', 'Appointment Bookings')
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
                            Appointments
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <i class="bi bi-chevron-right fs-4 text-gray-700 mx-n1"></i>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-gray-700">
                            Manage Appointments
                        </li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0 mb-3">
                        Appointment Bookings
                    </h1>
                    <p class="text-muted">
                        Here you can manage all your appointment bookings.
                    </p>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->

                <!--end::Actions-->
            </div>
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div class="my-3">
            <div class="table-responsive">
                <table class="table table-row-dashed table-row-gray-300 gy-4" id="myTable">
                    <thead>
                    <tr class="text-start text-gray-800 fw-bold fs-7 text-uppercase">
                        <th>Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
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

                    {
                        data: 'start_date_time', name: 'start_date_time',
                        render: function (data, type, row) {
                            return  `<div>
                                    <p>${moment(data).format('D/M/YYYY, HH:mm A')} - ${moment(row.end_date_time).format('D/M/YYYY, HH:mm A')}</p>
                                    </div>`
                        }
                    },
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                    {
                        data: 'status', name: 'status',
                        render: function (data, type, row) {
                            return `<span class="badge text-${row.status_color} bg-${row.status_color}-subtle rounded-pill">${data}</span>`;
                        }
                    },
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                order: [[0, 'desc']]
            });

            $(document).on('click', '.js-cancel', function (e) {
                e.preventDefault();
                let url = $(this).attr('href');
                // reason for cancellation
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to cancel this booking!",
                    input: 'textarea',
                    inputPlaceholder: 'Reason for cancellation',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Cancel it!',
                    cancelButtonText: 'No, keep it'
                }).then((result) => {
                    // {isConfirmed: true, isDenied: false, isDismissed: false, value: 'optional on approval'}
                    let value = result.value;
                    if (result.isConfirmed && value) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                reason: value
                            },
                            success: function (response) {
                                Swal.fire(
                                    'Cancelled!',
                                    'Booking has been cancelled.',
                                    'success'
                                );
                                dt.ajax.reload();
                            },
                            error: function (xhr) {
                                if (xhr.status === 422) {
                                    let errors = xhr.responseJSON.errors;
                                    $.each(errors, function (key, value) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Validation Error',
                                            text: value[0]
                                        });
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'An error occurred. Please try again.',
                                        'error'
                                    );
                                }
                            }
                        });
                    }
                });
            });

        });
    </script>
@endpush
