<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $casts = [
        'tags' => 'object'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function treviews()
    {
        return $this->hasMany(TeacherReview::class);
    }

    public function scopePending()
    {
        return $this->where('status', 0);
    }

    public function scopeApproved()
    {
        return $this->where('status', 1);
    }

    public function scopeRejected()
    {
        return $this->where('status', 2);
    }

    public function getStatusTextAttribute()
    {
        $class = "badge badge--";
        if($this->status == 0){
            $class .='warning';
            $text = 'Pending';
        }elseif($this->status == 1){
            $class .='success';
            $text = 'Approved';
        }else{
            $class .='danger';
            $text = 'Rejected';
        }
        return "<span class='badge $class'>".trans($text)."</span>";
    }

}
