@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Exibir Usuário</h3>
            <?php
            $iconEdit = Icon::create('pencil');
            $iconDestroy = Icon::create('remove');

            $formDelete = FormBuilder::plain([
                'id' => 'form-delete',
                'route' => ['admin.users.destroy', 'user' => $user->id],
                'method' => 'DELETE',
                'style' => 'display:none',
            ]);
            ?>
            {!! Button::primary($iconEdit)->asLinkTo(route('admin.users.edit', ['user'=>$user->id])) !!}
            {!! Button::danger($iconDestroy)
                ->asLinkTo(route('admin.users.destroy', ['user'=>$user->id]))
                ->addAttributes(['onclick'=> "event.preventDefault();document.getElementById(\"form-delete\").submit()
                ;"])
            !!}
            {!! form($formDelete) !!}
            <br>
            <br>
            <div class="row">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th scope="row">#</th>
                        <td>{!! $user->id !!}</td>
                    </tr>
                    <tr>
                        <th scope="row">Nome</th>
                        <td>{!! $user->name !!}</td>
                    </tr>
                    <tr>
                        <th scope="row">E-maiil</th>
                        <td>{!! $user->email !!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection