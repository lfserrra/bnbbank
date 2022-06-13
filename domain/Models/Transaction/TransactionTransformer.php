<?php

namespace Turnover\Models\Transaction;

use League\Fractal\TransformerAbstract;
use Turnover\Models\TransactionType\TransactionType;

class TransactionTransformer extends TransformerAbstract {

    public function transform(Transaction $model): array
    {
        return [
            'id'                 => $model->id,
            'status_id'          => $model->status_id,
            'status_description' => $model->status->description,
            'type_id'            => $model->type_id,
            'type_description'   => $model->type->description,
            'customer_id'        => $model->customer_id,
            'customer_name'      => $model->customer->name,
            'amount'             => number_format($model->amount, 2, '.', ''),
            'description'        => $model->description,
            'check_url'          => $model->type_id === TransactionType::DEPOSIT ? $model->check?->url : null,
            'created_at'         => $model->created_at,
            'updated_at'         => $model->updated_at,
        ];
    }
}
