<?php

namespace App\Http\Controllers\Admin;

use App\Models\Industry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndustryController extends Controller
{
    public function index()
    {
        $pageTitle = 'Manage Industries';
        $industries = Industry::orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.industry.index', compact('pageTitle', 'industries'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:industries,name,' . $id,
        ]);

        if ($id) {
            $industry = Industry::findOrFail($id);
            $message = 'Industry updated successfully';
        } else {
            $industry = new Industry();
            $message = 'Industry added successfully';
        }

        $industry->name = $request->name;
        $industry->slug = slug($request->name);
        $industry->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function changeStatus($id)
    {
        $industry = Industry::findOrFail($id);
        $industry->status = $industry->status ? 0 : 1;
        $industry->save();

        $notify[] = ['success', 'Status updated successfully'];
        return back()->withNotify($notify);
    }
}