<?php

namespace CodeFlix\Http\Controllers;

use CodeFlix\Repositories\UserRepository;
use Jrean\UserVerification\Traits\VerifiesUsers;
use function url;

class EmailVerificationController extends Controller
{
    use VerifiesUsers;
    /**
     * @var UserRepository
     */
    private $repository;


    /**
     * EmailVerificationController constructor.
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Metodo para redirecionar apos ativacao
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectAfterVerification()
    {
        $this->loginUser();

        \Request::session()->flash('info', 'Altere sua senha!');
        return url('/admin/change/password');
    }

    protected function loginUser()
    {
        $email = \Request::get('email');
        $user = $this->repository
            ->findByField('email', $email)->first();
        \Auth::login($user);
    }
}