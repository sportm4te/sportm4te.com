<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Models\Management\Traits;

use App\Models\Management\Timezone;
use Illuminate\Support\Facades\Http;

trait PlaceMethod
{
    public function toArray()
    {
        return [
            'id' => $this->id,
            'location' => $this->formatted_address,
            'place_id' => $this->place_id,
            'gps' => $this->gps,
        ];
    }

    public function saveMissingTimezone()
    {
        if (empty($this->timezone_id)) {
            $result = Http::post('https://api.swiftyper.sk/v1/earth/timezone', [
                'lat' => $this->gps->getLat(),
                'lng' => $this->gps->getLng(),
                'api_key' => config('app.swiftyper.key'),
            ])->json();

            if (!empty($result)) {
                $timezone = Timezone::where('timezone', $result['timezone'])->first();

                if ($timezone !== null) {
                    $this->timezone_id = $timezone->id;
                    $this->save();
                }
            }
        }
    }
}
