<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Models\User;

use App\Models\User\Traits\FriendRelationship;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $friend_id
 * @property bool $confirmed
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Friend extends Model
{
    use FriendRelationship;

    protected $table = 'friend';
}
