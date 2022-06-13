<?php

namespace Turnover\Deposit;

use DB;
use Illuminate\Http\UploadedFile;
use Turnover\Base\Exceptions\TurnoverErrorException;
use Turnover\Models\Transaction\Transaction;
use Turnover\Models\TransactionCheck\TransactionCheck;
use Turnover\Models\TransactionStatus\TransactionStatus;
use Turnover\Models\TransactionType\TransactionType;

class DepositService {

    public function __construct(
        private Transaction $model,
        private TransactionCheck $transactionCheck
    ){}

    public function deposit(DepositRequest $request): Transaction
    {
        throw_if(auth()->user()->is_admin, new TurnoverErrorException(__('errors.youre_not_customer'), 403));

        return DB::transaction(function () use ($request) {
            $transaction = $this->model->create([
                'status_id'   => TransactionStatus::PENDING,
                'type_id'     => TransactionType::DEPOSIT,
                'customer_id' => auth()->user()->id,
                'amount'      => $request->get('amount'),
                'description' => $request->get('description'),
            ]);

            $this->transactionCheck->create([
                'transaction_id' => $transaction->id,
                'url'        => $this->generateCheckUrl($request->check)
            ]);

            return $transaction;
        });
    }

    private function generateCheckUrl(UploadedFile $file)
    {
        $name      = uniqid(date('HisYmd')) . auth()->user()->id;
        $extension = $file->extension();

        return $file->storeAs('checks', "$name.$extension");
    }
}
