<?php

namespace App\Livewire\Forms;

use App\Models\TimeEntry;
use Illuminate\Validation\Rule;
use Livewire\Form;

class TimeEntryForm extends Form
{
    public ?TimeEntry $entry = null;

    public string $entry_date = '';

    public string $start_time = '';

    public string $end_time = '';

    public ?string $notes = null;

    protected function rules()
    {
        $unique_rule = Rule::unique('time_entries');
        if ($this->entry) {
            $unique_rule = $unique_rule->ignore($this->entry);
        }

        return [
            'entry_date' => [
                'required',
                $unique_rule,
                'date',
            ],
            'start_time' => 'required|date_format:H:i|before:end_time',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'notes' => 'nullable|string|max:255',
        ];
    }

    public function set_entry(TimeEntry $entry): void
    {
        $this->entry = $entry;
        $this->entry_date = $entry->entry_date;
        $this->start_time = $entry->start_time;
        $this->end_time = $entry->end_time;
        $this->notes = $entry->notes;
    }

    public function store(): void
    {
        $this->validate();

        TimeEntry::create(
            $this->pull()
        );
    }

    public function update()
    {
        $this->validate();

        $this->entry->update(
            $this->all()
        );
    }
}
