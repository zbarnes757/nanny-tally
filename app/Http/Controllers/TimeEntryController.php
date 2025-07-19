<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTimeEntryRequest;
use App\Models\TimeEntry;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

class TimeEntryController extends Controller
{
    public function index(): View
    {
        $entries = TimeEntry::orderByDesc('entry_date')->get();
        $total_hours = $this->calculate_total_hours($entries);

        return view('entries.index', ['entries' => $entries, 'total_hours' => $total_hours]);
    }

    public function show(TimeEntry $entry): View
    {
        return view('components.entries.table_row', ['entry' => $entry]);
    }

    public function store(StoreTimeEntryRequest $request)
    {
        TimeEntry::create($request->validated());

        return to_route('entries.index');
    }

    public function edit(TimeEntry $entry): View
    {
        return view('components.entries.edit_entry_form', ['entry' => $entry]);
    }

    public function destroy(TimeEntry $entry)
    {
        $entry->delete();

        $entries = TimeEntry::orderByDesc('entry_date')->get();
        $total_hours = $this->calculate_total_hours($entries);

        return view('entries.index', ['entries' => $entries, 'total_hours' => $total_hours])->fragment('entries-table');
    }

    /**
     * @param Collection<int, TimeEntry> $entries
     * @return float
     */
    private function calculate_total_hours(Collection $entries): float
    {
        return $entries->reduce(fn (float $accum, TimeEntry $entry) => $accum + $entry->hours(), initial: 0.0);
    }
}
