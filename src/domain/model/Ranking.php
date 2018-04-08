<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 01/04/18
 * Time: 16:33
 */

namespace MyWonderland\Domain\Model;


class Ranking
{
    /**
     * @var
     */
    private $events;

    /**
     * Ranking constructor.
     * @param $events
     */
    public function __construct($events)
    {
        $this->events = $events;
    }

    public function report()
    {
        $report = array_reduce($this->events, function($reportAccumulator, $event) {
            /**
             * @var $event Event
             */
            $key = $event->country . $event->city;
            if (isset($reportAccumulator[$key])) {
                $reportAccumulator[$key]['count'] += 1;
                return $reportAccumulator;
            }
            $reportAccumulator[$key] = [
                'country' => $event->country,
                'city' => $event->city,
                'count' => 1
            ];
            return $reportAccumulator;
        });

        usort($report, function($a, $b) {
            if ($a['count'] == $b['count']) {
                return 0;
            }
            return ($a['count'] > $b['count']) ? -1 : 1;
        });

        return $report;
    }
}