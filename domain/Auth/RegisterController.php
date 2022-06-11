<?php

namespace Turnover\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Turnover\Customer\CustomerRegistrationService;
use Turnover\Traits\ResponseTrait;

class RegisterController extends Controller {

    use ResponseTrait;

    public function store(RegisterRequest $request, CustomerRegistrationService $service): JsonResponse
    {
        $user = $service->registration($request->validated());

        return $this->successResponse(['user' => $user]);
    }
}
