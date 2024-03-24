<?php

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    /**
     * Determine if the token has a specific purpose.
     *
     * @param  string  $purpose
     * @return bool
     */
    public function hasPurpose($purpose)
    {
        return $this->tokenable_type === 'App\\Models\\User' && $this->name === $purpose;
    }

    /**
     * Get the user that the token belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
