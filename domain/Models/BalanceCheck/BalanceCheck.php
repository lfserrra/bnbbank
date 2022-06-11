<?php

namespace Turnover\Models\BalanceCheck;

use Illuminate\Database\Eloquent\Model;
use Turnover\Models\Balance\Balance;

class BalanceCheck extends Model {

    protected $fillable = ['balance_id', 'url'];

    public function balance()
    {
        return $this->belongsTo(Balance::class);
    }
}
