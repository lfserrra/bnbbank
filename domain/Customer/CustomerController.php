<?php

namespace Turnover\Customer;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Http\JsonResponse;
use Storage;
use Turnover\Base\Traits\ResponseTrait;

class CustomerController extends Controller {

    use ResponseTrait;

    public function balance(): JsonResponse
    {
        Gate::authorize('can-view-own-balance');

        return $this->successResponse(['balance' => auth()->user()->balance]);
    }
}
