<?php

namespace CodeFlix\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Traits\TransformableTrait;

class Plan extends Model
{
    const DURATION_YEARLY = 1;
    const DURATION_MONTHLY = 2;

    use TransformableTrait;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'value',
        'duration'
    ];

    protected $casts = [
        'duration' => 'integer'
    ];

    public function getTableHeaders()
    {
        return ['#', 'Nome', 'Descrição', 'Duração'];
    }

    public function getValueForHeader($header)
    {
        switch ($header){
            case '#':
                return $this->id;
            case 'Nome':
                return $this->nome;
            case 'Descrição':
                return $this->description;
            case 'Duração':
                return $this->duration == self::DURATION_MONTHLY ? 'Monthly' : 'Yearly';
        }
    }
}
