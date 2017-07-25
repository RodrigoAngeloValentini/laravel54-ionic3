@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Nova Série</h3>
            <?php $icon = Icon::create('floppy-saved') ?>
            {!!
                form($form->add('salvar', 'submit', [
                    'attr'=>['class'=>'btn btn-primary btn-block'],
                    'label' => $icon
                ]))
             !!}
        </div>
    </div>
@endsection