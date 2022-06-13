<?php

namespace Turnover\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Turnover\Transaction\TransactionTransformer;
use Turnover\Base\Traits\HasTransformerTrait;
use Turnover\Base\Traits\ResponseTrait;

class PurchaseController extends Controller {

    use ResponseTrait, HasTransformerTrait;

    public function __construct(
        private PurchaseService $service,
        private TransactionTransformer $transformer
    ){}

    public function store(PurchaseRequest $request): JsonResponse
    {
        $transaction = $this->service->purchase($request->validated());

        return $this->successResponse(['transaction' => $this->applyTransform($transaction, false)]);
    }
}
