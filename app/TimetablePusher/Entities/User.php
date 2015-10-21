<?php

namespace TimetablePusher\TimetablePusher\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use TimetablePusher\TimetablePusher\Token;

/**
 * TimetablePusher\TimetablePusher\Entities\User
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $api_token
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\TimetablePusher\TimetablePusher\Entities\Timetable[] $timetables
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\User whereApiToken($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\TimetablePusher\TimetablePusher\Entities\User whereUpdatedAt($value)
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
        return $this->hasMany('TimetablePusher\TimetablePusher\Entities\Timetable');
    }

    public static function authenticateApiV1($token)
    {
        // Get plain token
        $token = str_replace('Bearer:', '', $token);
        $token = str_replace(' ', '', $token);

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


            $model->api_token = $apiToken;
        });
    }
}
