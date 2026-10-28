<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Attendance extends Model
{
    protected $table = 'attendance';

    public $timestamps = false;

    protected $fillable = ['employee_id', 'attendance_date', 'time_in', 'time_out'];

    protected function casts(): array
    {
        return ['attendance_date' => 'date'];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Clock an employee in or out for today. Used by BOTH the admin kiosk
     * and the Employee Portal so the rules live in one place.
     *
     * @return array{action: 'in'|'out'|'done', time: Carbon}
     */
    public static function toggleFor(Employee $employee): array
    {
        $now = now();

        $record = static::where('employee_id', $employee->id)
            ->whereDate('attendance_date', $now->toDateString())
            ->first();

        if (! $record) {
            static::create([
                'employee_id' => $employee->id,
                'attendance_date' => $now->toDateString(),
                'time_in' => $now->format('H:i:s'),
            ]);

            return ['action' => 'in', 'time' => $now];
        }

        if (! $record->time_out) {
            $record->update(['time_out' => $now->format('H:i:s')]);

            return ['action' => 'out', 'time' => $now];
        }

        return ['action' => 'done', 'time' => $now];
    }

    /* ---------- Display helpers used by the views ---------- */

    public function getIsLateAttribute(): bool
    {
        return substr($this->time_in, 0, 5) > config('attendance.start');
    }

    /** "present", "late" or "on-duty" — matches <x-status-badge>. */
    public function getStatusAttribute(): string
    {
        if (! $this->time_out && $this->attendance_date->isToday()) {
            return 'on-duty';
        }

        return $this->is_late ? 'late' : 'present';
    }

    public function getTimeInLabelAttribute(): string
    {
        return Carbon::parse($this->time_in)->format('g:i A');
    }

    public function getTimeOutLabelAttribute(): string
    {
        return $this->time_out ? Carbon::parse($this->time_out)->format('g:i A') : '—';
    }

    public function getTotalLabelAttribute(): string
    {
        if (! $this->time_out) {
            return '—';
        }

        $minutes = Carbon::parse($this->time_in)->diffInMinutes(Carbon::parse($this->time_out));

        return sprintf('%dh %02dm', intdiv((int) $minutes, 60), $minutes % 60);
    }
}
