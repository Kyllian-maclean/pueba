<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\instructorsFicha;
use Illuminate\Database\QueryException;

class instructorsFichasController extends Controller
{
    public function vinculateFicha(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'ficha_id' => 'required'
        ]);

        try {
            $instructorsFicha = instructorsFicha::create($request->all());
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Ya existe un instructor con ese código.');
        }
        return redirect()->route('fichas.view');
    }

    public function desvinculate(Request $request){
        $request->validate([
            'user_id' => 'required',
            'ficha_id' => 'required'
        ]);

        try {
            $instructorsFicha = instructorsFicha::where('user_id', $request->user_id)->where('ficha_id', $request->ficha_id)->delete();
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'no existe un instructor con ese código.');
        }
        return redirect()->route('fichas.view');
    }
}
