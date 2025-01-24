<div>

    <div class="border border-secondary border-dashed gap-5 p-3 rounded">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Capacity</th>
                    <th>Building</th>
                    <th>Floors</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <div class="fw-semibold text-gray-600">
                            {{ $room->capacity }}
                        </div>
                    </td>
                    <td>
                        <div class="fw-semibold text-gray-600">
                            {{ $room->building->name }}
                        </div>
                    </td>
                    <td>
                        <div class="fw-semibold text-gray-600">
                            {{ $room->floor }}
                        </div>
                    </td>
                    <td>
                        <div class="fw-semibold text-{{ $room->status_color }}">
                            {{ $room->status }}
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
{{--        room services--}}
        <h4 class="my-3">
            Services
        </h4>
       <div class="row">
           @forelse($room->services()->get() as $service)
               <div class="col-lg-4 col-xl-3">
                   <div class="my-2">
                   <x-lucide-check-square class="tw-h-6 tw-w-6 text-success"/>    {{ $service->name }} (<span class="text-muted">{{$service->fee==0?'Free':number_format($service->fee,0)}}</span>)
                   </div>
               </div>
           @empty
               <div class="col-12">
                   <div class="alert alert-info">
                       No services available fo the selected room.
                   </div>
               </div>
           @endforelse

       </div>
    </div>
</div>
