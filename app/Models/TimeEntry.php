<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeEntry extends Model
{
    /** @use HasFactory<\Database\Factories\TimeEntryFactory> */
    use HasFactory;

    protected $fillable = [
        'entry_date',
        'start_time',
        'end_time',
        'notes',
    ];

    public function hours(): float
    {
        $start = CarbonImmutable::parseFromLocale($this->start_time);
        $end = CarbonImmutable::parseFromLocale($this->end_time);

        return $start->diffInHours($end);
    }
}
