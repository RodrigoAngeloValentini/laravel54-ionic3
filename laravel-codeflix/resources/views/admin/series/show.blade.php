@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Exibir Série</h3>
            <?php
            $iconEdit = Icon::create('pencil');
            $iconDestroy = Icon::create('remove');

            $formDelete = FormBuilder::plain([
                'id' => 'form-delete',
                'route' => ['admin.series.destroy', 'serie' =>
                    $serie->id],
                'method' => 'DELETE',
                'style' => 'display:none',
            ]);
            ?>
            {!! Button::primary($iconEdit)->asLinkTo(route('admin.series.edit', ['serie'=>$serie->id])) !!}
            {!! Button::danger($iconDestroy)
                ->asLinkTo(route('admin.series.destroy', ['serie'=>$serie->id]))
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
                        <td>{!! $serie->id !!}</td>
                    </tr>
                    <tr>
                        <th scope="row">Titulo</th>
                        <td>{!! $serie->title !!}</td>
                    </tr>
                    <tr>
                        <th scope="row">Descrição</th>
                        <td>{!! $serie->description !!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection