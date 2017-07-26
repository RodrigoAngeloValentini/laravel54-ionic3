<?php

namespace CodeFlix\Http\Controllers\Api;

use CodeFlix\Http\Controllers\Controller;
use CodeFlix\Http\Requests\UserSettingRequest;
use CodeFlix\Repositories\UserRepository;

class UserController extends Controller
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function updateSettings(UserSettingRequest $request)
    {
        $data = $request->only('password');
        $this->repository->update($data, $request->user('api')->id);

        return $request->user('api');
    }
}