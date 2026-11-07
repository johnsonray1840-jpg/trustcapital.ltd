<?php

namespace App\Http\Controllers\User;

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use App\Models\Industry;
use App\Models\Project;
use App\Models\ProjectDocument;
use App\Models\Invest;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    // Show submission form
    public function create()
    {
        $pageTitle = 'Submit Project';
        $industries = Industry::active()->get();
        return view('templates.basic.user.project.create', compact('pageTitle', 'industries'));
    }
    
    // Store new project - FIXED VERSION
//   public function store(Request $request)
// {
//     $request->validate([
//         'title' => 'required|string|max:255',
//         'company_name' => 'required|string|max:255',
//         'industry' => 'required|string|max:255',
//         'stage' => 'required|in:idea,prototype,mvp,revenue,scaling',
//         'funding_goal' => 'required|numeric|min:1000',
//         'equity_offered' => 'required|integer|min:1|max:100',
//         'problem_statement' => 'required|string',
//         'solution' => 'required|string',
//         'business_model' => 'required|string',
//         'details' => 'required|string',
//         'team_members' => 'nullable|array',
//         'pitch_deck' => ['nullable', 'file', 'mimes:pdf,ppt,pptx,doc,docx', 'max:5120'],
//     ]);
    
//     $project = new Project();
//     $project->user_id = auth()->id();
//     $project->title = $request->title;
//     $project->company_name = $request->company_name;
//     $project->industry = $request->industry;
//     $project->stage = $request->stage;
//     $project->funding_goal = $request->funding_goal;
//     $project->equity_offered = $request->equity_offered;
//     $project->problem_statement = $request->problem_statement;
//     $project->solution = $request->solution;
//     $project->business_model = $request->business_model;
//     $project->details = $request->details;
//     $project->team_members = $request->team_members ?? [];
//     $project->status = 0;
//     $project->complete_step = 1;
//     $project->project_type = 'startup';
    
//     $project->save();
    
//     // SIMPLE FILE UPLOAD - NO COMPLEX FILE MANAGER
//     if ($request->hasFile('pitch_deck')) {
//         try {
//             $file = $request->file('pitch_deck');
//             $filename = 'pitch_' . time() . '_' . $project->id . '.' . $file->getClientOriginalExtension();
            
//             // Create directory
//             $directory = public_path('assets/files/project_documents');
//             if (!file_exists($directory)) {
//                 mkdir($directory, 0755, true);
//             }
            
//             // Move file
//             $file->move($directory, $filename);
            
//             $project->pitch_deck_url = 'assets/files/project_documents/' . $filename;
//             $project->save();
            
//         } catch (\Exception $exp) {
//             \Log::error('File upload failed: ' . $exp->getMessage());
//             // Don't stop if upload fails
//         }
//     }
    
//     $notify[] = ['success', 'Project submitted for admin approval!'];
//     return redirect()->route('user.project.my')->withNotify($notify);
// }

  /**
     * Display the project details page
     */
    public function details($slug)
    {
        // Find the project by slug
        $project = Project::where('slug', $slug)->first();
        
        // If project not found, show 404
        if (!$project) {
            abort(404, 'Project not found');
        }
        
        // Return the view with project data
        return view('project.details', compact('project'));
    }

