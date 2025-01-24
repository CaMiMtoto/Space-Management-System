<div>
    <div class="table-responsive">
        <table class="table table-row-dashed table-row-gray-300 gy-1">
            <thead>
            <tr class="fw-bold fs-6 text-gray-800">
                <th class="fw-bold text-uppercase">Room</th>
                <th class="fw-bold text-uppercase">Start Date</th>
                <th class="fw-bold text-uppercase">End Date</th>
                <th class="fw-bold text-uppercase">Booked By</th>
                <th class="fw-bold text-uppercase">Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($recentBookings as $item)
                <tr>
                    <td>{{ $item->room->name }} ({{ $item->room->room_number }})</td>
                    <td>{{ $item->start_date->format('Y-m-d H:i') }}</td>
                    <td>{{ $item->end_date->format('Y-m-d H:i') }}</td>
                    <td>{{ $item->user->name??'Guest' }}</td>
                    <td>
                        <span
                            class="badge bg-{{ $item->statusColor }}-subtle text-{{ $item->statusColor }} rounded-pill">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.bookings.show', encodeId($item->id)) }}"
                           class="btn btn-sm btn-gray-800 btn-active-light-primary px-2">
                            View Details
                        </a>
                    </td>
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
    </div>
</div>
