<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Http\Controllers\Api;

use App\Models\Management\Place;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class PlaceController extends Controller
{
    public function autocomplete(Request $request) {
        $content = Http::post('https://api.swiftyper.sk/v1/earth/query', [
            'query' => $request->get('q'),
            'api_key' => config('app.swiftyper.key'),
        ]);

        try {
            $results = collect($content->json());
            $places = Place::find($results->pluck('place_id')->toArray())->keyBy('place_id');

            foreach ($results as $result) {
                if (empty($places[$result['place_id']])) {
                    $components = [];
                    $gps = $result['geometry']['location'];

                    foreach ($result['address_components'] as $component) {
                        $components[$component['types'][0]] = $component['long_name'];
                    }

                    $place = Place::firstOrNew(['place_id' => $result['place_id']]);
                    $place->fill(
                        array_merge(
                            $components,
                            [
                                'formatted_address' => $result['formatted_address'],
                                'utc_offset' => $result['utc_offset'] ?? null,
                                'place_id' => $result['place_id'],
                                'gps' => new Point($gps['lat'], $gps['lng'])
                            ]
                        )
                    );

                    $place->save();
                } else {
                    $place = $places[$result['place_id']];
                }

                $places[] = $place->toArray();
            }

            return $places;
        } catch (\Throwable $exception) {
            return [];
        }
    }
}
