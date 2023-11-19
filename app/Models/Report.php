<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Report extends Model
{
    use HasFactory;


    protected $fillable = ['user_id', 'month', 'year', 'paid', 'outstanding', 'overdue'];

    protected $hidden = ['created_at','user_id','updated_at'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
