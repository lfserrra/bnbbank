<?php

namespace Turnover\Transaction;

use Turnover\Base\Traits\HasTransformerTrait;
use Turnover\Models\Transaction\Transaction;

class TransactionRepository {

    use HasTransformerTrait;

    public function __construct(
        private Transaction $model,
        private TransactionTransformer $transformer
    ){}

    public function show(int $transaction_id): array|null
    {
        $data = $this->model->where('id', $transaction_id)
                            ->where('customer_id', auth()->user()->id)
                            ->firstOrFail();

        return $this->applyTransform($data, false);
    }

    public function list(array $filters = []): array
    {
        $customer_id = $filters['customer_id'] ?? 0;
        $type_id     = $filters['type_id'] ?? 0;
        $status_id   = $filters['status_id'] ?? 0;

        $data = $this->model->with('type', 'status', 'customer', 'check')
                            ->when($customer_id, fn($q) => $q->where('customer_id', $customer_id))
                            ->when($type_id, fn($q) => $q->where('type_id', $type_id))
                            ->when($status_id, fn($q) => $q->where('status_id', $status_id))
                            ->latest()
                            ->get();

        return $this->applyTransform($data);
    }
}
