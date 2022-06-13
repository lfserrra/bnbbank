<?php

namespace Turnover\Deposit;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Turnover\Traits\ResponseTrait;

class DepositController extends Controller {

    use ResponseTrait;

    public function store(DepositRequest $request, DepositService $service): JsonResponse
    {
        $transaction = $service->deposit($request);

        return $this->successResponse(['transaction' => $transaction]);
    }
}
