<tr @class([
    'hover:bg-gray-50' => !$is_editing,
    'bg-gray-100' => $is_editing,
])>
    @if ($is_editing)
        <td class="px-6 py-4">
            <input type="date" wire:model="form.entry_date" class="block w-full rounded-md border-gray-300 text-sm">
            @error('form.entry_date')
                <span class="error">{{ $message }}</span>
            @enderror
        </td>
        <td class="px-6 py-4">
            <input type="time" wire:model="form.start_time" class="block w-full rounded-md border-gray-300 text-sm">
            @error('form.start_time')
                <span class="error">{{ $message }}</span>
            @enderror
        </td>
        <td class="px-6 py-4">
            <input type="time" wire:model="form.end_time" class="block w-full rounded-md border-gray-300 text-sm">
            @error('form.end_time')
                <span class="error">{{ $message }}</span>
            @enderror
        </td>
        <td class="px-6 py-4 text-sm font-semibold text-gray-900">
            {{ number_format($entry->hours() ?? 0, 2) }}
        </td>
        <td class="px-6 py-4">
            <input type="text" wire:model="form.notes" class="block w-full rounded-md border-gray-300 text-sm">
            @error('form.notes')
                <span class="error">{{ $message }}</span>
            @enderror
        </td>
        <td class="px-6 py-4 text-right">
            <div class="flex items-center justify-end space-x-2" wire:replace>
                <button type="submit" class="px-3 py-1 text-sm text-white bg-green-600 rounded-md hover:bg-green-700"
                    wire:click="update">
                    Save
                </button>
                <button class="px-3 py-1 text-sm text-white bg-gray-500 rounded-md hover:bg-gray-600"
                    wire:click="$toggle('is_editing')">
                    Cancel
                </button>
            </div>
        </td>
    @else
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
            {{ number_format($entry->hours() ?? 0, 2) }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
            {{ $entry->notes }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <div class="flex items-center justify-end space-x-2" wire:replace>
                <button class="px-3 py-1 text-sm text-white bg-gray-600 rounded-md hover:bg-gray-700"
                    wire:click="$toggle('is_editing')">
                    Edit
                </button>
                <button class="px-3 py-1 text-sm text-white bg-red-600 rounded-md hover:bg-red-700"
                    wire:click='$parent.delete_entry({{ $entry->id }})'
                    wire:confirm="Are you sure you want to delete this entry?">
                    Delete
                </button>
            </div>
        </td>
    @endif
</tr>
