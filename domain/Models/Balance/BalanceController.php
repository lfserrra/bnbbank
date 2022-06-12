<?php

namespace Turnover\Models\Balance;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Turnover\Traits\ResponseTrait;

class BalanceController extends Controller {

    use ResponseTrait;

    public function index(BalanceRepository $repository)
    {
        $filters = request()->only('type_id', 'status_id');

        $filters['customer_id'] = auth()->user()->id;

        $data = $repository->list($filters);

        return $this->successResponse($data);
    }

    public function show(int $balance_id, BalanceRepository $repository)
    {
        $balance = $repository->show($balance_id);

        return $this->successResponse(['balance' => $balance]);
    }

    public function store(BalanceRequest $request, BalanceDepositService $service): JsonResponse
    {
        $balance = $service->deposit($request);

        return $this->successResponse(['balance' => $balance]);
    }
}
