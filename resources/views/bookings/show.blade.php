@extends('layouts.master')
@section('title', 'Booking Details')

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
                            <a href="{{ route('admin.bookings.index') }}">
                                Bookings
                            </a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <i class="bi bi-chevron-right fs-4 text-gray-700 mx-n1"></i>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-gray-700">
                            Booking Details
                        </li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0 mb-3">
                        Booking Details
                    </h1>
                    <p class="text-muted">
                        View details of a specific booking
                    </p>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <span
                    class="badge bg-{{ $booking->statusColor }}-subtle rounded-pill fw-bolder text-{{ $booking->statusColor}}-emphasis me-2">{{ $booking->status }}</span>
                <!--end::Actions-->
            </div>
        </div>
        <!--end::Toolbar-->


        <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="icon icon-tabler icons-tabler-outline icon-tabler-bookmarks">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M15 10v11l-5 -3l-5 3v-11a3 3 0 0 1 3 -3h4a3 3 0 0 1 3 3z"/>
                        <path d="M11 3h5a3 3 0 0 1 3 3v11"/>
                    </svg>
                    Booking Details
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="icon icon-tabler icons-tabler-outline icon-tabler-history">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 8l0 4l2 2"/>
                        <path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5"/>
                    </svg>
                    History & Reviews
                </a>
            </li>

        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="kt_tab_pane_4" role="tabpanel">
                <div class="card card-body border-dashed my-3">
                    {{--booking details--}}
                    <h4>
                        Booking Details
                    </h4><br/>
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <label class="form-label">Booking ID:</label>
                            <div class="form-control-plaintext">{{ $booking->booking_code }}</div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <label class="form-label">Check In:</label>
                            <div
                                class="form-control-plaintext">{{ $booking->start_date->format('M d, Y - h:i A') }}</div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <label class="form-label">Check Out:</label>
                            <div class="form-control-plaintext">{{ $booking->end_date->format('M d, Y - h:i A') }}</div>
                        </div>
                        @if($booking->is_guest_booking)
                            <div class="col-md-6 col-lg-4">
                                <label class="form-label">Guest Name:</label>
                                <div class="form-control-plaintext">{{ $booking->guest_name??'N/A' }}</div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label class="form-label">Guest Email:</label>
                                <div class="form-control-plaintext">{{ $booking->guest_email??'N/A' }}</div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label class="form-label">Guest Phone:</label>
                                <div class="form-control-plaintext">{{ $booking->guest_phone??'N/A' }}</div>
                            </div>
                        @endif
                        <div class="col-md-6 col-lg-4">
                            <label class="form-label">Number of Guests:</label>
                            <div class="form-control-plaintext">{{ $booking->guests }}</div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <label class="form-label">Room Type:</label>
                            <div class="form-control-plaintext">{{ $booking->room->roomType->name }}</div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <label class="form-label">Room Name:</label>
                            <div class="form-control-plaintext">{{ $booking->room->name }}</div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <label class="form-label">Room Number:</label>
                            <div class="form-control-plaintext">{{ $booking->room->room_number }}</div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <label class="form-label">Room Capacity:</label>
                            <div class="form-control-plaintext">{{ $booking->room->capacity }}</div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <label class="form-label">Room Floor:</label>
                            <div class="form-control-plaintext">{{ $booking->room->floor }}</div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <label class="form-label">Building:</label>
                            <div class="form-control-plaintext">{{ $booking->room->building->name }}
                                - {{ $booking->room->building->address }}</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Purpose:</label>
                            <div class="form-control-plaintext">{{ $booking->purpose }}</div>
                        </div>
                    </div>
                </div>
                @if($booking->canBeReviewed())
                    <div class="card card-body border-dashed my-3">
                        <h4>
                            Review
                        </h4>
                        <p>
                            You can review this booking by clicking choosing the status (Approved or Rejected) and
                            provide a
                            reason for the status.
                        </p>
                        <form action="{{ route('admin.bookings.review', encodeId($booking->id)) }}" method="POST"
                              id="review-form">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="status">Status:</label>
                                        <select class="form-select" name="status" id="status">
                                            <option value="">Select Status</option>
                                            <option value="approved">Approved</option>
                                            <option value="rejected">Rejected</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="description">Reason:</label>
                                        <textarea class="form-control" name="description" id="description"
                                                  rows="3"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">
                                            Submit Review
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                @endif
            </div>
            <div class="tab-pane fade" id="kt_tab_pane_5" role="tabpanel">
                {{--                timeline--}}

                <ul class="tw-relative border-start  tw-border-gray-200 dark:tw-border-gray-700">
                    @foreach($booking->flow as $item)
                        <li class="tw-mb-10 tw-ms-6">
                        <span
                            class="tw-absolute tw-flex tw-items-center tw-justify-center tw-w-6 tw-h-6 bg-{{$item->statusColor}}-subtle tw-rounded-full -tw-start-3 tw-ring-8 tw-ring-white">
                            <svg class="tw-w-2.5 tw-h-2.5 text-{{$item->statusColor}}" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </span>
                            <h3 class="tw-flex tw-items-center tw-mb-1 tw-text-lg tw-font-semibold">
                                {{$item->doneBy->name??'Guest'}}
                                <span
                                    class="badge bg-{{ $item->statusColor }}-subtle tw-rounded-full tw-px-2 tw-py-0.5 tw-text-xs tw-ml-2 text-{{ $item->statusColor }}-emphasis">
                                    {{ucfirst($item->status)}}
                                </span>
                            </h3>
                            <time class="tw-block tw-mb-2 tw-text-sm tw-font-normal tw-leading-none tw-text-gray-400 dark:tw-text-gray-500">
{{--                                Done on January 13th, 2022--}}
                                Done on {{ $item->created_at->format('M d, Y - h:i A') }}
                            </time>
                            <p class="tw-mb-4 tw-text-base tw-font-normal tw-text-gray-500 dark:tw-text-gray-400">
                               {{$item->description}}
                            </p>
                        </li>
                    @endforeach
                </ul>


            </div>
        </div>


    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function () {
            $('#status').on('change', function () {
                let closestLabel = $('#description').closest('.mb-3').find('label');
                if ($(this).val() === 'approved') {
                    closestLabel.html("Reason for Approval:")
                } else if ($(this).val() === 'rejected') {
                    closestLabel.html("Reason for Rejection:")
                }
            });

            $('#review-form').on('submit', function (e) {
                e.preventDefault();
                let $formData = $(this).serialize();
                let $btn = $(this).find('button[type="submit"]');
                $btn.attr('disabled', true).text('Submitting...');
                // clear form errors
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $formData,
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(function () {
                            window.location.href = "{{ route('admin.bookings.index') }}";
                        });
                    },
                    error: function (response) {
                        $btn.attr('disabled', false).text('Submit Review');
                        // check for validation errors
                        let errors = response.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function (key, value) {
                                $('#' + key).addClass('is-invalid').after('<div class="invalid-feedback">' + value + '</div>');
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.responseJSON.message ?? 'Something went wrong'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush
