<?php

declare(strict_types=1);

namespace App\Requests\Auth;

use App\Contracts\RequestValidatorInterface;
use App\Exceptions\ValidationException;
use App\Repositories\UserRepository;
use Valitron\Validator;

class RegisterRequest implements RequestValidatorInterface
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {}

    public function verify(array $data): array
    {
        $v = new Validator($data);

        $v->rule('required', ['name', 'email', 'password', 'confirm_password']);
        $v->rule('equals', 'password', 'confirm_password');
        $v->rule('email', 'email');
        $v->rule(function ($field, $value, $params, $fields) {
            return $this->userRepository->doesntExist($field, $value);
        }, 'email')->message('{field} failed...');
        $v->rules([
            'lengthMin' => [
                ['name', 3],
                ['email', 10],
                ['password', 8],
                ['confirm_password', 8]
            ]
        ]);

        if (!$v->validate()) {
            throw new ValidationException($v->errors());
        }

        $data = array_diff_key($data, array_flip(['confirm_password']));

        return $data;
    }
}
