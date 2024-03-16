<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $table = 'divisions';

    protected $fillable = [
        'name',
        'facegallery_id',
    ];

    public function employee()
    {
        return $this->hasMany(Employee::class, 'division_id', 'id');
    }
}
