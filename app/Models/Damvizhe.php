<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Damvizhe extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'group_company_id',
        'user_id',
        'name',
        'slug',
        'code',
        'price',
        'weight',
        'color',
        'colorenglish',
        'ageYear',
        'ageMonth',
        'gender',
        'haveMilk',
        'milk_amount',
        'description',
        'disount_price',
        'disount_time',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function galleries()
    {
        return $this->morphToMany(Gallery::class, 'galleryables');
    }

    public function group()
    {
        return $this->hasOne(Group::class);
    }

    public function groupcompany()
    {
        return $this->hasOne(GroupCompany::class);
    }

    public function payment()
    {
        return $this->morphMany(Payment::class, 'paymentable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function questionanswer()
    {
        return $this->morphMany(Questionanswer::class, 'questionanswerable');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'likeable_id', 'id');
    }

    public function paymentdetail()
    {
        return $this->hasOne(PaymentDetail::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
