<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\History\HistoryRequest;

class HistoryController extends Controller
{
    public function HistoriesProfessional()
    {
        $users = Auth::user();
        $histories = History::with('patient')->where('professional_id', $users->id)->get();
        return view('pages.historiesProfessional', compact('histories'));
    }
    public function HistoriesProfessionalShow()
    {
        $users = Auth::user();
        $histories = History::with('patient')->where('professional_id', $users->id)->get();
        return response()->json(['status' => true, $histories], 200);
    }

    public function HistoriesPatient()
    {
        $user = Auth::user();
        $histories = History::with('patient')->where('patient_id', $user->id)->get();
        return view('pages.historiesPatient', compact('histories'));
    }
    public function HistoriesPatientShow()
    {
        $user = Auth::user();
        $histories = History::with('patient')->where('patient_id', $user->id)->get();
        return response()->json(['status' => true, $histories], 200);
    }

    public function store(HistoryRequest $request)
    {
        $user = Auth::user();
        $data = $request->all();
        $data['professional_id'] = $user->id;
        $history = new History($data);
        $history->save();

        return response()->json(['status' => true, 'history' => $history], 200);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $history = History::findOrFail($id);
        $history->update(['review' => $request->input('review')]);

        return response()->json(['status' => true, 'history' => $history], 200);
    }
}
