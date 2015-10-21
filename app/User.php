<?php

namespace TimetablePusher;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use TimetablePusher\TimetablePusher\Token;

/**
 * TimetablePusher\User
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $api_token
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\TimetablePusher\Timetable[] $timetables
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\User whereApiToken($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\User whereUpdatedAt($value)
 */
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

    public static function authenticateApiV1($token)
    {
        $query = \DB::table('users')->where('api_token', $token);
        if ($query->count() === 1) {
            return $query->first()->id;
        } else {
            return false;
        }
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Ensure a unique API token is generated
            $token = new Token();
            $apiToken = $token->generateUnique();

            /** @noinspection PhpUndefinedVariableInspection */
            $model->api_token = $apiToken;
        });
    }
}
