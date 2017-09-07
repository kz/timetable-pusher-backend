<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }

    /**
     * Gets a user by token (or null if the user does not exist)
     *
     * @param $token
     * @return User | null
     */
    public static function getUserByToken($token)
    {
        $user = DB::table('users')->where('api_token', $token)->first();

        return $user ?: null;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Set an API token for the user
            $model->api_token = self::generateUniqueApiToken();
        });
    }

    /**
     * Generates a unique API token for the user
     *
     * @return string
     */
    public static function generateUniqueApiToken()
    {
        $loopCount = 0;
        while ($loopCount < 100) {
            $loopCount += 1;

            // Generate an API token
            $apiToken = strtoupper(str_random(20));

            // Ensure that the token does not exist
            if (DB::table('users')->where('api_token', $apiToken)->count() > 0) continue;

            // Return token
            return $apiToken;
        }

        // TODO: Throw error
        return null;
    }
}
