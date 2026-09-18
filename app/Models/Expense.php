<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'category',
        'amount',
        'description',
        'incurred_by_user_id',
        'expense_date',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'incurred_by_user_id');
    }
}
