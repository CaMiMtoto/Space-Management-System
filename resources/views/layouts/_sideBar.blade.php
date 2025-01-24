<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true"
     data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}"
     data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start"
     data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Main-->
    <div
        class="d-flex flex-column justify-content-between h-100 hover-scroll-overlay-y my-2 d-flex flex-column"
        id="kt_app_sidebar_main" data-kt-scroll="true" data-kt-scroll-activate="true"
        data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header"
        data-kt-scroll-wrappers="#kt_app_main" data-kt-scroll-offset="5px">
        <!--begin::Sidebar menu-->
        <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false"
             class="flex-column-fluid menu menu-sub-indention menu-column menu-rounded menu-active-bg mb-7">
            <!--begin:Menu item-->
            <div class="menu-item ">
                <!--begin:Menu link-->
                <a href="{{ route('admin.dashboard') }}"
                   class="menu-link {{ request()->fullUrl() ==route('admin.dashboard')?'active':'' }}">
                    <div class="menu-icon">
                        <x-lucide-gauge class="tw-w-6 tw-h-6"/>
                    </div>
                    <span class="menu-title">Dashboard</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->
            @can(\App\Constants\Permission::ReviewBookingAppointments)
                <!--begin:Menu item-->
                <div class="menu-item ">
                    <!--begin:Menu link-->
                    <a href="{{ route('admin.appointments.index') }}"
                       class="menu-link {{ request()->fullUrl() ==route('admin.appointments.index')?'active':'' }}">
                        <div class="menu-icon">
                            <x-lucide-calendar-clock class="tw-w-6 tw-h-6"/>
                        </div>
                        <span class="menu-title">Appointments</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->
            @endcan



            <!--end:Menu item-->
            <div data-kt-menu-trigger="click"
                 class="menu-item menu-accordion {{ Str::of(request()->url())->contains('/admin/bookings')?'show':'' }}">
                <!--begin:Menu link-->
                <span class="menu-link">
                        <span class="menu-icon">
                              <x-lucide-folders class="tw-w-6 tw-h-6"/>
                        </span>
                        <span class="menu-title">
                            Bookings
                        </span>
                        <span class="menu-arrow"></span>
                    </span>
                <!--end:Menu link-->

                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">
                    @can(\App\Constants\Permission::SUBMIT_BOOKING)
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->url()==route('admin.bookings.create')?'active':'' }}"
                           href="{{ route('admin.bookings.create') }}">
                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                            <span class="menu-title">New Booking</span>
                        </a>
                        <!--end:Menu link-->
                    @endcan

                    <!--begin:Menu link-->
                    <a class="menu-link {{ request()->fullUrlWithoutQuery(['type'=>'all'])==route('admin.bookings.index')?'active':'' }}"
                       href="{{ route('admin.bookings.index') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">My Bookings</span>
                    </a>
                    <!--end:Menu link-->
                    @canany([\App\Constants\Permission::ReviewBooking,\App\Constants\Permission::CancelBooking])
                        <!--begin:Menu link-->
                        <a class="menu-link {{ request()->fullUrlWithoutQuery(['type'=>'all'])==route('admin.bookings.index',['type'=>'all'])?'active':'' }}"
                           href="{{ route('admin.bookings.index',['type'=>'all']) }}">
                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                            <span class="menu-title">All Bookings</span>
                        </a>
                        <!--end:Menu link-->
                    @endcanany
                </div>
                <!--end:Menu item-->

            </div>


            <!--end:Menu item-->
            @canany([\App\Constants\Permission::MANAGE_BUILDINGS,\App\Constants\Permission::MANAGE_BUILDING_TYPES])
                <div data-kt-menu-trigger="click"
                     class="menu-item menu-accordion {{ Str::of(request()->url())->contains('/admin/buildings')?'show':'' }}">

                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <x-lucide-building-2 class="tw-w-6 tw-h-6"/>
                        </span>
                        <span class="menu-title">
                            Manage Buildings
                        </span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->


                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        @can(\App\Constants\Permission::MANAGE_BUILDINGS)
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->url()==route('admin.buildings.index')?'active':'' }}"
                               href="{{ route('admin.buildings.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Buildings</span>
                            </a>
                            <!--end:Menu link-->
                        @endcan
                        @can(\App\Constants\Permission::MANAGE_BUILDING_TYPES)
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->url()==route('admin.buildings.types.index')?'active':'' }}"
                               href="{{ route('admin.buildings.types.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Building Types</span>
                            </a>
                            <!--end:Menu link-->
                        @endcan
                    </div>
                    <!--end:Menu item-->

                </div>
            @endcanany

            @canany([\App\Constants\Permission::MANAGE_ROOM_TYPES,\App\Constants\Permission::MANAGE_ROOM_TYPES])
                <div data-kt-menu-trigger="click"
                     class="menu-item menu-accordion {{ Str::of(request()->url())->contains('/admin/rooms')?'show':'' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
										<span class="menu-icon">
                                            <x-lucide-bed-double class="tw-w-6 tw-h-6"/>
										</span>
										<span class="menu-title">
                                            Manage Rooms
                                        </span>
										<span class="menu-arrow"></span>
									</span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        @can(\App\Constants\Permission::MANAGE_ROOMS)
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->url()==route('admin.rooms.index')?'active':'' }}"
                               href="{{ route('admin.rooms.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Rooms</span>
                            </a>
                            <!--end:Menu link-->
                        @endcan

                        @can(\App\Constants\Permission::MANAGE_ROOM_TYPES)
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->url()==route('admin.rooms.types.index')?'active':'' }}"
                               href="{{ route('admin.rooms.types.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Room Types</span>
                            </a>
                            <!--end:Menu link-->
                        @endcan
                    </div>
                    <!--end:Menu item-->
                </div>
            @endcanany

            @canany([\App\Constants\Permission::ManageServices])
                <div data-kt-menu-trigger="click"
                     class="menu-item menu-accordion {{ Str::of(request()->url())->contains('/admin/settings')?'show':'' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <x-lucide-settings class="tw-w-6 tw-h-6"/>
                        </span>
                        <span class="menu-title">
                           System Settings
                        </span>
                    <span class="menu-arrow"></span>
                </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">

                        <a class="menu-link {{ request()->url()==route('admin.settings.services.index')?'active':'' }}"
                           href="{{ route('admin.settings.services.index') }}">
                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                            <span class="menu-title">Services</span>
                        </a>
                        <!--end:Menu link-->

                    </div>
                    <!--end:Menu item-->
                </div>
            @endcanany


            @canany([\App\Constants\Permission::MANAGE_ROLES,\App\Constants\Permission::VIEW_PERMISSIONS,\App\Constants\Permission::MANAGE_USERS])
                <div data-kt-menu-trigger="click"
                     class="menu-item menu-accordion {{ Str::of(request()->url())->contains('/admin/system')?'show':'' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                         <x-lucide-users class="tw-w-6 tw-h-6"/>
                        </span>
                        <span class="menu-title">
                            User Management
                        </span>
                    <span class="menu-arrow"></span>
                </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">

                        <!--begin:Menu item-->
                        <!--begin:Menu link-->
                        @can(\App\Constants\Permission::MANAGE_USERS)
                            <a class="menu-link {{ request()->url()==route('admin.system.users.index')?'active':'' }}"
                               href="{{ route('admin.system.users.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Users</span>
                            </a>
                        @endcan
                        <!--end:Menu link-->
                        <!--begin:Menu link-->
                        @can(\App\Constants\Permission::MANAGE_ROLES)
                            <a class="menu-link  {{ request()->url()==route('admin.system.roles.index')?'active':'' }}"
                               href="{{ route('admin.system.roles.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Roles</span>
                            </a>
                            <!--end:Menu link-->
                        @endcan

                        @can(\App\Constants\Permission::VIEW_PERMISSIONS)
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->url()==route('admin.system.permissions.index')?'active':'' }}"

                               href="{{ route('admin.system.permissions.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Permissions</span>
                            </a>
                            <!--end:Menu link-->
                        @endcan

                    </div>
                    <!--end:Menu item-->
                </div>
            @endcanany
            @can(\App\Constants\Permission::reportPermissions())
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click"
                     class="menu-item menu-accordion {{ Str::of(request()->url())->contains('/admin/reports')?'show':'' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
										<span class="menu-icon">
                                         <x-lucide-file-output class="tw-w-6 tw-h-6"/>
										</span>
										<span class="menu-title">
                                            Reports
                                        </span>
										<span class="menu-arrow"></span>
									</span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">

                        <!--begin:Menu item-->
                        <div class="menu-item">
                            @can(\App\Constants\Permission::VIEW_ROOM_UTILIZATION_REPORT)
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->url()==route('admin.reports.room-utilization')?'active':'' }}"
                                   href="{{ route("admin.reports.room-utilization") }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">
                                Room Utilization
                            </span>
                                </a>
                                <!--end:Menu link-->
                            @endcan
                            @can(\App\Constants\Permission::VIEW_PEAK_USAGE_TIME_REPORT)
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->url()==route('admin.reports.peak-usage-times')?'active':'' }}"
                                   href="{{ route("admin.reports.peak-usage-times") }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">
                                Peak Usage Times
                            </span>
                                </a>
                                <!--end:Menu link-->
                            @endcan
                            @can(\App\Constants\Permission::VIEW_POPULAR_ROOMS_REPORT)
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->url()==route('admin.reports.popular-rooms')?'active':'' }}"
                                   href="{{ route("admin.reports.popular-rooms") }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">
                               Popular Rooms
                            </span>
                                </a>
                                <!--end:Menu link-->
                            @endcan
                            @can(\App\Constants\Permission::VIEW_BOOKING_REPORT)
                                <!--begin:Menu link-->
                                <a class="menu-link {{ request()->url()==route('admin.reports.booking')?'active':'' }}"
                                   href="{{ route("admin.reports.booking") }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">
                               Booking Report
                            </span>
                                </a>
                                <!--end:Menu link-->
                            @endcan

                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
            @endcan
        </div>


    </div>
    <!--end::Sidebar menu-->

</div>
<!--end::Main-->
