@extends('layouts.master')
@section('title', 'Room Maintenances')
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
                            <a href="{{ route('admin.rooms.index') }}" class="text-gray-500">
                                Rooms
                            </a>
                        </li>
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                            Room Maintenances
                        </li>
                        <!--end::Item-->
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <i class="bi bi-chevron-right fs-4 text-gray-700 mx-n1"></i>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-gray-700">

                        </li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0 mb-3">
                        Room Maintenances
                    </h1>
                    <p class="text-muted">
                        Here you can manage room maintenances. You can add, edit and delete room maintenances.
                    </p>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->

                <div class="d-flex align-items-center flex-wrap gap-4">
                    <button type="button" class="btn btn-sm btn-primary px-4 py-3" id="addNew">
                        <i class="bi bi-plus fs-3"></i>
                        New Maintenance
                    </button>
                </div>

                <!--end::Actions-->
            </div>
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div class="">
            <livewire:room-maintenances :room="$room"/>
        </div>
        <!--end::Content-->

        {{--        modal--}}

        <div class="modal fade" id="newMaintenanceModal" tabindex="-1" aria-labelledby="newMaintenanceModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                       <div>
                           <h5 class="modal-title" id="newMaintenanceModalLabel">Maintenance</h5>
                           <p class="mb-0 text-muted">
                                 Add new maintenance for room {{ $room->name }}
                           </p>
                       </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.rooms.maintenances.store',encodeId($room->id)) }}" id="submitForm">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date">
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date"/>
                            </div>

                            <div class="mb-3">
                                <label for="maintenance_type_id" class="form-label">Type</label>
                                <select class="form-select" id="maintenance_type_id" name="maintenance_type_id">
                                    <option value="">Select Type</option>
                                    @foreach($maintenanceTypes as $maintenanceType)
                                        <option value="{{ $maintenanceType->id }}">{{ $maintenanceType->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addNew = document.getElementById('addNew');
            const newMaintenanceModal = new bootstrap.Modal(document.getElementById('newMaintenanceModal'));

            addNew.addEventListener('click', function () {
                newMaintenanceModal.show();
            });

            $('#submitForm').submit(function (e) {
                e.preventDefault();
                const form = $(this);
                const url = form.attr('action');
                const data = form.serialize();
                let $btn = $('#submitForm button[type="submit"]');
                $btn.prop('disabled', true);
                $btn.html('Saving...');

                // remove existing errors
                $('.is-invalid').removeClass('is-invalid')
                $('.invalid-feedback').remove();

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    success: function (response) {
                        newMaintenanceModal.hide();
                        // reload live wire component
                        if (typeof window.livewire !== 'undefined') {
                            window.livewire.emit('refreshRoomMaintenances');
                        } else {
                            location.reload();
                        }
                    },
                    error: function (response) {
                        $btn.prop('disabled', false);
                        $btn.html('Save Changes');
                        const errors = response.responseJSON.errors;
                        const error = response.responseJSON.error;
                        if (errors) {
                            Object.keys(errors).forEach(function (key) {
                                const error = errors[key];
                                $(`#${key}`).addClass('is-invalid').after(`<div class="invalid-feedback">${error}</div>`);
                            });
                        } else if (error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: error
                            });
                        }
                    }
                })
            });
        });
    </script>
@endpush
