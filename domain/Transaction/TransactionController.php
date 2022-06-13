<?php

namespace Turnover\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Turnover\Base\Traits\ResponseTrait;

class TransactionController extends Controller {

    use ResponseTrait;

    public function __construct(
        private TransactionRepository $transactionRepository
    ){}

    public function index(): JsonResponse
    {
        $filters = request()->only('type_id', 'status_id');

        $filters['customer_id'] = auth()->user()->id;

        $data = $this->transactionRepository->list($filters);

        return $this->successResponse($data);
    }

    public function show(int $transaction_id): JsonResponse
    {
        $transaction = $this->transactionRepository->show($transaction_id);

        return $this->successResponse(['transaction' => $transaction]);
    }
}
