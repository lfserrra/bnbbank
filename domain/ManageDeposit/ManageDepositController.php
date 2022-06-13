<?php

namespace Turnover\ManageDeposit;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Turnover\Base\Traits\ResponseTrait;

class ManageDepositController extends Controller {

    use ResponseTrait;

    public function __construct(
        private ManageDepositService $service
    ){}

    public function accept(int $transaction_id): JsonResponse
    {
        $this->service->accept($transaction_id);

        return $this->successResponse();
    }

    public function reject(int $transaction_id): JsonResponse
    {
        $this->service->reject($transaction_id);

        return $this->successResponse();
    }
}
