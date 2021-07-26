<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Models\User;

use App\Models\User\Traits\ReviewRelationship;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $author_id
 * @property int $user_id
 * @property int $stars
 * @property string $review
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Review extends Model
{
    use ReviewRelationship;

    protected $table = 'review';

    protected $fillable = [
        'user_id',
        'author_id',
    ];
}
