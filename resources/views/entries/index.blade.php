<x-layouts.app>
    {{-- Add New Entry Form --}}
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h3 class="text-2xl font-semibold mb-4 border-b pb-3">Add New Entry</h3>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('entries.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                <div>
                    <label for="entry_date" class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" id="entry_date" name="entry_date" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        value="{{ old('entry_date') }}">
                </div>
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                    <input type="time" id="start_time" name="start_time" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        value="{{ old('start_time') }}">
                </div>
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                    <input type="time" id="end_time" name="end_time" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        value='{{ old('end_time') }}'>
                </div>
            </div>

            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                <input type="text" id="notes" name="notes" placeholder="e.g., Stayed late"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <button type="submit"
                class="w-full sm:w-auto px-6 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Add Entry
            </button>
        </form>
    </div>

    @fragment('entries-table')
        <article id="entries-article" class="bg-white p-6 rounded-lg shadow-md">
            <header class="mb-4 border-b pb-3">
                <h3 class="text-2xl font-semibold">This Week's Hours</h3>
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
                            <x-entries.table_row :entry="$entry" />
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($entries->isNotEmpty())
                <div id="weekly-summary" class="text-right text-xl font-bold text-gray-700 mt-4 pr-4">
                    Total This Week: {{ number_format($total_hours, 2) }} hours
                </div>
            @endif
        </article>
    @endfragment
</x-layouts.app>
