<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conteudo;
use Illuminate\Support\Facades\Validator;

class ConteudoController extends Controller
{
    public function lista(Request $request)
    {
        $conteudos = Conteudo::with('user')->orderBy('data','DESC')->paginate(5);
        $user = $request->user();

        foreach ($conteudos as $key => $conteudo) {
          $conteudo->total_curtidas = $conteudo->curtidas()->count();
          $conteudo->comentarios = $conteudo->comentarios()->with('user')->get();
          $curtiu = $user->curtidas()->find($conteudo->id);
          if($curtiu){
            $conteudo->curtiu_conteudo = true;
          }else{
            $conteudo->curtiu_conteudo = false;
          }

        }

        return ['status'=>true,"conteudos"=>$conteudos];
    }


    public function adicionar(Request $request)
    {
      $data = $request->all();
      $user = $request->user();

      // validação
      $valiacao = Validator::make($data, [
          'titulo' => 'required',
          'texto' => 'required',
      ]);

      if($valiacao->fails()){
        return ['status'=>false,"validacao"=>true,"erros"=>$valiacao->errors()];
      }

      $conteudo = new Conteudo;

      $conteudo->titulo = $data['titulo'];
      $conteudo->texto = $data['texto'];
      $conteudo->link = $data['link'] ? $data['link'] : '#' ;
      $conteudo->imagem = $data['imagem'] ? $data['imagem'] : '#' ;
      $conteudo->data = date('Y-m-d H:i:s');

      $user->conteudos()->save($conteudo);

      $conteudos = Conteudo::with('user')->orderBy('data','DESC')->paginate(5);

      return ['status'=>true,"conteudos"=>$conteudos];

    }

    public function curtir($id,Request $request)
    {
      $conteudo = Conteudo::find($id);
      if($conteudo){
        $user = $request->user();
        $user->curtidas()->toggle($conteudo->id);
        //return $conteudo->curtidas()->count();
        //return $conteudo->curtidas;
        return [
          'status'=>true,
          "curtidas"=>$conteudo->curtidas()->count(),
          'lista'=> $this->lista($request)
        ];
      }else{
        return ['status'=>false,"erro"=>"Conteúdo não existe!"];
      }

    }

    public function comentar($id,Request $request)
    {
      $conteudo = Conteudo::find($id);
      if($conteudo){
        $user = $request->user();
        $user->comentarios()->create([
          'conteudo_id'=>$conteudo->id,
          'texto'=>$request->texto,
          'data'=>date('Y-m-d H:i:s') //date('Y-m-d')
        ]);
        return [
          'status'=>true,
          'lista'=> $this->lista($request)
        ];
      }else{
        return ['status'=>false,"erro"=>"Conteúdo não existe!"];
      }

    }
}
