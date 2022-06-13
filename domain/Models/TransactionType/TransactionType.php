<?php

namespace Turnover\Models\TransactionType;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model {

    protected $fillable = ['description'];

    const DEPOSIT  = 1;
    const PURCHASE = 2;
}
