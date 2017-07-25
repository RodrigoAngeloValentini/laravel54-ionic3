@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Listagem de Séries</h3>
            {!! Button::primary('Nova série')
                ->asLinkTo(route('admin.series.create'))
                ->prependIcon(Icon::plus())
            !!}
        </div>
        <br>
        <div class="row">
            {!! Table::withContents($series->items())->striped()
                ->callback('Descrição', function($field, $serie){
                    return MediaObject::withContents(
                        [
                            'image' => $serie->thumb_small_asset,
                            'link' => '#',
                            'heading' => $serie->title,
                            'body' => $serie->description
                        ]
                    );
                })
                ->callback('Ações', function ($field, $c) {
                    $linkEdit = route('admin.series.edit', ['serie' => $c->id]);
                    $linkShow = route('admin.series.show', ['serie' => $c->id]);

                    return Button::link(Icon::create('pencil'))->asLinkTo($linkEdit) . '|'. Button::link(Icon::create('remove'))->asLinkTo($linkShow);
                })
            !!}
        </div>
        {!! $series->links() !!}
    </div>
@endsection