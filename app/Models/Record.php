<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;
class Record extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'transaction_id',
        'amount',
        'paid_on',
    ];

    

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
    
    
}
