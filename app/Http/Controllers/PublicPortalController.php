<?php
namespace App\Http\Controllers;

use App\Models\BurialRecord;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicPortalController extends Controller
{
    public function index()
    {
        return Inertia::render('Public/Portal', [
            'records' => BurialRecord::all(),
            'searchQuery' => ''
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->query('q', '');
        $records = BurialRecord::where('name', 'like', "%$query%")->get();
        return Inertia::render('Public/Portal', [
            'records' => $records,
            'searchQuery' => $query
        ]);
    }

    public function memorial($id)
    {
        $record = BurialRecord::findOrFail($id);
        return Inertia::render('Public/Memorial', [
            'record' => $record
        ]);
    }
}