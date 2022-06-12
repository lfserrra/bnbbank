<?php

namespace Turnover\Models\BalanceStatus;

use Illuminate\Database\Eloquent\Model;

class BalanceStatus extends Model {

    protected $table    = 'balance_status';
    protected $fillable = ['description'];

    const PENDING  = 1;
    const ACCEPTED = 2;
    const REJECTED = 3;
}
