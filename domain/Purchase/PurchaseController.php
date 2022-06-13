<?php

namespace Turnover\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Turnover\Models\Transaction\TransactionTransformer;
use Turnover\Traits\HasTransformerTrait;
use Turnover\Traits\ResponseTrait;

class PurchaseController extends Controller {

    use ResponseTrait, HasTransformerTrait;

    public function __construct(
        private TransactionTransformer $transformer
    ){}

    public function store(PurchaseRequest $request, PurchaseService $service): JsonResponse
    {
        $transaction = $service->purchase($request->validated());

        return $this->successResponse(['transaction' => $this->applyTransform($transaction, false)]);
    }
}
