<?php

namespace Turnover\Models\BalanceStatus;

use Illuminate\Database\Eloquent\Model;
use Turnover\Models\Balance\Balance;

class BalanceStatus extends Model {

    protected $table = 'balance_status';

    protected $fillable = ['description'];

    public function balances()
    {
        return $this->hasMany(Balance::class, 'status_id');
    }
}
