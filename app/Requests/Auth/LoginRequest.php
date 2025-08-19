<?php

declare(strict_types=1);

namespace App\Requests\Auth;

use App\Contracts\RequestValidatorInterface;
use App\Exceptions\ValidationException;
use App\Repositories\UserRepository;
use Valitron\Validator;

class LoginRequest implements RequestValidatorInterface
{
    public function __construct(
        private readonly UserRepository $userRepository
    )
    {
        
    }
    public function verify(array $data): array
    {
        $v = new Validator($data);

        $v->rule('required', ['email', 'password']);
        $v->rule('email', 'email');
        $v->rule(function ($field, $value, $params, $fields) {
            return $this->userRepository->exists($field, $value);
        }, 'email')->message('{field} not found...');
        $v->rules([
            'lengthMin' => [
                ['email', 10],
                ['password', 8],
            ]
        ]);

        if (!$v->validate()) {
            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
