<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function HistoriesProfessional(){
        $user = Auth::user();
        $histories = History::where('professional_id','=', $user->id)->get();
        return view('profesional.histories.show', compact('histories'));
    }

    public function HistoriesProfessional(){
        $user = Auth::user();
        $histories = History::where('patient_id','=', $user->id)->get();
        return view('patient.histories.show', compact('histories'));
    }

    public function create(HistoryRequest $request ){
        $history = new History($request->all());
        $history->save();

        return response()->json(['status' => true, 'history' => $history], 200);
    }
   /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, History $history)
    {
        $history->update($request->all());

        return response()->json(['status' => true, 'history' => $history], 200);
    }

}
