<?php

/*
| Work schedule used by the Employee Portal and the "Late" status.
| Change these instead of hard-coding times in the views.
*/

return [
    'start' => env('WORK_START', '09:00'),
    'end' => env('WORK_END', '18:00'),
    'break_minutes' => (int) env('WORK_BREAK_MINUTES', 60),
];
