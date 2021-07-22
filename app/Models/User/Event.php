<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Models\User;

use App\Models\User\Traits\EventMethod;
use App\Models\User\Traits\EventRelationship;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property int $parent_id
 * @property int $privacy
 * @property int $category_id
 * @property int $place_id
 * @property string $name
 * @property string $location
 * @property int $level
 * @property string $description
 * @property Carbon $start
 * @property Carbon $end
 * @property Carbon|null $deadline
 * @property int $registration_limit
 * @property int $timezone_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 */
class Event extends Model
{
    use SoftDeletes,
        EventMethod,
        EventRelationship;

    protected $table = 'event';
    protected $casts = [
        'id' => 'int',
        'user_id' => 'int',
        'parent_id' => 'int',
        'privacy' => 'int',
        'category_id' => 'int',
        'place_id' => 'int',
        'name' => 'string',
        'location' => 'string',
        'level' => 'int',
        'description' => 'string',
        'start' => 'datetime',
        'end' => 'datetime',
        'deadline' => 'datetime',
        'registration_limit' => 'int',
        'timezone_id' => 'int',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $spatialFields = [
        'gps'
    ];

    public const LEVELS = [
        1 => 'Semi-Professional',
        2 => 'Professional',
        3 => 'Casual',
    ];

    public const PRIVACY_PUBLIC = 1;
    public const PRIVACY_PRIVATE = 2;

    public const PUBLIC_COVERS_DIRECTORY = 'storage/covers/';
    public const COVERS_DIRECTORY = 'app/public/covers/';
}
