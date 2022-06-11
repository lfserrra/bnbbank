<?php

namespace Turnover\Customer;

use Turnover\Models\User\User;

class CustomerRegistrationService {

    public function __construct(private User $model)
    {
    }

    public function registration(array $data): User
    {
        return $this->model->create($data);
    }
}
