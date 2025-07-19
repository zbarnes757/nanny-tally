<?php

namespace App\Livewire\TimeEntry;

use App\Models\TimeEntry;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class TotalHours extends Component
{
    #[Reactive]
    public $entries;

    public function render()
    {
        $total_hours = $this->entries->reduce(function (float $accum, TimeEntry $entry) {
            return $accum + $entry->hours();
        }, initial: 0.0);

        return view('livewire.time-entry.total-hours', ['total_hours' => $total_hours]);
    }
}
