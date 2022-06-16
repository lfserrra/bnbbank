<?php

namespace Turnover\Transaction;

use Illuminate\Auth\Access\HandlesAuthorization;
use Turnover\Models\User\User;

class TransactionPolicy {

    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function show($user, $model)
    {
        if ($user->is_admin) {
            return true;
        }

        return $user->id === $model->customer_id;
    }
}
