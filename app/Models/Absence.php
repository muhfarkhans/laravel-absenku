<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;

    protected $table = 'absences';

    protected $fillable = [
        'employee_id',
        'check_in_time',
        'check_out_time',
    ];

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }
}
