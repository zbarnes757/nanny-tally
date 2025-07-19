@props(['entry'])

<tr id="entry-{{ $entry->id }}" hx-put="{{ route('entries.update', $entry) }}" hx-target="#entry-{{ $entry->id }}"
    hx-swap="outerHTML" hx-include="find input" class="bg-gray-100">

    <td class="px-6 py-4"><input type="date" name="entry_date" value="{{ $entry->entry_date }}"
            class="block w-full rounded-md border-gray-300 text-sm"></td>
    <td class="px-6 py-4"><input type="time" name="start_time"
            value="{{ \Carbon\Carbon::parse($entry->start_time)->format('H:i') }}"
            class="block w-full rounded-md border-gray-300 text-sm"></td>
    <td class="px-6 py-4"><input type="time" name="end_time"
            value="{{ \Carbon\Carbon::parse($entry->end_time)->format('H:i') }}"
            class="block w-full rounded-md border-gray-300 text-sm"></td>
    <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ number_format($entry->total_hours ?? 0, 2) }}</td>
    <td class="px-6 py-4"><input type="text" name="notes" value="{{ $entry->notes }}"
            class="block w-full rounded-md border-gray-300 text-sm"></td>
    <td class="px-6 py-4 text-right">
        <div class="flex items-center justify-end space-x-2">
            <button type="submit" class="px-3 py-1 text-sm text-white bg-green-600 rounded-md hover:bg-green-700">
                Save
            </button>
            <button class="px-3 py-1 text-sm text-white bg-gray-500 rounded-md hover:bg-gray-600"
                hx-get="{{ route('entries.show', $entry) }}" hx-target="#entry-{{ $entry->id }}" hx-swap="outerHTML">
                Cancel
            </button>
        </div>
    </td>
</tr>
