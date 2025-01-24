<div class="row mb-3">
    <div class="col-12">
        <div class="card card-flush mb-3 h-xl-100  ">
            <!--begin::Heading-->
            <div
                class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-200px tw-bg-cover tw-bg-top "
                style="background-image: url({{ asset('assets/media/shapes/top-green.png') }})" data-bs-theme="light">
                <!--begin::Title-->
                <div class="h4 card-title align-items-start flex-column text-white pt-4">
                    <span class="fw-bold fs-2x mb-3">
                        Overview
                    </span>
                    <div class="fs-4 text-white">
                        Below are the statistics of the rooms and their statuses.
                    </div>
                </div>
                <!--end::Title-->

                <!--begin::Toolbar-->
                <div class="card-toolbar pt-5">
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Heading-->

            <!--begin::Body-->
            <div class="card-body mt-n20 ">
                <!--begin::Stats-->
                <div class="mt-n20 position-relative">
                    <!--begin::Row-->
                    <div class="row g-3 g-lg-6">
                        <!--begin::Col-->
                        <div class="col-12 col-md-6 col-xl-3">
                            <!--begin::Items-->
                            <div class="bg-gray-100  border border-success  bg-opacity-70 rounded-2 px-6 py-5">
                                <!--begin::Symbol-->
                                <span class="text-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                                         fill="currentColor"
                                         class="icon icon-tabler icons-tabler-filled icon-tabler-bed">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path
                                            d="M3 6a1 1 0 0 1 .993 .883l.007 .117v6h6v-5a1 1 0 0 1 .883 -.993l.117 -.007h8a3 3 0 0 1 2.995 2.824l.005 .176v8a1 1 0 0 1 -1.993 .117l-.007 -.117v-3h-16v3a1 1 0 0 1 -1.993 .117l-.007 -.117v-11a1 1 0 0 1 1 -1z"/>
                                        <path
                                            d="M7 8a2 2 0 1 1 -1.995 2.15l-.005 -.15l.005 -.15a2 2 0 0 1 1.995 -1.85z"/>
                                    </svg>
                                </span>

                                <!--end::Symbol-->

                                <!--begin::Stats-->
                                <div class="m-0">
                                    <!--begin::Number-->
                                    <span
                                        class="text-success-emphasis d-block  lh-1 ls-n1 mb-1 display-5 my-4">
                                        {{number_format($availableRooms) }}
                                    </span>
                                    <!--end::Number-->

                                    <!--begin::Desc-->
                                    <span class="text-gray-500 fw-semibold fs-6">
                                      Today's Available Rooms
                                    </span>
                                    <!--end::Desc-->
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Items-->
                        </div>
                        <!--end::Col-->
                        @if(auth()->user()->is_admin)
                            <!--begin::Col-->
                            <div class="col-12 col-md-6 col-xl-3">
                                <!--begin::Items-->
                                <div class="bg-gray-100 border border-success bg-opacity-70 rounded-2 px-6 py-5">

                                <span class="svg-icon svg-icon-success">
                                 <x-lucide-book-open-check class="tw-w-[48px] tw-h-[48px]"/>
                                </span>

                                    <!--begin::Stats-->
                                    <div class="m-0">
                                        <!--begin::Number-->
                                        <span
                                            class="text-gray-700 d-block  lh-1 ls-n1 mb-1 display-5 my-4">
                                        {{number_format($totalBookings) }}
                                    </span>
                                        <!--end::Number-->

                                        <!--begin::Desc-->
                                        <span class="text-success-emphasis fw-semibold fs-6">
                                        Total Bookings
                                        <span title="Total Approved Bookings" data-bs-toggle="tooltip"
                                              data-bs-placement="right">
                                            <x-lucide-info class="tw-w-[16px] tw-h-[16px] tw-mr-1"/>
                                        </span>
                                    </span>
                                        <!--end::Desc-->
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Items-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-12 col-md-6 col-xl-3">
                                <!--begin::Items-->
                                <div class="bg-gray-100  border border-success bg-opacity-70 rounded-2 px-6 py-5">

                                <span class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         class="icon icon-tabler icons-tabler-outline icon-tabler-bed-flat">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M5 11m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/>
                                        <path d="M10 13h11v-2a3 3 0 0 0 -3 -3h-8v5z"/>
                                        <path d="M3 16h18"/>
                                    </svg>
                                </span>

                                    <!--begin::Stats-->
                                    <div class="m-0">
                                        <!--begin::Number-->
                                        <span
                                            class="text-gray-700 d-block  lh-1 ls-n1 mb-1  display-5 my-4">{{number_format($totalRooms)
                                        }}</span>
                                        <!--end::Number-->

                                        <!--begin::Desc-->
                                        <span class="text-gray-500 fw-semibold fs-6">Rooms</span>
                                        <!--end::Desc-->
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Items-->
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-12 col-md-6 col-xl-3">
                                <!--begin::Items-->
                                <div class="bg-gray-100  border border-success bg-opacity-70 rounded-2 px-6 py-5">
                                    <!--begin::Symbol-->
                                    <span class="text-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         class="icon icon-tabler icons-tabler-outline icon-tabler-tool">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path
                                            d="M7 10h3v-3l-3.5 -3.5a6 6 0 0 1 8 8l6 6a2 2 0 0 1 -3 3l-6 -6a6 6 0 0 1 -8 -8l3.5 3.5"/>
                                    </svg>
                                </span>

                                    <!--end::Symbol-->

                                    <!--begin::Stats-->
                                    <div class="m-0">
                                        <!--begin::Number-->
                                        <span
                                            class="text-danger-emphasis d-block  lh-1 ls-n1 mb-1  display-5 my-4">{{number_format($underMaintenance)
                                        }}</span>
                                        <!--end::Number-->

                                        <!--begin::Desc-->
                                        <span class="text-gray-500 fw-semibold fs-6">
                                        Under Maintenance
                                    </span>
                                        <!--end::Desc-->
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Items-->
                            </div>
                            <!--end::Col-->
                        @endif
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Stats-->
            </div>
            <!--end::Body-->
        </div>
    </div>
</div>
