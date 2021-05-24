<?php

namespace App\Http\Repositories;

use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;

class getDesiredDateRepository 
{
    public function _getDate($event, $weeks, $start, $end, $format = 'Y-m-d')
    {
        $start = new DateTime($start);
        $end = new DateTime($end);
        $oneday = new DateInterval("P1D");

        $days = array();

        /* Iterate from $start up to $end+1 day, one day in each iteration.
        We add one day to the $end date, because the DatePeriod only iterates up to,
        not including, the end date. */
        foreach (new DatePeriod($start, $oneday, $end->add($oneday)) as $day) {
            $day_num = $day->format("N"); /* 'N' number days 1 (mon) to 7 (sun) */
            $s = in_array(true, $weeks);
            if ($s) {
                $newday = $day_num == 7 ? 0:$day_num;
                if ($weeks[$newday] == true) { /* weekday */
                    $days[] = [
                        'date' => $day->format("Y-m-d"),
                        'event' => $newday,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                }
            } else {
                $days[] = [
                    'date' => $day->format("Y-m-d"),
                    'event' => $day_num,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
        }
        return $days;
    }
}
