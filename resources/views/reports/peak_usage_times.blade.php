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
                        Peak Usage Time
                    </li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
                <!--begin::Title-->
                <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0 mb-3">
                   Room Peak Usage Time Report
                </h1>
                <p class="text-muted">
                     View the peak usage time of rooms in a given time period.
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
    <form class="d-flex flex-row w-100 align-items-end gap-3" action="" method="GET">
        <div class="col-md-3">
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date Time</label>
                <input type="datetime-local" class="form-control form-control-sm" name="start_date" id="start_date"
                       value="{{ request('start_date') }}"/>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date Time</label>
                <input type="datetime-local" class="form-control form-control-sm" name="end_date" id="end_date"
                       value="{{ request('end_date') }}"/>
            </div>
        </div>

        <div class="col-md-3">
            <div class="mb-3">
                <button type="submit" class="btn btn-primary btn-sm">
                    Filter Report
                </button>
            </div>
        </div>
    </form>
    <div class="my-3">
        <div class="">
            <div class="table-responsive">
                <table class="table table-row-dashed table-row-gray-300 gy-4" id="myTable">
                    <thead>
                    <tr class="text-start text-gray-800 fw-bold fs-7 text-uppercase">
                        <th>Hour of Day</th>
                        <th>Total Bookings</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($peakUsageTimes as $usage)
                        <tr>
                            <td>{{ $usage->hour_of_day }}:00</td>
                            <td>{{ $usage->booking_count }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
