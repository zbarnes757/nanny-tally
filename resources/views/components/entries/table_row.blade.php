@props(['entry'])

<tr id="entry-{{ $entry->id }}" class="hover:bg-gray-50">
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
        {{ \Carbon\Carbon::parse($entry->entry_date)->format('D, M j') }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
        {{ \Carbon\Carbon::parse($entry->start_time)->format('g:i A') }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
        {{ \Carbon\Carbon::parse($entry->end_time)->format('g:i A') }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
        {{ number_format($entry->total_hours ?? 0, 2) }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
        {{ $entry->notes }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <div class="flex items-center justify-end space-x-2">
            <button class="px-3 py-1 text-sm text-white bg-gray-600 rounded-md hover:bg-gray-700"
                hx-get="{{ route('entries.edit', $entry) }}" hx-target="#entry-{{ $entry->id }}" hx-swap="outerHTML">
                Edit
            </button>
            <button class="px-3 py-1 text-sm text-white bg-red-600 rounded-md hover:bg-red-700"
                hx-vals='{"_method": "DELETE"}' hx-post="{{ route('entries.destroy', $entry) }}"
                hx-headers='{"X-CSRF-Token": "{{ csrf_token() }}"}'
                hx-confirm="Are you sure you want to delete this entry?" hx-target="#entries-article"
                hx-swap="outerHTML">
                Delete
            </button>
        </div>
    </td>
</tr>
