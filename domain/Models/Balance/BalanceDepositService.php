<?php

namespace Turnover\Models\Balance;

use DB;
use Turnover\Models\BalanceCheck\BalanceCheck;

class BalanceDepositService {

    public function __construct(private Balance $model, private BalanceCheck $balanceCheck)
    {

    }

    public function deposit(BalanceRequest $request): Balance
    {
        return DB::transaction(function () use ($request) {
            $balance = $this->model->create([
                'status_id'   => 1,
                'type_id'     => 1,
                'customer_id' => auth()->user()->id,
                'amount'      => $request->get('amount'),
                'description' => $request->get('description'),
            ]);

            $this->balanceCheck->create([
                'balance_id' => $balance->id,
                'url'        => $this->upload($request)
            ]);

            return $balance;
        });
    }

    private function upload(BalanceRequest $request)
    {
        if ($request->hasFile('check') && $request->file('check')->isValid()) {
            $name      = uniqid(date('HisYmd')) . auth()->user()->id;
            $extension = $request->check->extension();

            return $request->check->storeAs('checks', "$name.$extension");
        }

        return false;
    }
}
