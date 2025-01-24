<div>
    {{--    dropdown --}}
    <div class="dropdown">
        <a href="javascript:void(0);" class="btn btn-sm btn-light-primary dropdown-toggle" data-bs-toggle="dropdown"
           aria-expanded="false">Actions</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('admin.bookings.show', encodeId($booking->id)) }}">View</a></li>
            @if($booking->canBeCanceled())
              {{--  <li><a class="dropdown-item js-delete"
                       href="{{ route('admin.bookings.destroy', encodeId($booking->id)) }}">Delete</a></li>--}}
                <li><a class="dropdown-item js-cancel"
                       href="{{ route('admin.bookings.cancel',encodeId( $booking->id)) }}">Cancel</a>
                </li>
            @endif

            @if(now()->greaterThanOrEqualTo($booking->end_date) &&  strtolower($booking->status) ==\App\Constants\Status::Approved)
                <li>
                    <a class="dropdown-item js-checkout"
                       href="{{ route('admin.bookings.checkout', encodeId($booking->id)) }}">Checkout</a>
                </li>
            @endif


        </ul>
    </div>
</div>
