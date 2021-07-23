<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Models\Management\Traits;

use App\Management\EventSearchService;

trait SportMethod
{
    public function image()
    {
        return asset('/images/sport/' . $this->slug . '.jpg');
    }

    public function search()
    {
        return route('events.sport', ['sport' => $this->slug]);
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'emoji' => $this->emoji,
        ];
    }

    public function searchAround($radius = EventSearchService::DEFAULT_RADIUS_DISTANCE_KM)
    {
        $eventSearchService = new EventSearchService();
        $eventSearchService->addOption('category_id', $this->id);
        $eventSearchService->addOption('place_id', auth()->user()->place_id);
        $eventSearchService->addOption('radius_km', $radius);
        $eventSearchService->addOption('upcoming', true);

        return $eventSearchService;
    }
}
