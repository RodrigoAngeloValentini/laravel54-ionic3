<?php

namespace CodeFlix\Http\Controllers\Api;

use CodeFlix\Http\Controllers\Controller;
use CodeFlix\Models\User;
use CodeFlix\Repositories\UserRepository;
use Illuminate\Http\Request;

class RegisterUsersController extends Controller
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {
        $authorization = $request->header('Authorization');
        $accessToken = str_replace('Bearer ', '', $authorization);

        $facebook = \Socialite::driver('facebook');
        $userSocial = $facebook->userFromToken($accessToken);

        $user = $this->repository->findByField('email', $userSocial->email)->first();
        if(!$user){
            User::unguard();
            $user = $this->repository->create([
                'name' => $userSocial->name,
                'email' => $userSocial->email,
                'role' => User::ROLE_CLIENT,
                'verified' => true
            ]);
            User::reguard();
        }
        return ['token' => \Auth::guard('api')->tokenById($user->id)];
    }
}