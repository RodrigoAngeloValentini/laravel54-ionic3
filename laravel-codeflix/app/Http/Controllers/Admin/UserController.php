<?php

namespace CodeFlix\Http\Controllers\Admin;

use CodeFlix\Forms\UserForm;
use CodeFlix\Models\User;
use CodeFlix\Repositories\UserRepository;
use FormBuilder;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;
use Auth;

class UserController extends Controller
{

    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $users = $this->repository->paginate();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $form = FormBuilder::create(UserForm::class, [
            'url' => route('admin.users.store'),
            'method' => 'POST',
        ]);

        return view('admin.users.create', compact('form'));
    }

    public function store(Request $request)
    {
        $form = FormBuilder::create(UserForm::class);

        if (!$form->isValid()) {
            //redirecionar para pag de criação de usuários
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $data = $form->getFieldValues();
        $attributes['role'] = User::ROLE_ADMIN;
        $this->repository->create($data);

        $request->session()->flash('message', 'Usuário criado com sucesso!');

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        return view('admin.users.show')->with(['user' => $user]);
    }

    public function edit(User $user)
    {
        $form = FormBuilder::create(UserForm::class, [
            'url' => route('admin.users.update', ['user' => $user->id]),
            'method' => 'PUT',
            'model' => $user
        ]);

        return view('admin.users.edit', compact('form'));
    }

    public function update(Request $request, $id)
    {
        $form = FormBuilder::create(UserForm::class, [
            'data' => ['id' => $id]
        ]);

        if (!$form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $data = array_except($form->getFieldValues(), ['role', 'password']);

        $this->repository->update($data, $id);

        $request->session()->flash('message', 'Usuário alterado com sucesso!');

        return redirect()->route('admin.users.index');
    }

    public function destroy(Request $request, $id)
    {
        $this->repository->delete($id);

        $request->session()->flash('message', "Usuário ID: <strong>{$id}</strong> excluído com sucesso!");
        return redirect()->route('admin.users.index');
    }

    public function showPasswordForm()
    {
        if (!Auth::check()) {
            return abort(401, 'Você não tem permissão.');
        }

        $user = Auth::user();

        return view('admin.users.password', ['data' => $user]);
    }

    public function updatePassword(Request $request, $id)
    {
        $regras = [
            'name' => 'required|min:3|max:255',
            'email' => "required|max:255|unique:users,email,$id",
            'password' => $request->password != null ? 'required|min:6|confirmed' : 'confirmed',
            'password_confirmation' => 'sometimes|required_with:password',
        ];

        $mensagens = [
            'numeric' => ':attribute deve ser numérico',
        ];

        if (!Auth::check() || $id != Auth::id()) {
            return abort(401, 'Você não tem permissão.');
        }

        $user = $this->repository->find($id);

        $v = \Validator::make($request->all(), $regras, $mensagens);

        if ($v->passes()) {
            unset($request['password_confirmation']);

            if ($request->password == null) {
                unset($request['password']);
            } else {
                $request['password'] = bcrypt($request['password']);
            }

            $user->update($request->all());
            $request->session()->flash('message', 'Dados atualizados com sucesso!');

            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.change.password')->withErrors($v)->withInput();

    }

}