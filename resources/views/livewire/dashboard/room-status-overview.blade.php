<div>
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">
        <div>
            <h4>
                Available Room
            </h4>
            <p>
                Below are available rooms overview.
            </p>
        </div>
        <div class="lg:tw-w-1/2">
            <div class="position-relative">
                <input type="text" wire:model.live.debounce="search" class="form-control form-control-sm"
                       placeholder="Search by room number or type .."/>
                <div wire:loading.flex class="position-absolute text-primary top-0 end-0 mt-2 me-2">
                    <x-lucide-loader-2 class="tw-h-6 tw-w-6 tw-animate-spin tw-text-gray-400"/>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive" wire:loading.class="opacity-50">
        <table class="table table-row-dashed table-row-gray-300 gy-1 table-condensed table-fit">
            <thead>
            <tr class="fw-bold fs-6 text-gray-800">
                <th>Room Name</th>
                <th>Type</th>
                <th>Building</th>
                <th>Capacity</th>
                {{--                <th>Status</th>--}}
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($rooms as $room)
                <tr>
                    <td>{{ $room->name }}</td>
                    <td>{{ $room->roomType->name }}</td>
                    <td>{{$room->building->name}}</td>
                    <td>{{ number_format($room->capacity) }}</td>
                    {{--       <td>
                               @if($room->isUnderMaintenance())
                                   <span class="badge bg-warning">Under Maintenance</span>
                               @else
                                   <span
                                       class="badge rounded-pill bg-{{ $room->statusColor}}-subtle">{{ $room->status }}</span>
                               @endif
                           </td>--}}
                    <td>
                        <a href="{{ route('admin.bookings.create',['type'=>$room->room_type_id,'guests'=>1,'room_id'=>$room->id]) }}"
                           class="btn btn-sm btn-light-primary py-2 px-3">
                            Book Now
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center ">
        <p>
            Showing {{ $rooms->firstItem() }} to {{ $rooms->lastItem() }} of {{ $rooms->total() }} results
        </p>
        {{ $rooms->links() }}
    </div>

</div>
