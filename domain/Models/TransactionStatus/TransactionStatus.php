<?php

namespace Turnover\Models\TransactionStatus;

use Illuminate\Database\Eloquent\Model;

class TransactionStatus extends Model {

    protected $table    = 'transaction_status';
    protected $fillable = ['description'];

    const PENDING  = 1;
    const ACCEPTED = 2;
    const REJECTED = 3;
}
