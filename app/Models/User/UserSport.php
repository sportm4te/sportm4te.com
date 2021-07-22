<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Models\User;

use App\Models\User\Traits\EventMethod;
use App\Models\User\Traits\EventRelationship;
use App\Models\User\Traits\UserSportRelationship;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property int $sport_id
 * @property int $priority
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class UserSport extends Model
{
    use UserSportRelationship;

    protected $table = 'user_sport';

    protected $fillable = [
        'sport_id',
        'priority',
    ];
}
