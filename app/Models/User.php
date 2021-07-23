<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Models;

use App\Models\User\Traits\UserMethod;
use App\Models\User\Traits\UserRelationship;
use Carbon\Carbon;
use GeoJson\Geometry\Point;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property int $id
 * @property int $timezone_id
 * @property int $place_id
 * @property Point|null $location
 * @property string $username
 * @property string $name
 * @property string $bio
 * @property Carbon $birthdate
 * @property int $gender
 * @property int $unit
 * @property string $email
 * @property Carbon $email_verified_at
 * @property string $password
 * @property string $two_factor_secret
 * @property string $two_factor_recovery_codes
 * @property string $remember_token
 * @property string $profile_photo_path
 * @property string $image
 * @property string $provider_id
 * @property string $provider
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable,
        UserRelationship,
        UserMethod,
        SpatialTrait;

    protected $guard = 'users';

    protected $casts = [
        'id' => 'int',
        'timezone_id' => 'int',
        'place_id' => 'int',
        'username' => 'string',
        'name' => 'string',
        'bio' => 'string',
        'birthdate' => 'date',
        'gender' => 'int',
        'unit' => 'int',
        'email' => 'string',
        'email_verified_at' => 'datetime',
        'password' => 'string',
        'two_factor_secret' => 'string',
        'two_factor_recovery_codes' => 'string',
        'remember_token' => 'string',
        'profile_photo_path' => 'string',
        'image' => 'string',
        'provider_id' => 'string',
        'provider' => 'string',
        'created_at' => 'datetime',
    ];

    protected $fillable = [
        'username',
        'email',
        'password',
        'birthdate',
        'gender',
        'unit',
        'timezone_id',
        'provider_id',
        'provider',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public $spatialFields = [
        'location'
    ];

    public const MI_UNIT = 1;
    public const KM_UNIT = 2;

    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;
    public const GENDER_OTHER = 3;

    public const LENGTH_UNITS = [
        self::MI_UNIT => 'mi',
        self::KM_UNIT => 'km',
    ];

    public const GENDERS = [
        self::GENDER_MALE => 'Male',
        self::GENDER_FEMALE => 'Female',
        self::GENDER_OTHER => 'Rather not say',
    ];

    public const PUBLIC_AVATARS_DIRECTORY = 'storage/avatars/';
    public const AVATARS_DIRECTORY = 'app/public/avatars/';
}
