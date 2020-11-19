<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{

    protected $fillable = [
        'title'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    use HasFactory;
}
