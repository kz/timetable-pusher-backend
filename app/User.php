<?php

namespace TimetablePusher;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function timetables()
    {
        return $this->hasMany('TimetablePusher\Timetable');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Ensure a unique API token is generated
            while (true) {
                $apiToken = strtoupper(str_random(20));
                if (\DB::table('users')->where('api_token', $apiToken)->count() > 0) {
                    continue;
                } else {
                    break;
                }
            }

            /** @noinspection PhpUndefinedVariableInspection */
            $model->api_token = $apiToken;
        });
    }
}
