@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Listagem de Categorias</h3>
            {!! Button::primary('Nova Categoria')
                ->asLinkTo(route('admin.categories.create'))
                ->prependIcon(Icon::plus())
            !!}
        </div>
        <br>
        <div class="row">
            {!! Table::withContents($categories->items())
                ->bordered()
                ->callback('Ações', function ($field, $c) {
                    $linkEdit = route('admin.categories.edit', ['category' => $c->id]);
                    $linkShow = route('admin.categories.show', ['category' => $c->id]);

                    return Button::link(Icon::create('pencil'))->asLinkTo($linkEdit) . '|'. Button::link(Icon::create('remove'))->asLinkTo($linkShow);
                })
            !!}
        </div>
        {!! $categories->links() !!}
    </div>
@endsection