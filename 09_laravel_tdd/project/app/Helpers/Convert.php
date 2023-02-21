<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Game;

/**
 * Provides helpers static analysers.
 */
trait Convert
{
    public function convertIfString(mixed $id): int
    {
        if (gettype($id) == 'string') {
            $id = (int)$id;
        }
        if (gettype($id) != 'integer') {
            abort(500, 'Id is not an integer!');
        }
        return $id;
    }

    public function convertString(mixed $n): int|null
    {
        if ($n == null) {
            return null;
        }
        if (gettype($n) == 'string') {
            $n = (int)$n;
        }
        if (gettype($n) != 'integer') {
            abort(500, 'Age is not an integer!');
        }
        return $n;
    }
}
