<?php

namespace App\Livewire\Dashboard;

use App\Models\RoomMaintenance;
use Livewire\Component;
use Livewire\WithPagination;

class UpcomingMaintenance extends Component
{
    use WithPagination;

  protected  $queryString = ['search' => ['except' => ''], 'sortColumn', 'sortDirection'];

    public $search = '';
    public $sortColumn = 'start_date';
    public $sortDirection = 'asc';

    public function sortBy($column): void
    {
        $this->sortColumn = $column;
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        $maintenances = RoomMaintenance::query()
            ->with('room')
            ->whereDate('start_date', '>=', now()->toDateString())
            ->where(function ($query) {
                $query->where('description', 'like', '%' . $this->search . '%')
                    ->orWhereHas('room', function ($q) {
                        $q->where('room_number', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('maintenanceType', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })

            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate(10);
        return view('livewire.dashboard.upcoming-maintenance', compact('maintenances'));
    }
}
