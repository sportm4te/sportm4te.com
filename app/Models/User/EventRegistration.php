<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Models\User;

use App\Models\User\Traits\EventRegistrationMethod;
use App\Models\User\Traits\EventRegistrationRelationship;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $event_id
 * @property int $user_id
 * @property bool|null $approved
 * @property bool|null $seen
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class EventRegistration extends Model
{
    use EventRegistrationMethod,
        EventRegistrationRelationship;

    protected $table = 'event_registration';

    protected $casts = [
        'approved' => 'bool',
    ];

    protected $fillable = [
        'user_id',
        'event_id',
    ];

    public const MEMBER = 'member';
}
