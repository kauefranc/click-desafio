<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = [
        'conteudo_id', 'texto', 'data'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function conteudo()
    {
        return $this->belongsTo('App\Models\Conteudo');
    }

    public function getDataAttribute($value)
    {
      $data = date('H:i d/m/Y',strtotime($value));
      return str_replace(':','h',$data);
    }

}
