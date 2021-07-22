<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Models\Event;

use App\Models\Event\Traits\ScoreMethod;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Score extends Model
{
    use ScoreMethod;

    protected $table = 'score';
}
