<div>

    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h3 class="text-2xl font-semibold mb-4 border-b pb-3">Add New Entry</h3>

        <form wire:submit="save">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                <div>
                    <label for="entry_date" class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" id="entry_date" wire:model='form.entry_date' required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-4">
                    <div>
                        @error('form.entry_date')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                    <input type="time" id="start_time" wire:model='form.start_time' required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-4">
                    <div>
                        @error('form.start_time')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                    <input type="time" id="end_time" wire:model='form.end_time' required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-4">
                    <div>
                        @error('form.end_time')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                <input type="text" id="notes" wire:model='form.notes' placeholder="e.g., Stayed late"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-4">
            </div>

            <button type="submit"
                class="w-full sm:w-auto px-6 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Add Entry
            </button>
        </form>
    </div>


    <article id="entries-article" class="bg-white p-6 rounded-lg shadow-md">
        <header class="mb-4 border-b pb-3 flex">
            <h3 class="text-lg md:text-2xl font-semibold">Hours for week of
                {{ \Carbon\Carbon::parse($start_of_week)->format('D, M j') }}</h3>

            <span class="grow"></span>

            <div class="flex space-x-1">
                <button
                    class="cursor-pointer px-2 py-1 md:px-6 md:py-2 border text-base font-medium rounded-md shadow-sm hover:bg-gray-800 hover:text-white"
                    wire:click="set_start_of_week('{{ $this->previous_week_start() }}')">Previous
                    Week</button>
                <button
                    class="cursor-pointer px-2 py-1  md:px-6 md:py-2 border text-base font-medium rounded-md shadow-sm hover:bg-gray-800 hover:text-white"
                    wire:click="set_start_of_week('{{ $this->next_week_start() }}')">Next
                    Week</button>
            </div>
        </header>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes
                        </th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="entries-list">
                    @foreach ($entries as $entry)
                        <livewire:entry-item :$entry :key="'time-entry-' . $entry->id" />
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($entries->isNotEmpty())
            <livewire:time-entry.total-hours :$entries />
        @endif
    </article>
</div>
