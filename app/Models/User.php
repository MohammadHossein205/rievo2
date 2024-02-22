<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use LaravelAndVueJS\Traits\LaravelPermissionToVueJS;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, LaravelPermissionToVueJS;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'discount_id',
        'fullname',
        'image',
        'nationalCode',
        'mobile',
        'homeNumber',
        'birthDate',
        'email',
        'password',
        'address',
        'changed_password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function bankcard()
    {
        return $this->hasMany(Bankcard::class);
    }

    public function discountcodes()
    {
        return $this->morphToMany(DiscountCode::class, 'discount_codeables');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function dams()
    {
        return $this->hasMany(Dam::class);
    }

    public function damvizhes()
    {
        return $this->hasMany(Dam::class);
    }

    public function questionanswers()
    {
        return $this->hasMany(Questionanswer::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function ticketgroupes()
    {
        return $this->hasMany(Ticketgroupe::class);
    }

    public function factors()
    {
        return $this->hasMany(Factor::class);
    }

    public function joinnews()
    {
        return $this->hasOne(JoinNews::class);
    }

    public function sells()
    {
        return $this->hasMany(Sell::class);
    }

}
