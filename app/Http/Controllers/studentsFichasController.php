<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\studentsFicha;
use Illuminate\Database\QueryException;

class studentsFichasController extends Controller
{
    public function vinculateFicha(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'ficha_id' => 'required'
        ]);

        try {
            $studentsFicha = studentsFicha::create($request->all());
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Ya existe un aprendiz con ese código.');
        }
        return redirect()->route('fichas.view');
    }

    public function desvinculate(Request $request){
        $request->validate([
            'user_id' => 'required',
            'ficha_id' => 'required'
        ]);

        try {
            $studentsFicha = studentsFicha::where('user_id', $request->user_id)->where('ficha_id', $request->ficha_id)->delete();
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'no existe un aprendiz con ese código.');
        }
        return redirect()->route('fichas.view');
    }
}
