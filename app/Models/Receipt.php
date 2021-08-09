<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'employer_id',
        'money_amount',
        'referring_month'
    ];

    public function employee() {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }

    public function employer() {
        return $this->belongsTo(User::class, 'employer_id', 'id');
    }
}
