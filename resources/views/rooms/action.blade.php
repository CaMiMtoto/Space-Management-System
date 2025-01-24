{{--
<div class="d-flex gap-2">
    <a href="{{ route('admin.rooms.show',encodeId($room->id)) }}" class="btn btn-icon btn-light-primary  btn-sm js-edit" data-bs-toggle="tooltip" title="Edit">
        <span class="svg-icon svg-icon-3">
            <i class="bi bi-pencil fs-2"></i>
        </span>
    </a>
    <a href="{{ route('admin.rooms.destroy',encodeId($room->id)) }}" class="btn btn-icon btn-light-danger  btn-sm js-delete" data-bs-toggle="tooltip" title="Delete">
        <span class="svg-icon svg-icon-3">
            <i class="bi bi-trash fs-2"></i>
        </span>
    </a>
</div>
--}}
{{--dropdown--}}
<div>
    <a href="javascript:;" class="btn btn-icon btn-secondary btn-icon btn-sm" data-bs-toggle="dropdown">
        <span class="svg-icon svg-icon-3">
            <i class="bi bi-three-dots fs-2"></i>
        </span>
    </a>
    <div class="dropdown-menu dropdown-menu-end">
        <a class="dropdown-item" href="{{ route('admin.rooms.maintenances.index',encodeId($room->id)) }}">
            <i class="bi bi-wrench-adjustable fs-2"></i>
            <span class="ms-2">Maintenances</span>
        </a>
        <a class="dropdown-item js-edit" href="{{ route('admin.rooms.show',encodeId($room->id)) }}">
            <i class="bi bi-pencil fs-2"></i>
            <span class="ms-2">Edit</span>
        </a>
        <a class="dropdown-item js-delete" href="{{ route('admin.rooms.destroy',encodeId($room->id)) }}">
            <i class="bi bi-trash fs-2"></i>
            <span class="ms-2">Delete</span>
        </a>
    </div>

</div>
