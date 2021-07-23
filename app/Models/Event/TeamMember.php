<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Models\Event;

use App\Models\Event\Traits\TeamMemberMethod;
use App\Models\Event\Traits\TeamMemberRelationship;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $team_id
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class TeamMember extends Model
{
    use TeamMemberRelationship,
        TeamMemberMethod;

    protected $table = 'team_member';

    public const TEAM_MEMBER = 'team_member';
}
