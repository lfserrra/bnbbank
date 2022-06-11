<?php

namespace Turnover\Models\Balance;

use Illuminate\Database\Eloquent\Model;
use Turnover\Models\BalanceCheck\BalanceCheck;
use Turnover\Models\BalanceStatus\BalanceStatus;
use Turnover\Models\BalanceType\BalanceType;
use Turnover\Models\User\User;

class Balance extends Model {

    protected $fillable = ['status_id', 'type_id', 'customer_id', 'amount', 'description'];

    public function type()
    {
        return $this->belongsTo(BalanceType::class);
    }

    public function status()
    {
        return $this->belongsTo(BalanceStatus::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class);
    }

    public function checks()
    {
        return $this->hasMany(BalanceCheck::class);
    }
}
