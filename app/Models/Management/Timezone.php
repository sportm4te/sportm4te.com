<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Models\Management;

use App\Models\Management\Traits\TimezoneMethod;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $timezone
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Timezone extends Model
{
    use TimezoneMethod;

    protected $table = 'timezone';
}
