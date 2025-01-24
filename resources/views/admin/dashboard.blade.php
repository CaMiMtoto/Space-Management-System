@extends('layouts.master')
@section('title', 'Dashboard')
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
                        <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Dashboard</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <i class="bi bi-chevron-right fs-4 text-gray-700 mx-n1"></i>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-gray-700">
                            Analytics
                        </li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0">
                        Dashboard
                    </h1>
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
            <livewire:dashboard.room-statistics/>
            <div class="row">
                <div class="col-xl-12 mb-4">
                    <div class="card border">
                        <div class="card-body">
                            <livewire:dashboard.room-status-overview/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 mb-4 ">
                    <div id="roomUtilizationChart"></div>
                </div>
                <div class="col-xl-6 mb-4">
                    <div id="peakUsageChart"></div>
                </div>
            </div>
        </div>
        <div class="row">

            <!-- Recent Booking -->
            <div class="col-lg-12 mb-4">
                <div class="card border">
                    <div class="card-body">
                        <h3>
                            Recent Booking
                        </h3>
                        <p>
                            Below are the recent bookings made by the users.
                        </p>
                        <livewire:dashboard.recent-booking/>
                    </div>
                </div>
            </div>
            <!-- Room Statistics -->
        </div>
        <div class="row">
            <!-- Room Status Overview -->

            <!-- Upcoming Maintenance -->
            <div class="col-xl-6 mb-4">
                <div class="card border h-100">
                    <div class="card-body">
                        <h4>
                            Upcoming Maintenance
                        </h4>
                        <livewire:dashboard.upcoming-maintenance/>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Content-->
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetchRoomUtilizationData();

            function fetchRoomUtilizationData() {

                $.ajax({
                    url: '{{ route('admin.reports.room-utilization') }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        let roomNames = [];
                        let hoursBooked = [];

                        data.forEach(room => {
                            roomNames.push(room.room_number); // Customize room label
                            hoursBooked.push(room.total_hours_booked);
                        });
                        renderRoomUtilizationChart(roomNames, hoursBooked);
                    }
                });
            }

            function renderRoomUtilizationChart(roomNames, hoursBooked) {
                const options = {
                    chart: {
                        type: 'bar'
                    },
                    theme: {
                        mode: localStorage.getItem('data-bs-theme-mode'), // Detect theme
                    },
                    series: [{
                        name: 'Total Hours Booked',
                        data: hoursBooked
                    }],
                    colors: ['#023B6D'],
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            borderRadiusApplication: 'end',
                            horizontal: true,
                            width: '20%',
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: roomNames
                    },
                    title: {
                        text: 'Room Utilization (Total Hours Booked)',
                        align: 'left'
                    }
                };

                const chart = new ApexCharts(document.querySelector("#roomUtilizationChart"), options);
                chart.render();
            }

            fetchPeakUsageTimesData();

            function fetchPeakUsageTimesData() {
                $.ajax({
                    url: '{{ route('admin.reports.peak-usage-times') }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        let hoursOfDay = [];
                        let bookingCounts = [];

                        data.forEach(booking => {
                            hoursOfDay.push(booking.hour_of_day + ':00'); // Format hour for display
                            bookingCounts.push(booking.booking_count);
                        });

                        renderPeakUsageTimesChart(hoursOfDay, bookingCounts);
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                })
            }

            function renderPeakUsageTimesChart(hoursOfDay, bookingCounts) {
                const options = {
                    chart: {
                        type: 'area',
                        stacked: false,
                        zoom: {
                            type: 'x',
                            enabled: true,
                            autoScaleYaxis: true
                        },
                        toolbar: {
                            autoSelected: 'zoom'
                        }
                    },
                    markers: {
                        size: 0,
                        style: 'hollow',
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 5,
                        curve: 'smooth'
                    },
                    series: [{
                        name: 'Bookings',
                        data: bookingCounts
                    }],
                    xaxis: {
                        categories: hoursOfDay,
                        type: 'time',
                    },
                    title: {
                        text: 'Peak Room Usage Times (By Hour of Day)',
                        align: 'left'
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            inverseColors: false,
                            opacityFrom: 0.5,
                            opacityTo: 0,
                            stops: [0, 90, 100]
                        },
                    },
                };

                const chart = new ApexCharts(document.querySelector("#peakUsageChart"), options);
                chart.render();
            }

        });
    </script>
@endpush
