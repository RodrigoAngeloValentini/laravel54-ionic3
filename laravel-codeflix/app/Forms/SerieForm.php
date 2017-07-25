<?php

namespace CodeFlix\Forms;

use Kris\LaravelFormBuilder\Form;

class SerieForm extends Form
{
    public function buildForm()
    {
        $id = $this->getData('id');

        $rulesThumbFile = 'image|max:1024';
        $rulesThumbFile = !$id ? "required|$rulesThumbFile" : $rulesThumbFile;

        $this
            ->add('title', 'text', [
                'label' => 'Nome da Série',
                'rules' => "required|max:25|unique:series,title,$id"
            ])
            ->add('description', 'textarea', [
                'label' => 'Descrição da série',
                'rules' => "required|max:255"
            ])
            ->add('thumb_file', 'file', [
                'required' => !$id ? true : false,
                'label' => 'Thumbnail',
                'rules' => $rulesThumbFile
            ]);
    }
}
