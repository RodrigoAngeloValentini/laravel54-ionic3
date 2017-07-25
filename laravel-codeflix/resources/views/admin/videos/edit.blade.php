@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            @component('admin.videos.tabs-component',['video' => $form->getModel()])
                <div class="col-md-12">
                    <h3>Editar vídeo</h3>
                    <?php $icon = Icon::create('floppy-saved') ?>
                    {!!
                        form($form->add('salvar', 'submit', [
                            'attr'=>['class'=>'btn btn-primary btn-block'],
                            'label' => $icon
                        ]))
                    !!}
                </div>
            @endcomponent
        </div>
    </div>
@endsection