@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Exibir Categoria</h3>
            <?php
            $iconEdit = Icon::create('pencil');
            $iconDestroy = Icon::create('remove');

            $formDelete = FormBuilder::plain([
                'id' => 'form-delete',
                'route' => ['admin.categories.destroy', 'category' =>
                    $category->id],
                'method' => 'DELETE',
                'style' => 'display:none',
            ]);
            ?>
            {!! Button::primary($iconEdit)->asLinkTo(route('admin.categories.edit', ['category'=>$category->id])) !!}
            {!! Button::danger($iconDestroy)
                ->asLinkTo(route('admin.categories.destroy', ['category'=>$category->id]))
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
                        <td>{!! $category->id !!}</td>
                    </tr>
                    <tr>
                        <th scope="row">Nome</th>
                        <td>{!! $category->name !!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection