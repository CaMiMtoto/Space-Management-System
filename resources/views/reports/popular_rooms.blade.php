@extends('layouts.master')
@section('title', 'Room Utilization Report')
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
                        Popular Rooms
                    </li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
                <!--begin::Title-->
                <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0 mb-3">
                    Popular Rooms Report
                </h1>
                <p class="text-muted">
                    View Popular Rooms Report
                </p>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->

            <div class="d-flex align-items-center flex-wrap">
                {{--                    <a href="" class="btn btn-success">Export</a>--}}
            </div>
            <!--end::Actions-->
        </div>
    </div>
    <!--end::Toolbar-->

    <div class="my-3">
        <div class="">
            <div class="table-responsive">
                <table class="table table-row-dashed table-row-gray-300 gy-4" id="myTable">
                    <thead>
                    <tr class="text-start text-gray-800 fw-bold fs-7 text-uppercase">
                        <th>Room Type</th>
                        <th>Room Number</th>
                        <th>Total Bookings</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($popularRooms as $room)
                        <tr>
                            <td>{{ $room->room->roomType->name }}</td>
                            <td>{{ $room->room->room_number }}</td>
                            <td>{{ $room->booking_count }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
