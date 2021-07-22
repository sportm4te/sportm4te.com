<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Models\Management;

use App\Models\Management\Traits\SportMethod;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $emoji
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Sport extends Model
{
    use SportMethod;

    protected $table = 'sport';
}
