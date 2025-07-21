<div id="weekly-summary" class="flex text-lg md:text-xl font-bold text-gray-700 mt-4 pr-4" x-data="{ rate: {{ $rate ?? 20 }}, total_hours: {{ $total_hours }} }">
    <div class="flex items-center space-x-4">
        <label for="hourly-rate">Hourly Rate:</label>
        <input type="number" name="hourly-rate" id="hourly-rate" x-model="rate"
            class="w-24 text-right border rounded px-2 py-1" />
    </div>
    <span class="grow"></span>
    <div class="flex flex-col md:flex-row space-x-2">
        <span>Total This Week: {{ number_format($total_hours, 2) }} hours</span>
        <span>Amount Due: $<span x-text="(rate * total_hours).toFixed(2)"></span></span>
    </div>
</div>
