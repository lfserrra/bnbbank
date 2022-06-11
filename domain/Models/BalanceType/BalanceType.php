<?php

namespace Turnover\Models\BalanceType;

use Illuminate\Database\Eloquent\Model;
use Turnover\Models\Balance\Balance;

class BalanceType extends Model {

    protected $fillable = ['description'];

    public function balances()
    {
        return $this->hasMany(Balance::class, 'type_id');
    }
}
