<?php


use App\Models\User;
use App\Models\Conteudo;
use App\Models\Comentario;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


Route::post('/cadastro', "App\Http\Controllers\UsuarioController@cadastro");
Route::post('/login', "App\Http\Controllers\UsuarioController@login");

Route::middleware('auth:api')->put('/perfil', "App\Http\Controllers\UsuarioController@perfil");

Route::middleware('auth:api')->post('/conteudo/adicionar', "App\Http\Controllers\ConteudoController@adicionar");
Route::middleware('auth:api')->get('/conteudo/lista', "App\Http\Controllers\ConteudoController@lista");
Route::middleware('auth:api')->put('/conteudo/curtir/{id}', "App\Http\Controllers\ConteudoController@curtir");
Route::middleware('auth:api')->put('/conteudo/comentar/{id}', "App\Http\Controllers\ConteudoController@comentar");

Route::get('/testes', function(){
    
    dd(Conteudo::all());
    $user = User::find(1);
    $conteudo = Conteudo::find(13);
    $user->comentarios()->create([
      'conteudo_id'=>$conteudo->id,
      'texto'=>"Show de bola!",
      'data'=>date('Y-m-d H:i:s') //date('Y-m-d')
    ]);
  
    return $user->comentarios;

  
    /*
    $user = User::find(1);
    $user2 = User::find(2);
  
    $conteudos = Conteudo::all();
    foreach ($conteudos as $key => $value) {
      $value->delete();
    }
  
  
    $user->conteudos()->create([
      'titulo'=>'Conteúdo 3',
      'texto'=>"Aqui o texto",
      'imagem'=>'url da imagem',
      'link'=>'Link',
      'data'=>'2018-05-10' //date('Y-m-d')
    ]);
    return $user->conteudos;
    */
  
    /*
    // add Amigos:
    //$user->amigos()->attach($user2->id);
    //$user->amigos()->detach($user2->id);
    $user->amigos()->toggle($user2->id);
  
    return $user->amigos;
    */
  
    /*
    // add Curtidas:
    $conteudo = Conteudo::find(1);
    $user->curtidas()->toggle($conteudo->id);
    //return $conteudo->curtidas()->count();
    return $conteudo->curtidas;
    */
  
    /*
    // add comentários:
    $conteudo = Conteudo::find(1);
    $user->comentarios()->create([
      'conteudo_id'=>$conteudo->id,
      'texto'=>"Show de bola!",
      'data'=>date('Y-m-d') //date('Y-m-d')
    ]);
    $user2->comentarios()->create([
      'conteudo_id'=>$conteudo->id,
      'texto'=>"Não gostei.",
      'data'=>date('Y-m-d') //date('Y-m-d')
    ]);
    return $conteudo->comentarios;
    */
});