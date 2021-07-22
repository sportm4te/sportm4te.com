<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Models\Management;

use App\Models\Management\Traits\PlaceMethod;
use App\Models\Management\Traits\PlaceRelationship;
use Carbon\Carbon;
use GeoJson\Geometry\Point;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $place_id
 * @property int $timezone_id
 * @property string $formatted_address
 * @property string $street_number
 * @property string $subpremise
 * @property string $premise
 * @property string $route
 * @property string $sublocality_level_1
 * @property string $sublocality_level_2
 * @property string $locality
 * @property string $administrative_area_level_1
 * @property string $administrative_area_level_2
 * @property string $administrative_area_level_3
 * @property string $administrative_area_level_4
 * @property string $administrative_area_level_5
 * @property string $country
 * @property int $utc_offset
 * @property string $postal_code
 * @property Point $gps
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class Place extends Model
{
    use PlaceMethod,
        PlaceRelationship,
        SpatialTrait;

    protected $table = 'place';

    protected $fillable = [
        'place_id',
        'formatted_address',
        'street_number',
        'subpremise',
        'premise',
        'route',
        'sublocality_level_1',
        'sublocality_level_2',
        'locality',
        'administrative_area_level_1',
        'administrative_area_level_2',
        'administrative_area_level_3',
        'administrative_area_level_4',
        'administrative_area_level_5',
        'country',
        'postal_code',
        'gps',
    ];

    public $spatialFields = [
        'gps'
    ];
}
