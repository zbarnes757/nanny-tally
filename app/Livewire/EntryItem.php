<?php

namespace App\Livewire;

use App\Livewire\Forms\TimeEntryForm;
use App\Models\TimeEntry;
use Livewire\Component;

class EntryItem extends Component
{
    public TimeEntry $entry;

    public TimeEntryForm $form;

    public bool $is_editing;

    public function mount()
    {
        $this->form->set_entry($this->entry);
    }

    public function render()
    {
        return view('livewire.entry-item');
    }

    public function update()
    {
        $this->form->update();
        $this->is_editing = false;
        $this->entry->refresh();
        $this->dispatch('entry-updated')->to(EntriesIndex::class);
    }
}
