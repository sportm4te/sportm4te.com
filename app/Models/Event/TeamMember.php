<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Models\Event;

use App\Models\Event\Traits\TeamMemberRelationship;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use TeamMemberRelationship;

    protected $table = 'team_member';
}
