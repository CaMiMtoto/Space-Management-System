@extends(auth()->check()?'layouts.master':'layouts.guest')
@section('title', 'New Booking')
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
                            <a href="{{ route('admin.bookings.index') }}" class="text-gray-500">
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
                            New Booking
                        </li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0 mb-3">
                        New Booking
                    </h1>
                    <p class="text-muted">
                        Here you can create a new booking. please fill in the form below.
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
            <form action="{{ route('admin.bookings.store') }}" method="post" id="submitBookingForm">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label for="room_type_id" class="form-label">Room Type</label>
                                    <select name="room_type_id" id="room_type_id" class="form-select">
                                        <option value="">Select Room Type</option>
                                        @foreach($roomTypes as $roomType)
                                            <option
                                                {{ request('type')==$roomType->id?'selected':'' }}
                                                value="{{ $roomType->id }}">{{ $roomType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="guests" class="form-label">
                                       #Guests
                                    </label>
                                    <input type="number" name="guests" id="guests" class="form-control"
                                           value="{{ request('guests') }}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="room_id" class="form-label">Room</label>
                            <select name="room_id" id="room_id" class="form-select">
                                <option value="">Select Room</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">

                    <div class="col-lg-12">
                        <div id="room_details" class="mb-3">
                            <label for="room_details" class="form-label">Room Details</label>
                            <div
                                class="form-control form-control-plaintext border border-dashed border-secondary px-3 rounded">
                                No room selected yet. Please select a room from the dropdown.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="check_in_date" class="form-label">
                                        Check In Date
                                    </label>
                                    <input type="date" name="check_in_date" id="check_in_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="check_in_time" class="form-label">
                                        Check In Time
                                    </label>
                                    <select name="check_in_time" id="check_in_time" class="form-select">
                                        <option value="">Select Time</option>
                                        @foreach($times as $time)
                                            <option value="{{ $time }}">
                                                {{ $time }}:00
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="check_out_date" class="form-label ">
                                        Check Out Date
                                    </label>
                                    <input type="date" name="check_out_date" id="check_out_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="check_out_time" class="form-label ">
                                        Check Out Time
                                    </label>
                                    <select name="check_out_time" id="check_out_time" class="form-select">
                                        <option value="">Select Time</option>
                                        @foreach(range(0,23) as $time)
                                            <option value="{{ $time }}">
                                                {{ $time }}:00
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-y">
                    @guest
                        <input type="hidden" name="is_guest_booking" value="on"/>
                    @endguest
                    <div class="form-check">
                        <input onchange="toggleGuestFields(this)" class="form-check-input" type="checkbox"
                               {{ !auth()->check()?'checked disabled':'' }}
                               name="is_guest_booking" id="is_guest_booking">
                        <label class="form-check-label tw-text-gray-900" for="is_guest_booking">
                            This is a guest booking (not registered user)
                        </label>
                    </div>
                    <div id="is_guest_booking_help_text" class="form-text">
                        Note that if you are booking a guest, you will need to provide their name, email and phone
                        number.
                    </div>
                </div>

                <div id="guest_fields" style="display: none;">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="guest_name">Guest Name</label>
                                <input class="form-control" type="text" name="guest_name" id="guest_name">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="guest_email">Guest Email</label>
                                <input class="form-control" type="email" name="guest_email" id="guest_email">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="guest_phone">Guest Phone</label>
                                <input class="form-control" type="text" name="guest_phone" id="guest_phone">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="purpose]" class="form-label">Purpose</label>
                            <textarea name="purpose" id="purpose" class="form-control"></textarea>
                        </div>
                    </div>

                </div>

                <div class="my-5 d-inline-flex gap-4">
                    <button type="submit" class="btn btn-primary">Create Booking</button>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Cancel</a>
                </div>

            </form>
        </div>
        <!--end::Content-->
    </div>
@endsection

@push('scripts')

    <script>
        function toggleGuestFields(checkbox) {
            const guestFields = document.getElementById('guest_fields');
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

            $('#is_guest_booking').trigger('change');


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