public function store(Request $request)
{
    \Log::info('=== PROJECT SUBMISSION STARTED ===');
    \Log::info('User ID: ' . auth()->id());
    \Log::info('Request Data: ', $request->all());
    \Log::info('Has File: ' . ($request->hasFile('pitch_deck') ? 'Yes' : 'No'));
    
    try {
        $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'stage' => 'required|in:idea,prototype,mvp,revenue,scaling',
            'funding_goal' => 'required|numeric|min:1000',
            'equity_offered' => 'required|integer|min:1|max:100',
            'problem_statement' => 'required|string',
            'solution' => 'required|string',
            'business_model' => 'required|string',
            'details' => 'required|string',
            'team_members' => 'nullable|array',
            'pitch_deck' => ['nullable', 'file', 'mimes:pdf,ppt,pptx,doc,docx', 'max:5120'],
        ]);
        
        \Log::info('Validation passed');
        
        $project = new Project();
        $project->user_id = auth()->id();
        $project->title = $request->title;
        $project->company_name = $request->company_name;
        $project->industry = $request->industry;
        $project->stage = $request->stage;
        $project->funding_goal = $request->funding_goal;
        $project->equity_offered = $request->equity_offered;
        $project->problem_statement = $request->problem_statement;
        $project->solution = $request->solution;
        $project->business_model = $request->business_model;
        $project->details = $request->details;
        $project->team_members = $request->team_members ?? [];
        $project->status = 0;
        $project->complete_step = 1;
        $project->project_type = 'startup';
        
        $project->save();
        \Log::info('Project saved with ID: ' . $project->id);
        
        // SIMPLIFIED FILE UPLOAD
        if ($request->hasFile('pitch_deck')) {
            \Log::info('Attempting file upload');
            try {
                $file = $request->file('pitch_deck');
                $filename = 'pitch_' . time() . '_' . $project->id . '.' . $file->getClientOriginalExtension();
                
                // Use absolute path
                $directory = $_SERVER['DOCUMENT_ROOT'] . '/assets/files/project_documents';
                \Log::info('Upload directory: ' . $directory);
                
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true);
                    \Log::info('Directory created');
                }
                
                $file->move($directory, $filename);
                \Log::info('File moved successfully');
                
                $project->pitch_deck_url = 'assets/files/project_documents/' . $filename;
                $project->save();
                \Log::info('File URL saved: ' . $project->pitch_deck_url);
                
            } catch (\Exception $exp) {
                \Log::error('File upload error: ' . $exp->getMessage());
                \Log::error('Trace: ' . $exp->getTraceAsString());
            }
        }
        
        \Log::info('=== PROJECT SUBMISSION COMPLETED ===');
        $notify[] = ['success', 'Project submitted for admin approval!'];
        return redirect()->route('user.project.my')->withNotify($notify);
        
    } catch (\Exception $e) {
        \Log::error('=== STORE METHOD ERROR ===');
        \Log::error('Error Message: ' . $e->getMessage());
        \Log::error('File: ' . $e->getFile());
        \Log::error('Line: ' . $e->getLine());
        \Log::error('Trace: ' . $e->getTraceAsString());
        
        // Show error on screen for debugging
        return back()->withErrors(['error' => 'Debug: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine()]);
    }
}
    
    // List user's projects
    public function myProjects()
    {
        $pageTitle = 'My Projects';
        $projects = Project::where('user_id', auth()->id())
            ->with('projectDocuments')
            ->orderBy('created_at', 'desc')
            ->paginate(getPaginate());
            
        return view('templates.basic.user.project.my', compact('pageTitle', 'projects'));
    }
    
    // Edit project
    public function edit($id)
    {
        $project = Project::where('user_id', auth()->id())->findOrFail($id);
        $pageTitle = 'Edit Project';
        return view('templates.basic.user.project.edit', compact('pageTitle', 'project'));
    }
    
    // Update project
    public function update(Request $request, $id)
    {
        $project = Project::where('user_id', auth()->id())->findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'stage' => 'required|in:idea,prototype,mvp,revenue,scaling',
            'funding_goal' => 'required|numeric|min:1000',
            'equity_offered' => 'required|integer|min:1|max:100',
            'problem_statement' => 'required|string',
            'solution' => 'required|string',
            'business_model' => 'required|string',
            'details' => 'required|string',
            'team_members' => 'nullable|array',
        ]);
        
        $project->title = $request->title;
        $project->company_name = $request->company_name;
        $project->industry = $request->industry;
        $project->stage = $request->stage;
        $project->funding_goal = $request->funding_goal;
        $project->equity_offered = $request->equity_offered;
        $project->problem_statement = $request->problem_statement;
        $project->solution = $request->solution;
        $project->business_model = $request->business_model;
        $project->details = $request->details;
        $project->team_members = $request->team_members ?? [];
        
        $project->save();
        
        $notify[] = ['success', 'Project updated successfully!'];
        return back()->withNotify($notify);
    }
    
    public function uploadDocument(Request $request, $id)
    {
        $request->validate([
            'document' => ['required', 'file', 'mimes:pdf', 'max:5120'],
        ]);
        
        $project = Project::where('user_id', auth()->id())->findOrFail($id);
        
        if (!$request->hasFile('document') || !$request->file('document')->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'File upload failed or file is invalid'
            ], 400);
        }
        
        $file = $request->file('document');
        
        try {
            $originalName = $file->getClientOriginalName();
            $filename = 'project_' . $id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Create directory
            $uploadDir = public_path('assets/files/project_documents');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            // Move the file
            $file->move($uploadDir, $filename);
            
            // Save to database
            $document = new ProjectDocument();
            $document->project_id = $project->id;
            $document->file_path = $filename;
            $document->file_name = $originalName;
            $document->file_type = $file->getClientMimeType();
            $document->file_size = $file->getSize();
            $document->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Document uploaded successfully!',
                'filename' => $filename
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Upload error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadDocumentSimple(Request $request, $id)
    {
        $request->validate([
            'document' => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ]);
        
        $project = Project::where('user_id', auth()->id())->findOrFail($id);
        
        try {
            $file = $request->file('document');
            $originalName = $file->getClientOriginalName();
            $filename = 'doc_' . time() . '_' . $project->id . '.' . $file->getClientOriginalExtension();
            
            // Create directory
            $uploadPath = public_path('assets/files/project_documents');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Move the file
            $file->move($uploadPath, $filename);
            
            // Save to database
            $document = new ProjectDocument();
            $document->project_id = $project->id;
            $document->file_path = $filename;
            $document->file_name = $originalName;
            $document->file_type = $file->getClientMimeType();
            $document->file_size = $file->getSize();
            $document->save();
            
            $notify[] = ['success', 'Document uploaded!'];
            return back()->withNotify($notify);
            
        } catch (\Exception $e) {
            $notify[] = ['error', 'Upload failed: ' . $e->getMessage()];
            return back()->withNotify($notify);
        }
    }
    
    // Delete document
    public function deleteDocument(Request $request, $id)
    {
        $document = ProjectDocument::whereHas('project', function($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);
        
           // ADD THIS INSTEAD:
    $filePath = public_path('assets/files/project_documents/' . $document->file_path);
    if (file_exists($filePath)) {
        @unlink($filePath);
    }
        
        $document->delete();
        
        $notify[] = ['success', 'Document deleted successfully!'];
        return back()->withNotify($notify);
    }
    
    // View project investors
    public function projectInvestors($id)
    {
        $project = Project::where('user_id', auth()->id())->findOrFail($id);
        
        $investors = Invest::where('project_id', $project->id)
            ->with('user')
            ->paginate(getPaginate());
            
        $pageTitle = 'Project Investors';
        return view('templates.basic.user.project.investors', compact('pageTitle', 'project', 'investors'));
    }
}