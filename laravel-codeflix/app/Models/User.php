<?php

namespace CodeFlix\Models;

use Bootstrapper\Interfaces\TableInterface;
use CodeFlix\Notifications\DefaultResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements TableInterface, JWTSubject
{
    use Notifiable;
    use SoftDeletes;

    const ROLE_ADMIN=1;
    const ROLE_CLIENT=2;

    protected $fillable = [
        'name', 'email', 'password','role','cpf'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function subscriptions(){
        return $this->hasManyThrough(Subscription::class, Order::class);
    }

    public function hasSubscriptionValid(){
        $valid = false;
        $subscriptions = $this->subscriptions;
        foreach ($subscriptions as $subscription){
            $valid = !$subscription->isExpired();
            if($valid){
                break;
            }
        }
        return $valid;
    }

    public static function generatePassword($password = null)
    {
        return !$password ? bcrypt(str_random(8)) : bcrypt($password);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new DefaultResetPasswordNotification($token));
    }

    public function getTableHeaders()
    {
        return ['#','Nome','E-mail'];
    }

    public function getValueForHeader($header)
    {
        switch ($header){
            case '#':
                return $this->id;
            case 'Nome':
                return $this->name;
            case 'E-mail':
                return $this->email;
        }
    }

    public function getJWTIdentifier()
    {
        return $this->id;
    }

    public function getJWTCustomClaims()
    {
        return [
            'user' => [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'subscription_valid' => $this->hasSubscriptionValid()
            ]
        ];
    }

}
