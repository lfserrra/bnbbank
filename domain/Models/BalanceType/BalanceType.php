<?php

namespace Turnover\Models\BalanceType;

use Illuminate\Database\Eloquent\Model;

class BalanceType extends Model {

    protected $fillable = ['description'];

    const DEPOSIT  = 1;
    const ORDER    = 2;
    const WITHDRAW = 3;
}
