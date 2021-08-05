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
        return $this->gender === self::GENDER_OTHER || $this->gender === null;
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

    public function formatGender(): string
    {
        return self::GENDERS[$this->gender];
    }

    public function formatUnit(): string
    {
        return self::LENGTH_UNITS[$this->unit];
    }

    public function formatFriendState(): ?string
    {
        $user = auth()->user();

        if ($user->id === $this->id) {
           return null;
        }

        if ($this->requestReceived($user)) {
            return Friend::REQUEST_RECEIVED;
        }

        if ($this->isFriends($user)) {
            return Friend::ARE_FRIENDS;
        }

        if ($this->requestSent($user)) {
            return Friend::REQUEST_SENT;
        }

        return null;
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
        $owner = $this->isOwner();

        return [
            'id'       => $this->id,
            'username' => $this->username,
            'email'    => $owner ? $this->email : null,
            'gender'    => [
                'id' => $this->gender,
                'formatted' => $this->formatGender(),
            ],
            'birthdate'    => [
                'date' => $this->birthdate,
                'formatted' => $this->birthdate?->format('m/d/Y'),
            ],
            'sports'    => $this->sports->toArray(),
            'stats'     => [
                'friends' => $this->friends()->count(),
                'hosting' => $this->hosting->count(),
                'going'   => $this->going()->count(),
            ],
            'unit'    => [
                'id' => $this->unit,
                'formatted' => $this->formatUnit(),
            ],
            'location' => $owner ? [
                'id'        => $this->place?->id,
                'lat'       => $this->location?->getLat(),
                'lng'       => $this->location?->getLng(),
                'formatted' => $this->place?->formatted_address,
            ] : null,
            'bio' => $this->bio,
            'timezone' => $this->timezone?->toArray(),
            'image'    => $this->image(),
        ];
    }

    public function canAddReview(): bool
    {
        $user = auth()->user();

        return $this->hosting()->whereHas('registrations', function($q) {
                $q->where('user_id', auth()->id());
            })->exists()
            || $this->hosted()->whereHas('registrations', function ($q) {
                $q->where('user_id', auth()->id());
            })->exists()
            || $user->hosting()->whereHas('registrations', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->exists()
            || $user->hosted()->whereHas('registrations', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->exists();
    }

    public function isOwner(): bool
    {
        return $this->id === auth()->id();
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
