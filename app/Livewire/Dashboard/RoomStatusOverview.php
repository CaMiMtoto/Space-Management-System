<?php

namespace App\Livewire\Dashboard;

use App\Constants\Status;
use App\Models\Room;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Application;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class RoomStatusOverview extends Component
{
    use WithPagination;
    public ?string $search = '';
    protected  $queryString = ['search' => ['except' => ''], 'sortColumn', 'sortDirection'];
    protected $paginationTheme = 'bootstrap';
    public function render(): Factory|Application|\Illuminate\Contracts\View\View|View
    {
        $rooms = Room::with(['maintenances', 'roomType','building'])
            ->when($this->search, function (Builder $query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('roomType', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('room_number', 'like', '%' . $this->search . '%');
            })
            ->where('status', '=', Status::Available)
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('livewire.dashboard.room-status-overview', compact('rooms'));
    }
}
