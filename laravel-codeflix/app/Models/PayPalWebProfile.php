<?php

namespace CodeFlix\Models;

use Bootstrapper\Interfaces\TableInterface;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class PayPalWebProfile extends Model implements Transformable, TableInterface
{
    use TransformableTrait;

    protected $table = 'paypal_web_profiles';

    protected $fillable = ['name', 'logo_url', 'code'];

    public function getTableHeaders()
    {
        return ['#', 'Nome', 'Logo Url'];
    }

    public function getValueForHeader($header)
    {
        switch ($header){
            case '#':
                return $this->id;
            case 'Nome':
                return $this->name;
            case 'Logo Url':
                return \BootstrapImage::thumbnail($this->logo_url, 'thumbnail');
        }
    }
}
