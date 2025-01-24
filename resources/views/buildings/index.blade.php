@extends('layouts.master')
@section('title', 'Buildings')
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
                            Buildings
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <i class="bi bi-chevron-right fs-4 text-gray-700 mx-n1"></i>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-gray-700">
                            Manage Buildings
                        </li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0 mb-3">
                        Buildings
                    </h1>
                    <p class="text-muted">
                        Here you can manage Buildings. You can add, edit or delete Buildings.
                    </p>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <button type="button" class="btn btn-sm btn-light-primary px-4 py-3" id="addBtn">
                    <i class="bi bi-plus fs-3"></i>
                    Add New
                </button>
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
                        <th>Created At</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Address</th>
                        <th>Floors</th>
                        <th>Rooms</th>
                        <th>Status</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!--end::Content-->
    </div>



    <div class="modal fade" tabindex="-1" id="myModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        Building
                    </h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <i class="bi bi-x"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form action="{{ route('admin.buildings.store') }}" id="submitForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id" name="id" value="0"/>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder=""/>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">Type</label>
                                    <select class="form-select" id="building_type_id" name="building_type_id">
                                        <option value="">Select Type</option>
                                        @foreach($buildingTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder=""/>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="floors" class="form-label">Floors</label>
                                    <input type="number" class="form-control" id="floors" name="floors" placeholder=""/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="rooms" class="form-label">Rooms</label>
                                    <input type="number" class="form-control" id="rooms" name="rooms" placeholder=""/>
                                </div>
                            </div>
                        </div>


                        <div class="mb-3">
                            <label for="intended_use" class="form-label">
                                Intended Use
                            </label>
                            <textarea class="form-control" id="intended_use" name="intended_use"
                                      placeholder=""></textarea>
                        </div>


                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description"
                                      placeholder=""></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="images" class="form-label">Images</label>
                            <input type="file" class="form-control" id="images" multiple accept="image/*"
                                   name="images[]"
                                   placeholder=""/>
                        </div>


                    </div>

                    <div class="modal-footer bg-light">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn bg-secondary text-light-emphasis" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function () {
            window.dt = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! request()->fullUrl() !!}",
                language: {
                    loadingRecords: '&nbsp;',
                    processing: '<div class="spinner spinner-primary spinner-lg mr-15"></div> Processing...'
                },
                columns: [
                    {
                        data: 'created_at', name: 'created_at',
                        render: function (data) {
                            return moment(data).format('DD-MM-YYYY');
                        }
                    },
                    {data: 'name', name: 'name'},
                    {data: 'building_type.name', name: 'buildingType.name'},
                    {data: 'address', name: 'address'},
                    {data: 'floors', name: 'floors'},
                    {data: 'rooms', name: 'rooms'},
                    {
                        data: 'status', name: 'status',
                        render: function (data, type, row) {
                            return `<span class="badge bg-${row.status_color}-subtle rounded-pill text-${row.status_color}">${data}</span>`;
                        }
                    },
                    {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'},
                ],
            });

            $('#addBtn').click(function () {
                $('#myModal').modal('show');
            });
            $('#myModal').on('hidden.bs.modal', function () {
                $('#submitForm').trigger('reset');
                $('#id').val(0);
            });

            let submitForm = $('#submitForm');
            submitForm.submit(function (e) {
                e.preventDefault();
                let $this = $(this);
                let formData = new FormData(this);
                let id = $('#id').val();
                let url = $this.attr('action');
                let btn = $(this).find('[type="submit"]');
                btn.prop('disabled', true);
                btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
                // remove the error text
                $this.find('.error').remove();
                // remove the error class
                $this.find('.is-invalid').removeClass('is-invalid');
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        dt.ajax.reload();
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Record has been saved successfully.',
                            // showConfirmButton: false,
                            // timer: 1500
                        });

                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function (key, value) {
                                let $1 = $('#' + key);
                                $1.addClass('is-invalid');
                                // create span element under the input field with a class of invalid-feedback and add the error text returned by the validator
                                $1.parent().append('<span class="text-danger error">' + value[0] + '</span>');
                            });
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: xhr.responseJSON?.error ?? 'Something went wrong! Please try again.'
                            });
                        }
                    },
                    complete: function () {
                        btn.prop('disabled', false);
                        btn.html('Save changes');
                    }
                });
            });

            $(document).on('click', '.js-edit', function (e) {
                e.preventDefault();
                let url = $(this).attr('href');
                $(this).addClass('disabled spinner spinner-primary spinner-sm');
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (data) {
                        $('#myModal').modal('show');
                        $('#id').val(data.id);
                        $('#name').val(data.name);
                        $('#building_type_id').val(data.building_type_id);
                        $('#address').val(data.address);
                        $('#status').val(data.status);
                        $('#floors').val(data.floors);
                        $('#rooms').val(data.rooms);
                        $('#intended_use').val(data.intended_use);
                        $('#description').val(data.description);
                    },
                    error: function (xhr) {
                        console.log(xhr);
                    },
                    complete: function () {
                        $(this).removeClass('disabled spinner spinner-primary spinner-sm');
                    }
                });
            });
        });
    </script>
@endpush
