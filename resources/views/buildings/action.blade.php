<div class="d-flex gap-2">
    <a href="{{ route('admin.buildings.show',encodeId($building->id)) }}" class="btn btn-icon btn-light-primary d-inline-flex justify-content-center align-items-center rounded-pill  btn-sm js-edit" data-bs-toggle="tooltip" title="Edit">
        <span class="svg-icon svg-icon-3">
            <i class="bi bi-pencil"></i>
        </span>
    </a>
    <a href="{{ route('admin.buildings.destroy',encodeId($building->id)) }}" class="btn btn-icon btn-light-danger d-inline-flex justify-content-center align-items-center rounded-pill  btn-sm js-delete" data-bs-toggle="tooltip" title="Delete">
        <span class="svg-icon svg-icon-3">
            <i class="bi bi-trash"></i>
        </span>
    </a>
</div>
