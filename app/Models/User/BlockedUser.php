<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Models\User;

use App\Models\User\Traits\BlockedUserMethod;
use App\Models\User\Traits\BlockedUserRelationship;
use Illuminate\Database\Eloquent\Model;

class BlockedUser extends Model
{
    use BlockedUserMethod,
        BlockedUserRelationship;

    protected $table = 'blocked_user';

    protected $fillable = [
        'user_id',
        'blocked_id',
    ];
}
