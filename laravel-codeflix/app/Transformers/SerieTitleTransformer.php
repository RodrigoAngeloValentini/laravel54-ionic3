<?php

namespace CodeFlix\Transformers;

use League\Fractal\TransformerAbstract;
use CodeFlix\Models\Serie;

/**
 * Class SerieTitleTransformer
 * @package namespace CodeFlix\Transformers;
 */
class SerieTitleTransformer extends TransformerAbstract
{

    /**
     * Transform the \Serie entity
     * @param Serie $model
     *
     * @return array
     */
    public function transform(Serie $model)
    {
        return [
            'title' => $model->title,
        ];
    }
}
