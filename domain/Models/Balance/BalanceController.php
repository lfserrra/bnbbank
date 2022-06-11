<?php

namespace Turnover\Models\Balance;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Turnover\Traits\ResponseTrait;

class BalanceController extends Controller {

    use ResponseTrait;

    public function store(BalanceRequest $request, BalanceDepositService $service): JsonResponse
    {
        $balance = $service->deposit($request);

        return $this->successResponse(['balance' => $balance]);
    }
}
