<?php

namespace App\Http\Controllers\Admin;

use App\Http\Validation\ProfileFormValidation;
use App\ReadModel\Auth\UserRepository;
use Framework\Helpers\PasswordHasher;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ProfileController
{
    public function index()
    {
        $user = user();
        return view('app/profile/index', compact('user'));
    }

    public function update(RequestInterface $request, ResponseInterface $response)
    {
        $data = $request->getParsedBody();

        $validation = ProfileFormValidation::validate($data);

        if ($validation) {
            return redirect($response)->with('errors', $validation)->route('admin.profile');
        }

        $repository = new UserRepository();
        $authUser = user();

        $user = $repository->getByEmail($authUser->getEmail());

        $user->setName($data['name']);
        $user->setPassword(PasswordHasher::hash($data['password']));

        $repository->save();

        return redirect($response)->with('success', 'Профиль успешно обновлен!')->route('admin.profile');
    }
}