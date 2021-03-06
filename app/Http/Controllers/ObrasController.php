<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\obras;

class ObrasController extends Controller
{
    
    private $obras;

    public function __construct(obras $livros){
        $this->obras = $livros;
    }

    public function cadastrarObra(){
        return view('cadastrobras');
    }

    public function NovoCadastro(request $request){
        $nome = htmlspecialchars($request->input('nome'));
        $resumo = htmlspecialchars($request->input('resumo'));
        $autor = htmlspecialchars($request->input('autor'));
        $editora = htmlspecialchars($request->input('editora'));
        $exemplares = htmlspecialchars($request->input('exemplares'));
    

        $insert = $this->obras->create([
            'nome'          =>$nome,
            'resumo'        =>$resumo,
            'autor'         =>$autor,
            'editora'       =>$editora,
            'exemplares'    =>$exemplares,
        ]);
    

        if($insert)
            return redirect('/home');
        else
            return redirect()->back();
    }

    public function ListaLivro(){
        $obras = $this->obras->all();
        return view('home')->with(['obras' => $obras]);
    }

    public function PesquisaLivro(request $request){
        $obrasx = obras::where('nome', 'LIKE', '%' . $request->busca . '%')
                ->orWhere('autor', 'LIKE', '%' . $request->busca . '%')
                ->orWhere('editora', 'LIKE', '%' . $request->busca . '%')
        ->get();
        
        return view('home')->with(['obras' => $obrasx, 'busca' => $request->busca]);
    }
}
