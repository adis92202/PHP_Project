<?php

namespace App\Helpers;

use App\Models\Auction;
use App\Models\Event;
use App\Models\User;
use App\Models\Game;

/**
 * Provides helpers static analysers.
 */
trait HasEnsure
{
    public function ensureIsGame(mixed $game): Game
    {
        if (!($game instanceof Game)) {
            abort(500, 'Not in database');
        }
        return $game;
    }

    public function ensureIsEvent(mixed $event): Event
    {
        if (!($event instanceof Event)) {
            abort(500, 'Not in database');
        }
        return $event;
    }

    public function ensureIsAuction(mixed $auction): Auction
    {
        if (!($auction instanceof Auction)) {
            abort(500, 'Not in database');
        }
        return $auction;
    }
    public function ensureIsUser(mixed $user): User
    {
        if (!($user instanceof User)) {
            abort(500, 'Not in database');
        }
        return $user;
    }


    public function ensureIsString(mixed $object): string
    {
        if (gettype($object) != 'string') {
            abort(500, '$object is not a string!');
        }
        return $object;
    }

    public function ensureIsInteger(mixed $object): int
    {
        if (gettype($object) != 'integer') {
            abort(500, '$object is not a integer!');
        }
        return $object;
    }

    public function ensureIsStringOrNull(mixed $object): string|null
    {
        return $object ? $this->ensureIsString($object) : null;
    }

    public function ensureIsNotNullUser(User|null $user): User
    {
        if ($user) {
            return $user;
        }
        abort(500, '$user is null!');
    }


    public static function ensureIsNotNullUser2(User|null $user): User
    {
        if ($user) {
            return $user;
        }
        abort(500, '$user is null!');
    }

    /**
     * @return mixed[]
     */
    public function ensureIsArray(mixed $array): array
    {
        if (is_array($array)) {
            return $array;
        }
        abort(500, '$array is an array!');
    }
}
