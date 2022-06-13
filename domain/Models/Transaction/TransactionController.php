<?php

namespace Turnover\Models\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Turnover\Traits\ResponseTrait;

class TransactionController extends Controller {

    use ResponseTrait;

    public function index(TransactionRepository $transactionRepository): JsonResponse
    {
        $filters = request()->only('type_id', 'status_id');

        $filters['customer_id'] = auth()->user()->id;

        $data = $transactionRepository->list($filters);

        return $this->successResponse($data);
    }

    public function show(int $transaction_id, TransactionRepository $transactionRepository): JsonResponse
    {
        $transaction = $transactionRepository->show($transaction_id);

        return $this->successResponse(['transaction' => $transaction]);
    }
}
