<?php

namespace App\Livewire;

use App\Livewire\Forms\TimeEntryForm;
use App\Models\TimeEntry;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Timesheet')]
class EntriesIndex extends Component
{
    public Collection $entries;

    public TimeEntryForm $form;

    #[Url(history: true)]
    public ?string $start_of_week = null;

    public function mount()
    {
        if (! $this->start_of_week) {
            $this->start_of_week = CarbonImmutable::now()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
        }

        $this->refresh_entries();
    }

    public function render()
    {
        return view('livewire.entries-index');
    }

    public function save(): void
    {
        $this->form->store();
        $this->refresh_entries();
    }

    public function delete_entry(int $entry_id): void
    {
        TimeEntry::destroy([$entry_id]);
        $this->refresh_entries();
    }

    public function set_start_of_week(string $start_of_week): void
    {
        $this->start_of_week = $start_of_week;
        $this->refresh_entries();
    }

    public function previous_week_start(): string
    {
        return CarbonImmutable::parse($this->start_of_week)
            ->subWeek()
            ->format('Y-m-d');
    }

    public function next_week_start(): string
    {
        return CarbonImmutable::parse($this->start_of_week)
            ->addWeek()
            ->format('Y-m-d');
    }

    #[On('entry-updated')]
    public function refresh_entries(): void
    {
        $start_date = CarbonImmutable::parse($this->start_of_week);
        $end_date = $start_date->addWeek();

        $this->entries = TimeEntry::orderBy('entry_date', 'desc')
            ->where('entry_date', '>=', $start_date->format('Y-m-d'))
            ->where('entry_date', '<', $end_date->format('Y-m-d'))
            ->get();
    }
}
