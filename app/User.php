<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Laravel Permission Dependency
 */
use Spatie\Permission\Traits\HasRoles;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use App\Uuid;
use App\Traits\DelitrackTrait;

class User extends Authenticatable implements JWTSubject
{
    use Uuid, CrudTrait, DelitrackTrait, Notifiable, HasRoles, SoftDeletes;

    protected $guard_name = 'web';

    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'id' => 'string',
        'active' => 'boolean',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function province()
    {
        return $this->belongsTo('App\Models\Province');
    }

    public function regency()
    {
        return $this->belongsTo('App\Models\Regency');
    }

    public function district()
    {
        return $this->belongsTo('App\Models\District');
    }

    public function routeNotificationForExpoPushNotifications()
    {

    }
}
