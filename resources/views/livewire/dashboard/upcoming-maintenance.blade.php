<div>
    <input type="text" wire:model.live.debounce="search" placeholder="Search..."
           class="form-control form-control-sm mb-3">

    <table class="table table-row-dashed table-row-gray-300 gy-4">
        <thead>
        <tr class="fw-bold fs-6 text-gray-800">
            <th wire:click="sortBy('room_id')">Room</th>
            <th wire:click="sortBy('start_date')">Start Date</th>
            <th wire:click="sortBy('end_date')">End Date</th>
            <th wire:click="sortBy('maintenance_type_id')">Type</th>
        </tr>
        </thead>
        <tbody>
        @forelse($maintenances as $maintenance)
            <tr>
                <td>{{ $maintenance->room->room_number }}</td>
                <td>{{ $maintenance->start_date->format('Y-m-d') }}</td>
                <td>{{ $maintenance->end_date->format('Y-m-d') }}</td>
                <td>{{ $maintenance->maintenanceType->name }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">
                    <div class="alert alert-info  w-100">
                        <span>No maintenance found</span>
                    </div>
                </td>
            </tr>
        @endforelse
        <tr wire:loading>
            <td colspan="4">
                <div class="d-flex justify-content-center w-100">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span class="ms-2">Loading...</span>
                </div>
            </td>
        </tr>
        </tbody>
    </table>

    {{ $maintenances->links() }}
</div>
