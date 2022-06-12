<?php

namespace Turnover\Models\Balance;

use DB;
use Illuminate\Http\UploadedFile;
use Turnover\Models\BalanceCheck\BalanceCheck;
use Turnover\Models\BalanceStatus\BalanceStatus;
use Turnover\Models\BalanceType\BalanceType;

class BalanceDepositService {

    public function __construct(private Balance $model, private BalanceCheck $balanceCheck)
    {

    }

    public function deposit(BalanceRequest $request): Balance
    {
        return DB::transaction(function () use ($request) {
            $balance = $this->model->create([
                'status_id'   => BalanceStatus::PENDING,
                'type_id'     => BalanceType::DEPOSIT,
                'customer_id' => auth()->user()->id,
                'amount'      => $request->get('amount'),
                'description' => $request->get('description'),
            ]);

            $this->balanceCheck->create([
                'balance_id' => $balance->id,
                'url'        => $this->generateCheckUrl($request->check)
            ]);

            return $balance;
        });
    }

    private function generateCheckUrl(UploadedFile $file)
    {
        $name      = uniqid(date('HisYmd')) . auth()->user()->id;
        $extension = $file->extension();

        return $file->storeAs('checks', "$name.$extension");
    }
}
