<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends User
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'employees';

    protected $fillable = [
        'division_id',
        'name',
        'email',
        'password',
        'photo',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function absences()
    {
        return $this->hasMany(Absence::class, 'employee_id', 'id');
    }

    public function division()
    {
        return $this->hasOne(Division::class, 'id', 'division_id');
    }
}
