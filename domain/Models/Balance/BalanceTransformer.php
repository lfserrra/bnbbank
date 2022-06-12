<?php

namespace Turnover\Models\Balance;

use League\Fractal\TransformerAbstract;
use Turnover\Models\BalanceType\BalanceType;

class BalanceTransformer extends TransformerAbstract {

    public function transform(Balance $model): array
    {
        return [
            'id'                 => $model->id,
            'status_id'          => $model->status_id,
            'status_description' => $model->status->description,
            'type_id'            => $model->type_id,
            'type_description'   => $model->type->description,
            'customer_id'        => $model->customer_id,
            'customer_name'      => $model->customer->name,
            'amount'             => $model->amount,
            'description'        => $model->description,
            'check_url'          => $model->type_id === BalanceType::DEPOSIT ? $model->check?->url : null,
            'created_at'         => $model->created_at,
            'updated_at'         => $model->updated_at,
        ];
    }
}
