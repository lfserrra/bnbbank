<?php

namespace Turnover\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Turnover\Models\TransactionCheck\TransactionCheck;
use Turnover\Models\TransactionStatus\TransactionStatus;
use Turnover\Models\TransactionType\TransactionType;
use Turnover\Models\User\User;

class Transaction extends Model {

    use HasFactory;

    protected $fillable = ['status_id', 'type_id', 'customer_id', 'amount', 'description'];

    public function type()
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function status()
    {
        return $this->belongsTo(TransactionStatus::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class);
    }

    public function check()
    {
        return $this->hasOne(TransactionCheck::class);
    }
}
