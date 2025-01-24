@extends(auth()->check()?'layouts.master':'layouts.guest')
@section('title', 'New Booking')
@section('content')
    <div class="container py-5">
        <!--begin::Toolbar-->
        <div class="mb-5">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column gap-1 me-3 mb-2">
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-6">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                            <a href="{{ route('home') }}" class="text-gray-500">
                                <i class="bi bi-house fs-3 text-gray-400 me-n1"></i>
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
                            New Booking
                        </li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0 mb-3">
                        Appointment Booking
                    </h1>
                    <p class="text-muted">
                        Here you can request a new appointment with our staff. please fill in the form below.
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
            <form action="{{ route('appointments.store') }}" method="post" id="submitBookingForm">
                @csrf

                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="start_date_time">Start Date</label>
                                    <input class="form-control" type="date" name="start_date_time" id="start_date_time">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="start_time">Start Time</label>
                                    <select class="form-select" name="start_time" id="start_time">
                                        <option value=""></option>
                                        @foreach(range(0,23) as $item)
                                            <option value="{{$item}}">
                                                {{$item}}:00 H
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="end_date_time">End Date</label>
                                    <input class="form-control" type="date" name="end_date_time" id="end_date_time">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="end_time">Start Time</label>
                                    <select class="form-select" name="end_time" id="end_time">
                                        <option value=""></option>
                                        @foreach(range(0,23) as $item)
                                            <option value="{{$item}}">
                                                {{$item}}:00 H
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input class="form-control" type="text" name="name" id="name">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input class="form-control" type="email" name="email" id="email">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="phone">Phone</label>
                            <input class="form-control" type="text" name="phone" id="phone">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="address">Address</label>
                            <input class="form-control" type="text" name="address" id="address">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="guests">Number of Guests</label>
                            <input class="form-control" type="text" name="guests" id="guests">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="organization">Organization</label>
                            <input class="form-control" type="text" name="organization" id="organization">
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="description" class="form-label">Purpose</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
                    </div>

                </div>

                <div class="my-5 d-inline-flex gap-4">
                    <button type="submit" class="btn btn-primary">
                        Request Appointment
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
                </div>

            </form>
        </div>
        <!--end::Content-->
    </div>
@endsection

@push('scripts')

    <script>
        function toggleGuestFields(checkbox) {
            const guestFields = document.getElementById('fields');
            guestFields.style.display = checkbox.checked ? 'block' : 'none';
        }

        let fetchRooms = function (roomType, capacity, selectedRoomId) {
            let url = "{{ route('admin.rooms.all-by-type-capacity') }}" + `?type=${roomType}&guests=${capacity}`;
            let $roomSelect = $('#room_id');
            $roomSelect.empty();
            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    $roomSelect.html(`<option value="">Select Room</option>`);
                    $.each(response, function (index, room) {
                        $roomSelect.append(`<option value="${room.id}" data-details-url="${room.details_url}">${room.name}</option>`);
                    });
                    if (selectedRoomId) {
                        $roomSelect.val(selectedRoomId);
                        $('#room_id').trigger('change');
                    }
                }
            });
        };

        $(document).ready(function () {

            let roomType = '{{ request('type') }}';
            let capacity = '{{ request('guests') }}';
            let selectedRoomId = '{{ request('room_id') }}';
            if (roomType) {
                fetchRooms(roomType, capacity, selectedRoomId);
            }

            $('#room_type_id').on('change', function () {
                let roomType = $(this).val();
                let capacity = $('#guests').val();
                fetchRooms(roomType, capacity);
            });

            $('#guests').on('change', function () {
                let roomType = $('#room_type_id').val();
                let capacity = $(this).val();
                fetchRooms(roomType, capacity);
            });

            $('#is_booking').trigger('change');


            $('#room_id').on('change', function () {
                let url = $(this).find(':selected').data('details-url');

                if (url) {
                    let $roomDetails = $('#room_details');
                    // add a loader inside the room details
                    $roomDetails.html(`<div class="d-flex justify-content-center">
                                          <div class="spinner-border" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                          </div>
                                        </div>`);
                    // fetch the room details
                    $.get(url, function (response) {
                        $roomDetails.html(response);
                    });

                }
            });

            $('#submitBookingForm').on('submit', function (e) {
                e.preventDefault();
                let form = $(this);
                let url = form.attr('action');
                let data = form.serialize();

                // remove all errors
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();
                let $btn = form.find('[type="submit"]');
                $btn.prop('disabled', true)
                    .html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...`);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    success: function (response) {
                        toastr.success(response.message);
                        window.location.href = response.redirect;
                    },
                    error: function (xhr, status, error) {

                        $btn.prop('disabled', false)
                            .html(`Create Booking`);

                        // check status code if it's a validation error 422
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function (key, value) {
                                $(`#${key}`).addClass('is-invalid error')
                                    .after(`<div class="invalid-feedback small">${value}</div>`);
                            });
                        } else {
                            toastr.error('An error occurred, please try again later.');
                        }
                    }
                });
            });

        });
    </script>

@endpush
