<?php

namespace App\Http\Controllers;

use App\Models\Aviao;
use App\Services\Operations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MainController extends Controller
{
    public function home(): View
    {
        // $avios = Aviao::all()->toArray();
        $id = Auth::id();
        $avios = Aviao::find($id)

                        ->whereNull('deleted_At')
                        ->get()
                        ->toArray();
        return view('home', ['avios' => $avios]);
    }

    public function newAviao(): View
    {
        return view('add_aviao');
    }
    public function newAviaoSubmit(Request $request )
    {

         //form validation
           $request -> validate(
            [
                'name' => 'required|min:3|max:200',
                'model' => 'required|min:3|max:3000',
                'airline' => 'required|min:3|max:3000',
                'capacity' => 'required|min:3|max:3000',
            ],
            [
                'name.required' => 'O campo nome é obrigatório',
                'name.min' => 'O campo nome deve ter pelo menos :min caracteres',
                'name.max' => 'O campo nome deve ter no máximo :max caracteres',
                'model.required' => 'O campo modelo é obrigatório',
                'model.min' => 'O campo modelo deve ter pelo menos :min caracteres',
                'model.max' => 'O campo modelo deve ter no máximo :max caracteres',
                'airline.required' => 'O campo companhia aérea é obrigatório',
                'airline.min' => 'O campo companhia aérea deve ter pelo menos :min caracteres',
                'airline.max' => 'O campo companhia aérea deve ter no máximo :max caracteres',
                'capacity.required' => 'O campo capacidade é obrigatório',
                'capacity.min' => 'O campo capacidade deve ter pelo menos :min caracteres',
                'capacity.max' => 'O campo capacidade deve ter no máximo :max caracteres',
            ]
        );
        // $id = session('user.id');
        // $user = Auth::user();
        $id = Auth::id();
         //create new Aviao
        $aviao = new Aviao();
        $aviao->user_id = $id;
        $aviao->nome = $request->name;
        $aviao->model = $request->model;
        $aviao->airline = $request->airline;
        $aviao->capacity = $request->capacity;

        $aviao->save();
        //redirect  to home
        return redirect()->route('home');
    }

    public function editAviao($id):View
    {
        $id = Operations::decryptId($id);
        //load aviao
        $aviao = Aviao::find($id);

        //show edit note view
        return view('edit_aviao', ['aviao' => $aviao]);

    }

    public function editAviaoSubmit(Request $request)
    {
        //form validation
           $request -> validate(
            [
                'name' => 'required|min:3|max:200',
                'model' => 'required|min:3|max:3000',
                'airline' => 'required|min:3|max:3000',
                'capacity' => 'required|min:3|max:3000',
            ],
            [
                'name.required' => 'O campo nome é obrigatório',
                'name.min' => 'O campo nome deve ter pelo menos :min caracteres',
                'name.max' => 'O campo nome deve ter no máximo :max caracteres',
                'model.required' => 'O campo modelo é obrigatório',
                'model.min' => 'O campo modelo deve ter pelo menos :min caracteres',
                'model.max' => 'O campo modelo deve ter no máximo :max caracteres',
                'airline.required' => 'O campo companhia aérea é obrigatório',
                'airline.min' => 'O campo companhia aérea deve ter pelo menos :min caracteres',
                'airline.max' => 'O campo companhia aérea deve ter no máximo :max caracteres',
                'capacity.required' => 'O campo capacidade é obrigatório',
                'capacity.min' => 'O campo capacidade deve ter pelo menos :min caracteres',
                'capacity.max' => 'O campo capacidade deve ter no máximo :max caracteres',
            ]
        );

        // check if avion_id exists
        if($request->avion_id == null){
            return redirect()->to('home');
        }

        //decrypt avion_id
        $id = Operations::decryptId($request->avion_id);
         //load aviao
        $aviao = Aviao::find($id);
        $aviao->nome = $request->name;
        $aviao->model = $request->model;
        $aviao->airline = $request->airline;
        $aviao->capacity = $request->capacity;
        $aviao->save();
        return redirect()->route('home');
    }

    public function deleteAviao($id){
        $id = Operations::decryptId($id);
        $aviao = Aviao::find($id);

        return view('delete_aviao', ['aviao' => $aviao]);

    }
     public function deleteAviaoConfirm($id)
     {
        $id = Operations::decryptId($id);
        $aviao = Aviao::find($id);
        $aviao->deleted_at = date('Y:m:d H:i:s');
        $aviao->save();

        return redirect()->route('home');
    }
}
