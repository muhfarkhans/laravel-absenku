<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenceSetting extends Model
{
    use HasFactory;

    protected $table = 'absence_settings';

    protected $fillable = [
        'check_in_mark',
        'check_out_mark',
        'updated_by',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}
