<?php

namespace App\Http\Controllers\Admin;

use App\Models\Founder;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;

class FounderController extends Controller
{
    public function index()
    {
        $pageTitle = 'Manage Founders & CEOs';
        $founders = Founder::orderBy('display_order')->paginate(getPaginate());
        return view('admin.founder.index', compact('pageTitle', 'founders'));
    }

    public function create()
    {
        $pageTitle = 'Add New Founder';
        return view('admin.founder.form', compact('pageTitle'));
    }

    public function edit($id)
    {
        $founder = Founder::findOrFail($id);
        $pageTitle = 'Edit Founder';
        return view('admin.founder.form', compact('pageTitle', 'founder'));
    }

  public function store(Request $request, $id = 0)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'designation' => 'required|string|max:255',
        'company' => 'nullable|string|max:255',
        'bio' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'display_order' => 'nullable|integer',
        'status' => 'nullable|in:0,1'
    ]);

    if ($id) {
        $founder = Founder::findOrFail($id);
        $notification = 'Founder updated successfully';
    } else {
        $founder = new Founder();
        $notification = 'Founder added successfully';
    }

    $founder->name = $request->name;
    $founder->designation = $request->designation;
    $founder->company = $request->company;
    $founder->bio = $request->bio;
    $founder->display_order = $request->display_order ?? 0;
    $founder->status = $request->status ?? 1;

    // Handle photo upload
if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
    try {
        $file = $request->file('photo');
        $filename = 'founder_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // EXACT PATH: Upload to core/public/assets/images/founder/
        $directory = base_path('public/assets/images/founder');
        \Log::info('Upload directory: ' . $directory);
        
        // Create directory if not exists
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
            \Log::info('Created directory: ' . $directory);
        }
        
        // Move the file
        $file->move($directory, $filename);
        \Log::info('File saved as: ' . $filename);
        
        // Delete old image if exists
        if ($founder->photo && file_exists($directory . '/' . $founder->photo)) {
            unlink($directory . '/' . $founder->photo);
        }
        
        $founder->photo = $filename;
        \Log::info('Saved to database: ' . $filename);
        
    } catch (\Exception $e) {
        \Log::error('Upload error: ' . $e->getMessage());
    }
}
    $founder->save();

    $notify[] = ['success', $notification];
    return back()->withNotify($notify);
}

    public function status($id)
    {
        $founder = Founder::findOrFail($id);
        $founder->status = $founder->status ? 0 : 1;
        $founder->save();

        $notify[] = ['success', 'Status updated successfully'];
        return back()->withNotify($notify);
    }

    public function delete($id)
    {
        $founder = Founder::findOrFail($id);
        if ($founder->photo) {
            fileManager()->removeFile(getFilePath('founder') . '/' . $founder->photo);
        }
        $founder->delete();

        $notify[] = ['success', 'Founder deleted successfully'];
        return back()->withNotify($notify);
    }
}