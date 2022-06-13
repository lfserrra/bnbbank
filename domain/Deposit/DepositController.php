<?php

namespace Turnover\Deposit;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Turnover\Base\Traits\ResponseTrait;

class DepositController extends Controller {

    use ResponseTrait;

    public function __construct(
        private DepositService $service
    ){}

    public function store(DepositRequest $request): JsonResponse
    {
        $transaction = $this->service->deposit($request);

        return $this->successResponse(['transaction' => $transaction]);
    }
}
