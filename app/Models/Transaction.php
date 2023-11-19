<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Ui\Presets\React;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable=
    [
        'amount','vat','payer','due_on','is_vat_inclusive','user_id','status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function record()
    {
        return $this->hasMany(Record::class);
    }

    public function updateStatus()
    {
        $totalPaid = $this->record()->sum('amount');
        $currentDate = now();

        if ($totalPaid >= $this->amount) {
            $this->status = 'paid';
        } elseif ($this->due_on < $currentDate) {
            $this->status = 'overdue';
        } else {
            $this->status = 'outstanding';
        }

        $this->save();
    }
}
