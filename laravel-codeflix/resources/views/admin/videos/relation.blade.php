@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            @component('admin.videos.tabs-component',['video' => $form->getModel()])
                <div class="col-md-12">
                    <h4>Série e categorias</h4>
                    <?php $icon = Icon::create('pencil') ?>
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