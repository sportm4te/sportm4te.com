<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Models\Event;

use App\Models\Event\Traits\TeamMethod;
use App\Models\Event\Traits\TeamRelationship;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $event_id
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Team extends Model
{
    use TeamRelationship, TeamMethod;

    protected $table = 'team';
}
