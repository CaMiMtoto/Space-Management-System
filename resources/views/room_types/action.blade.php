<div class="d-flex flex-shrink-0 gap-2">
    <a class="btn btn-icon btn-light-primary btn-sm rounded-2 js-edit" href="{{ route('admin.rooms.types.show',encodeId( $roomType->id)) }}">
        <i class="bi bi-pencil"></i>
    </a>
    <a class="btn btn-icon btn-light-danger btn-sm rounded-2 js-delete" href="{{ route('admin.rooms.types.destroy', encodeId($roomType->id)) }}">
        <i class="bi bi-trash"></i>
    </a>
</div>
