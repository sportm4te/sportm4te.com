<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Management;

use App\Models\Management\Place;
use App\Models\Management\Sport;
use App\Models\User\Event;
use Carbon\Carbon;

class EventSearchService
{
    public const NEAREST_RADIUS_DISTANCE_KM = 1;
    public const DEFAULT_RADIUS_DISTANCE_KM = 25;

    private array $options = [];
    public const DATES = [
        'Today' => ['today', 1, 'day'],
        'Tommorow' => ['+1 day', '1', 'day'],
        'This Week' => ['this week, monday', 7, 'day'],
        'This Weekend' => ['this week, saturday', 2, 'day'],
        'Next Week' => ['next monday', 7, 'day'],
        'Next Weekend' => ['next week, saturday', 2, 'day'],
        'In the Next Month' => ['first day of +1 month', 1, 'month'],
        ];

    private string $link;

    public function addOption(string $option, $value)
    {
        $this->options[$option] = $value;

        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getOption(string $option)
    {
        return $this->options[$option] ?? null;
    }

    public function checkOption(string $option, $value):bool
    {
        $data = $this->options[$option] ?? [];
        return in_array($value, (array)$data);
    }

    public function link()
    {
        return $this->link;
    }

    public function query()
    {
        $params = [];
        $date = Carbon::today()->tz(auth()->user()->timezone->timezone)->toDateTimeString();

        $events = Event::with($this->options['relations'] ?? []);

        if (!empty($this->options['dates'])) {
            $events->where(function ($q) {
                foreach ($this->options['dates'] as $date) {
                    [$date, $value, $unit] = self::DATES[$date];

                    $from = Carbon::parse($date);

                    $q->orWhereBetween('start', [
                        $from->toDateString(),
                        $from->add($unit, $value)->toDateString(),
                    ]);
                }
            });
        } else {
            $params['upcoming'] = !empty($this->options['upcoming']) ;
            $events->where(!empty($this->options['upcoming']) ? 'start' : 'end', '>=', $date);
        }

        if (!empty($this->options['category_id'])) {
            $sport = Sport::find($this->options['category_id']);
            $params['sport'] = $sport->slug;
            $events->where('category_id', $this->options['category_id']);
        }

        $query = $this->options['query'] ?? null;

        $this->addOption('text', $query);

        $result = EventSearchQueryParserService::parse($query);
        if (!empty($this->options['place_id'])) {
            $place = Place::findOrFail($this->options['place_id']);
            $this->options['radius_km'] ??= self::NEAREST_RADIUS_DISTANCE_KM;
            $params['radius'] = $this->options['radius_km'];
            $params['place_id'] = $place->id;
            $params['location'] = $place->formatted_address;
            $this->addOption('gps', $place->gps);
            $this->addOption('location', $place->formatted_address);
        }

        if ($result) {
            $query = $result['text'];
            $events->where(function($q) use ($result) {
                $q->where('location', 'like', $result['location'].'%');
                $q->orWhere('location', 'like', '% '.$result['location'].' %');
                $q->orWhere('location', 'like', '% '.$result['location'].'-%');
                $q->orWhere('location', 'like', '% '.$result['location']);
            });
            $this->addOption('location', $result['location']);
            $this->addOption('text', $query);
        } else if (!empty($this->options['radius_km']) && !empty($this->options['gps'])) {
            $params['radius'] = $this->options['radius_km'];
            $params['gps'] = [
                'lat' => $this->options['gps']->getLat(),
                'lng' => $this->options['gps']->getLng(),
            ];

            $events->whereHas('place', function($q) {
                $q->distanceSphere('gps', $this->options['gps'], $this->options['radius_km'] * 1000);
            });
        }

        $events->where(function($q) use ($query) {
            $q->where('name', 'like', $query.'%');
            $q->orWhere('name', 'like', '% '.$query.' %');
            $q->orWhere('name', 'like', '% '.$query.'-%');
            $q->orWhere('name', 'like', '% '.$query);
        });

        $this->link = route(empty($params['sport']) ? 'events.list' : 'events.sport', $params);

        return $events;
    }
}
