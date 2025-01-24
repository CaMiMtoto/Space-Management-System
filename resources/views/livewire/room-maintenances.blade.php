<div>
    <!-- Search Input -->
    <div class="d-flex justify-content-between mb-3">
        <div>
            <h5>
                <strong>{{ $room->name }}</strong> Maintenances
            </h5>
        </div>
        <div class="position-relative">
            <span class="position-absolute top-50 tw-left-4 translate-middle-y text-muted">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none"
                                                                                            d="M0 0h24v24H0z"
                                                                                            fill="none"/><path
                        d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"/><path d="M21 21l-6 -6"/></svg>
            </span>
            <input type="search" class="form-control tw-pl-10" placeholder="Search..."
                   wire:model.live.debounce="search" name="search"/>
        </div>
    </div>

    <div class="table-responsive">
        <!-- Table -->
        <table class="table ps-2 align-middle  rounded table-row-dashed fs-6 g-5">
            <thead class="bg-body-secondary">
            <tr class="text-gray-800 fw-bold fs-7 text-uppercase overflow-hidden">
                <th class="tw-w-56 ps-2  tw-rounded-tl-lg">
                    <a href="#" wire:click.prevent="sortBy('start_date')"
                       class="text-decoration-none text-dark tw-min-w-32 d-inline-flex gap-2">
                        Start Date
                        @if($sortColumn == 'start_date')
                            <i class="bi bi-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="bi bi-arrow-down-up"></i>
                        @endif
                    </a>
                </th>
                <th class="tw-w-56">
                    <a href="#" wire:click.prevent="sortBy('end_date')"
                       class="text-decoration-none text-dark tw-min-w-32 d-inline-flex gap-2">
                        End Date
                        @if($sortColumn == 'end_date')
                            <i class="bi bi-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="bi bi-arrow-down-up"></i>
                        @endif
                    </a>
                </th>
                <th class="tw-w-56">

                    <a href="#" wire:click.prevent="sortBy('maintenance_type_id')"
                       class="text-decoration-none text-dark tw-min-w-32 d-inline-flex gap-2">
                        Type
                        @if($sortColumn == 'maintenance_type_id')
                            <i class="bi bi-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="bi bi-arrow-down-up"></i>
                        @endif
                    </a>
                </th>
                <th class="">
                    <a href="#" wire:click.prevent="sortBy('status')"
                       class="text-decoration-none text-dark tw-min-w-32 d-inline-flex gap-2">
                        Status
                        @if($sortColumn == 'status')
                            <i class="bi bi-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                        @else
                            <i class="bi bi-arrow-down-up"></i>
                        @endif
                    </a>
                </th>
                <th class="tw-w-56 tw-rounded-tr-lg">Options</th>
            </tr>
            </thead>
            <tbody>
            @foreach($maintenances as $maintenance)
                <tr>
                    <td class="ps-2">{{ $maintenance->start_date->toDateString() }}</td>
                    <td>{{ $maintenance->end_date->toDateString() }}</td>
                    <td>{{ $maintenance->maintenanceType->name ?? 'N/A' }}</td>
                    <td>
                    <span
                        class="badge fw-bold bg-{{ $maintenance->statusColor }}-subtle text-{{ $maintenance->statusColor }} rounded-pill">
                        <i class="bi bi-{{ $maintenance->statusIcon }} text-{{ $maintenance->statusColor }} me-1"></i>
                        {{ $maintenance->status }}
                    </span>
                    </td>
                    <td>

                        <form action="{{ route('admin.rooms.maintenances.destroy', encodeId($maintenance->id)) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this maintenance?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-light btn-light-danger rounded-pill btn-icon">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
    <!-- Pagination -->
    <div class="mt-3">
        {{ $maintenances->links() }}
    </div>
</div>
