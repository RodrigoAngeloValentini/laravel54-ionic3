@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Listagem de Planos</h3>
            {!! Button::primary('Novo plano')
                ->asLinkTo(route('admin.plans.create'))
                ->prependIcon(Icon::plus())
            !!}
        </div>
        <br>
        <div class="row">
            {!! Table::withContents($plans->items())->striped()

                ->callback('Ações', function ($field, $c) {
                    $linkEdit = route('admin.plans.edit', ['plan' => $c->id]);
                    $linkShow = route('admin.plans.show', ['plan' => $c->id]);

                    return Button::link(Icon::create('pencil'))->asLinkTo($linkEdit) . '|'. Button::link(Icon::create('remove'))->asLinkTo($linkShow);
                })
            !!}
        </div>
        {!! $plans->links() !!}
    </div>
@endsection