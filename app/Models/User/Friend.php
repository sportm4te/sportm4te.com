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

    const REQUEST_RECEIVED = 'request_received';
    const ARE_FRIENDS = 'are_friends';
    const REQUEST_SENT = 'request_sent';

    protected $table = 'friend';
}
