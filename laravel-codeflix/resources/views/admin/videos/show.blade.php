@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Exibir Vídeo</h3>
            <?php
            $iconEdit = Icon::create('pencil');
            $iconDestroy = Icon::create('remove');

            $formDelete = FormBuilder::plain([
                'id' => 'form-delete',
                'route' => ['admin.videos.destroy', 'video' => $video->id],
                'method' => 'DELETE',
                'style' => 'display:none',
            ]);
            ?>
            {!! Button::primary($iconEdit)->asLinkTo(route('admin.videos.edit', ['video'=>$video->id])) !!}
            {!! Button::danger($iconDestroy)
                ->asLinkTo(route('admin.videos.destroy', ['video'=>$video->id]))
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
                        <td>{!! $video->id !!}</td>
                    </tr>
                    <tr>
                        <th scope="row">Titulo</th>
                        <td>{!! $video->title !!}</td>
                    </tr>
                    <tr>
                        <th scope="row">Descrição</th>
                        <td>{!! $video->description !!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection