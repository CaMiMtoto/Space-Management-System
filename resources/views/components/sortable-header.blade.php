<a href="{{ request()->fullUrlWithQuery([
    'sort_col' => $column,
    'sort_dir' => nextSortDirection(),
    'q' => request('q'),
]) }}" class="text-decoration-none text-dark">
    {{ $label }}
    @if (isCurrentColumn())
        <i class="bi bi-chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
    @endif
</a>
