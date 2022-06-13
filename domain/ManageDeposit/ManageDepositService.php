<?php

namespace Turnover\ManageDeposit;

use DB;

use Turnover\Base\Exceptions\TurnoverErrorException;
use Turnover\Models\Transaction\Transaction;
use Turnover\Models\TransactionStatus\TransactionStatus;
use Turnover\Models\TransactionType\TransactionType;

class ManageDepositService {

    public function __construct(
        private Transaction $model
    ){}

    public function accept(int $transaction_id): bool
    {
        throw_unless(auth()->user()->is_admin, new TurnoverErrorException(__('errors.unauthorized'), 403));

        return DB::transaction(function () use ($transaction_id) {
            $transaction = $this->model->where('type_id', TransactionType::DEPOSIT)
                                       ->where('id', $transaction_id)
                                       ->first();

            $this->validate($transaction);

            $transaction->update(['status_id' => TransactionStatus::ACCEPTED]);

            $transaction->customer->increment('balance', $transaction->amount);

            return true;
        });
    }

    public function reject(int $transaction_id): bool
    {
        throw_unless(auth()->user()->is_admin, new TurnoverErrorException(__('errors.unauthorized'), 403));

        return DB::transaction(function () use ($transaction_id) {
            $transaction = $this->model->where('type_id', TransactionType::DEPOSIT)
                                       ->where('id', $transaction_id)
                                       ->first();

            $this->validate($transaction);

            $transaction->update(['status_id' => TransactionStatus::REJECTED]);

            return true;
        });
    }

    private function validate(Transaction $transaction = null): void
    {
        throw_unless($transaction, new TurnoverErrorException(__('errors.transaction_not_found'), 404));

        throw_if($transaction->status_id === TransactionStatus::ACCEPTED, new TurnoverErrorException(__('errors.transaction_previously_accepted')));
        throw_if($transaction->status_id === TransactionStatus::REJECTED, new TurnoverErrorException(__('errors.transaction_previously_rejected')));
    }
}
