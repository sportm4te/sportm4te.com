<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Models\User\Traits;


use App\Models\User;
use App\Models\User\Friend;
use Illuminate\Support\Collection;
use Webpatser\Uuid\Uuid;

trait UserMethod
{
    public function isFriends(User $user): bool
    {
        return $this->friends()->where('id', $user->id)->isNotEmpty();
    }

    public function isMale(): bool
    {
        return $this->gender === self::GENDER_MALE;
    }

    public function isFemale(): bool
    {
        return $this->gender === self::GENDER_FEMALE;
    }

    public function isWithoutGender(): bool
    {
        return $this->gender === self::GENDER_OTHER;
    }

    public function requestSent(User $user): bool
    {
        return Friend::where('user_id', $user->id)->where('friend_id', $this->id)->whereNull('confirmed')->first() !== null;
    }

    public function requestReceived(User $user): bool
    {
        return Friend::where('user_id', $this->id)->where('friend_id', $user->id)->whereNull('confirmed')->first() !== null;
    }

    public function link(): string
    {
        return route('profile', [$this->id]);
    }

    public function formatUnit(): string
    {
        return self::LENGTH_UNITS[$this->unit];
    }

    public function image(): string
    {
        if ($this->hasImage()) {
            return url(self::PUBLIC_AVATARS_DIRECTORY . $this->getImageFileName()) . '?h=' . filemtime($this->path());
        }

        if ($this->isMale()) {
            return url('/images/avatars/male.png');
        }

        if ($this->isFemale()) {
            return url('/images/avatars/female.png');
        }

        if ($this->isWithoutGender()) {
            return url('/images/avatars/gender.png');
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->formatName()) . '&color=1BB76E&background=EBFFED';
    }

    public function hasImage(): bool
    {
        return file_exists($this->path());
    }

    public function getImageFileName(): string
    {
        return Uuid::generate(5, 'sm:u' . $this->id, Uuid::NS_DNS) . '.jpg';
    }

    public function path(): string
    {
        return storage_path(self::AVATARS_DIRECTORY . $this->getImageFileName());
    }

    public function friends(): Collection
    {
        return $this->myFriends->merge($this->friendsOf);
    }

    public function formatName(): string
    {
        return $this->name ?? $this->username;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->formatName(),
            'email' => $this->email,
            'location' => [
                'id' => $this->place ? $this->place->id : null,
                'lat' => $this->location ? $this->location->getLat() : null,
                'lng' => $this->location ? $this->location->getLng() : null,
                'formatted' => $this->place ? $this->place->formatted_address : null,
            ],
            'timezone' => $this->timezone ? $this->timezone->toArray() : null,
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
