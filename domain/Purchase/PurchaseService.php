<?php

namespace Turnover\Purchase;

use DB;
use Illuminate\Validation\ValidationException;
use Turnover\Base\Exceptions\TurnoverErrorException;
use Turnover\Models\Transaction\Transaction;
use Turnover\Models\TransactionStatus\TransactionStatus;
use Turnover\Models\TransactionType\TransactionType;

class PurchaseService {

    public function __construct(
        private Transaction $model
    ){}

    public function purchase(array $data): Transaction
    {
        throw_if(auth()->user()->is_admin, new TurnoverErrorException(__('errors.youre_not_customer'), 403));

        if (auth()->user()->balance < $data['amount']) {
            throw ValidationException::withMessages([
                'amount' => __('errors.enough_money'),
            ]);
        }

        return DB::transaction(function () use ($data) {
            $transaction = $this->model->create([
                'status_id'   => TransactionStatus::ACCEPTED,
                'type_id'     => TransactionType::PURCHASE,
                'customer_id' => auth()->user()->id,
                'amount'      => ($data['amount'] * -1),
                'description' => $data['description'],
            ]);

            auth()->user()->decrement('balance', $data['amount']);

            return $transaction;
        });
    }
}
