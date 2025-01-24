<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SortableHeader extends Component
{

    public string $column;
    public string $label;
    public ?string $sortColumn;
    public ?string $sortDirection;
    /**
     * Create a new component instance.
     *
     * @param string $column
     * @param string $label
     * @param string|null $sortColumn
     * @param string|null $sortDirection
     */
    public function __construct(string $column, string $label, string $sortColumn = null, ?string $sortDirection = 'desc')
    {
        $this->column = $column;
        $this->label = $label;
        $this->sortColumn = $sortColumn;
        $this->sortDirection = $sortDirection;
    }

    /**
     * Determine the direction for the next sort.
     *
     * @return string
     */
    public function nextSortDirection(): string
    {
        return $this->sortColumn === $this->column && $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    /**
     * Determine if the column is the current sort column.
     *
     * @return bool
     */
    public function isCurrentColumn(): bool
    {
        return $this->sortColumn === $this->column;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string|Closure|\Illuminate\View\View
     */
    public function render(): View|string|Closure|\Illuminate\View\View
    {
        return view('components.sortable-header');
    }
}
