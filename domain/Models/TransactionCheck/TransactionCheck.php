<?php

namespace Turnover\Models\TransactionCheck;

use Illuminate\Database\Eloquent\Model;

class TransactionCheck extends Model {

    protected $fillable = ['transaction_id', 'url'];

}
