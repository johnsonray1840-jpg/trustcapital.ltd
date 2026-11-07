<?php

namespace App\Http\Controllers\Admin;

use App\Models\Industry;
use App\Models\Project;
use App\Constants\Status;
use App\Models\TimeSetting;
use Illuminate\Http\Request;
use App\Models\ProjectDocument;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class ProjectController extends Controller
{
 public function index()
{
    $pageTitle = 'All Projects';
    $projects = Project::with('founder')->orderBy('id', 'desc')->paginate(20); // ← .paginate() returns Paginator
    
    return view('admin.property.index', compact('pageTitle', 'projects'));
}

    public function fundedProjects()
    {
        $pageTitle = 'Funded Projects';
        $projects = $this->projectData('funded');
        return view('admin.project.index', compact('pageTitle', 'projects'));
    }

    public function pendingProjects()
    {
        $pageTitle = 'Pending Projects';
        $projects = Project::where('status', 0)->paginate(getPaginate());
        return view('admin.project.index', compact('pageTitle', 'projects'));
    }

    protected function projectData($scope = null)
    {
        $projects = Project::withSum('investments', 'paid_amount')->with('industry');
        if ($scope == 'funded') {
            $projects = $projects->where('stage', 'funded');
        }
        return $projects->searchable(['title', 'company_name', 'industry'])->orderBy('id', 'desc')->paginate(getPaginate());
    }

    public function create()
    {
        $pageTitle  = 'Add New Project';
        $industries = Industry::active()->get();
        $times      = TimeSetting::active()->get();
        abort_if(request()->step && !in_array(request()->step, [1, 2]), 404);
        $step = request()->step ??  1;

        $existingProject = Project::where('complete_step', 1)->first();

        if ($existingProject) {
            return redirect(route('admin.manage.project.edit', $existingProject->id) . "?step=2");
        }

        return view('admin.project.form', compact('pageTitle', 'industries', 'times', 'step'));
    }
    
    public function update(Request $request, $id)
{
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
        'status' => 'required|in:0,1,2',
    ]);
    
    $project = Project::findOrFail($id);
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
    $project->status = $request->status;
    
    $project->save();
    
    $notify[] = ['success', 'Project updated successfully'];
    return back()->withNotify($notify);
}

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'step' => 'required|in:1,2,3,4'
        ]);
        $methods = [1 =>  'stepOne', 2 =>  'stepTwo', 3 => 'stepThree', 4 => 'stepFour'];
        $method  = $methods[$request->step];
        return $this->$method($request, $id);
    }

    private function stepOne($request, $id)
    {
        $this->projectValidation($request, $id);

        if ($id) {
            $project = Project::findOrFail($id);
            $message  = 'Project updated successfully';
        } else {
            $project = new Project();
            $message  = 'Project created successfully';
        }

        $project->title         = $request->title;
        $project->slug          = $request->slug;
        $project->company_name  = $request->company_name;
        $project->industry      = $request->industry;
        $project->stage         = $request->stage;
        $project->details       = $request->details;
        $project->problem_statement = $request->problem_statement;
        $project->solution      = $request->solution;
        $project->business_model = $request->business_model;
        $project->keywords      = $request->keywords ?? null;

        if ($request->hasFile('thumb_image')) {
            $project->thumb_image = $this->uploadThumb($request, $project);
        }

        $project->save();

        $this->removeDocumentImages($request, $project);

        if ($request->hasFile('gallery_image')) {
            $this->uploadDocumentImages($request, $project);
        }

        if ($project->complete_step == 2) {
            $redirectUrl = route('admin.manage.project.edit', $project->id) . "?step=1";
        } else {
            $redirectUrl = route('admin.manage.project.edit', $project->id) . "?step=2";
        }

        $notify[] = ['success', $message];
        return redirect($redirectUrl)->withNotify($notify);
    }

    private function stepTwo($request, $id)
    {
        $this->projectValidation($request, $id, 2);

        if ($id) {
            $project = Project::findOrFail($id);
            $message  = 'Project updated successfully';
        } else {
            $project = new Project();
            $message  = 'Project created successfully';
        }

        $minimumInvestment = $request->minimum_investment;

        if ($request->invest_type == Status::INVEST_TYPE_INSTALLMENT) {
            $dowPaymentAmount         = ($minimumInvestment / 100) * $request->down_payment;
            $amountExcludeDownPayment = $minimumInvestment - $dowPaymentAmount;
            $perInstallment           = $amountExcludeDownPayment / $request->total_installment;
        }

        $project->invest_type      = $request->invest_type;
        $project->max_investors    = $request->max_investors;
        $project->minimum_investment = $minimumInvestment;
        $project->funding_goal     = $request->funding_goal;
        $project->funding_target   = $request->funding_goal;
        $project->equity_offered   = $request->equity_offered;
        $project->is_capital_back  = $request->is_capital_back;
        $project->profit_back      = $request->profit_back;

        $project->per_installment_amount = @$perInstallment ?? 0;
        $project->down_payment           = $request->down_payment ?? 0;
        $project->total_installment      = $request->total_installment ?? 0;
        $project->installment_late_fee   = $request->installment_late_fee ?? 0;
        $project->installment_duration   = $request->installment_duration ?? 0;

        $project->profit_type           = $request->profit_type;
        $project->profit_amount_type    = $request->profit_amount_type;
        $project->profit_amount         = $request->profit_amount ?? 0;
        $project->minimum_profit_amount = $request->minimum_profit_amount ?? 0;
        $project->maximum_profit_amount = $request->maximum_profit_amount ?? 0;

        $project->profit_schedule                 = $request->profit_schedule;
        $project->profit_schedule_period          = $request->profit_schedule_period ?? 0;
        $project->profit_repeat_time              = $request->profit_repeat_time ?? 0;
        $project->profit_distribution             = $request->profit_distribution;
        $project->auto_profit_distribution_amount = $request->auto_profit_distribution_amount ?? 0;
        $project->complete_step                   = 2;
        $project->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    private function stepThree($request, $id)
    {
        $this->projectValidation($request, $id, 3);

        if ($id) {
            $project = Project::findOrFail($id);
            $image = @$project->seo_content->image;
            $message  = 'Project updated successfully';
        } else {
            $project = new Project();
            $message  = 'Project created successfully';
        }

        if ($request->hasFile('image')) {
            try {
                $path = getFilePath('seo');
                $image = fileUploader($request->image, $path, getFileSize('seo'), @$project->seo_content->image);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload the image'];
                return back()->withNotify($notify);
            }
        }
        $project->seo_content = [
            'image' => $image,
            'description' => $request->description,
            'social_title' => $request->social_title,
            'social_description' => $request->social_description,
            'keywords' => $request->keywords,
        ];
        $project->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    private function stepFour($request, $id)
    {
        $this->projectValidation($request, $id, 4);

        if ($id) {
            $project = Project::findOrFail($id);
            $message  = 'Project updated successfully';
        } else {
            $project = new Project();
            $message  = 'Project created successfully';
        }

        $project->video = $request->video;
        $project->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    protected function removeDocumentImages($request, $project)
    {
        $images         = ProjectDocument::where('project_id', $project->id)->pluck('id')->toArray();
        $imageToRemove  = array_values(array_diff($images, $request->old ?? []));
        $projectImages = ProjectDocument::whereIn('id', $imageToRemove);
        foreach ($projectImages->get() as $image) {
            fileManager()->removeFile(getFilePath('propertyGallery') . '/' . $image->image);
        }
        $projectImages->delete();
    }

    protected function uploadDocumentImages($request, $project)
    {
        foreach ($request->gallery_image as $image) {
            $projectDocument = new ProjectDocument();
            try {
                $imageName = fileUploader($image, getFilePath('propertyGallery'), getFileSize('propertyGallery'));
                $projectDocument->project_id = $project->id;
                $projectDocument->image = $imageName;
                $projectDocument->save();
            } catch (\Exception $exp) {
                throw ValidationException::withMessages(['error' => 'Couldn\'t upload your image']);
            }
        }
    }
    
    protected function uploadThumb($request, $project)
    {
        @$old = $project->thumb_image;
        try {
            return fileUploader($request->thumb_image, getFilePath('propertyThumb'), getFileSize('propertyThumb'), @$old, @fileManager()->propertyThumb()->thumb);
        } catch (\Exception $exp) {
            throw ValidationException::withMessages(['error' => 'Couldn\'t upload your image']);
        }
    }

    public function edit($id)
    {
        $pageTitle       = 'Edit Project';
        $industries      = Industry::active()->get();
        $times           = TimeSetting::active()->get();
        $project        = Project::findOrFail($id);
        $projectDocuments = ProjectDocument::where('project_id', $project->id)->get();

        $images = [];

        foreach ($projectDocuments as $key => $image) {
            $img['id']  = $image->id;
            $img['src'] = getImage(getFilePath('propertyGallery') . '/' . $image->image);
            $images[]   = $img;
        }

        abort_if(request()->step && !in_array(request()->step, [1, 2, 3, 4]), 404);
        $step = request()->step ??  1;

        return view('admin.property.edit', compact('pageTitle', 'industries', 'project', 'times', 'images', 'step'));
    }

    public function changeStatus($id)
    {
        return Project::changeStatus($id);
    }

    public function changeFeaturedStatus($id)
    {
        return Project::changeStatus($id, 'is_featured');
    }

    public function checkSlug($id = null)
    {
        $project = Project::where('slug', request()->slug);
        if ($id) {
            $project = $project->where('id', '<>', $id);
        }
        $exist = $project->exists();
        return response()->json([
            'exists' => $exist
        ]);
    }

    private function projectValidation($request, $id = 0, $step = 1)
    {
        if ($step == 2) {
            $profitSchedulePeriodValidation         = $request->profit_schedule == Status::PROFIT_REPEATED_TIME ? 'required|gt:0|' : 'nullable|';
            $installStatus                          = Status::INVEST_TYPE_INSTALLMENT;
            $profitFixedStatus                      = Status::PROFIT_TYPE_FIXED;
            $profitRangeStatus                      = Status::PROFIT_TYPE_RANGE;
            $autoProfitDistributionAmountValidation = $request->profit_type == $profitRangeStatus && $request->profit_distribution == Status::PROFIT_DISTRIBUTION_AUTO ? 'required' : 'nullable';

            $request->validate([
                'invest_type'      => 'required|in:' . Status::INVEST_TYPE_ONETIME . ',' . Status::INVEST_TYPE_INSTALLMENT,
                'max_investors'    => 'required|integer|gt:0',
                'minimum_investment' => 'required|integer|gt:0',
                'funding_goal'     => 'required|integer|gt:0',
                'equity_offered'   => 'required|integer|min:1|max:100',
                'is_capital_back'  => 'required|in:' . Status::CAPITAL_BACK_YES . ',' . Status::CAPITAL_BACK_NO,
                'profit_back'      => 'required|integer',

                'total_installment'    => "required_if:invest_type,$installStatus|numeric|gt:0",
                'down_payment'         => "required_if:invest_type,$installStatus|numeric|gt:0",
                'installment_late_fee' => "required_if:invest_type,$installStatus|numeric|gt:0",
                'installment_duration' => "required_if:invest_type,$installStatus|integer|gt:0",

                'profit_type'           => "required|in:$profitFixedStatus,$profitRangeStatus",
                'profit_amount_type'    => 'required|in:' . Status::PROFIT_AMOUNT_TYPE_FIXED . ',' . Status::PROFIT_AMOUNT_TYPE_PERCENT,
                'profit_amount'         => "required_if:profit_type,$profitFixedStatus|gt:0",
                'minimum_profit_amount' => "required_if:profit_type,$profitRangeStatus|gt:0",
                'maximum_profit_amount' => "required_if:profit_type,$profitRangeStatus|gt:0",

                'profit_schedule'                 => 'required|in:' . Status::PROFIT_ONETIME . ',' . Status::PROFIT_LIFETIME . ',' . Status::PROFIT_REPEATED_TIME,
                'profit_schedule_period'          => 'required_if:profit_schedule,' . Status::PROFIT_REPEATED_TIME . ',' . Status::PROFIT_LIFETIME . '|exists:time_settings,id',
                'profit_repeat_time'              => $profitSchedulePeriodValidation . 'integer',
                'profit_distribution'             => 'required|in:' . Status::PROFIT_DISTRIBUTION_MANUAL . ',' . Status::PROFIT_DISTRIBUTION_AUTO,
                'auto_profit_distribution_amount' => "$autoProfitDistributionAmountValidation|gt:0",
            ]);
        } elseif ($step == 3) {
            $request->validate([
                'image' => ['nullable', new FileTypeValidate(['jpeg', 'jpg', 'png'])]
            ]);
        } elseif ($step == 4) {
            $request->validate([
                'video'         => 'required'
            ]);
        } else {
            $imageRequired = $id  ? 'nullable' :   'required';
            $request->validate([
                'thumb_image'     => [$imageRequired, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
                'gallery_image.*' => [$imageRequired, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],

                'title'           => 'required|max:255',
                'slug'            => 'required|max:255',
                'company_name'    => 'required|max:255',
                'industry'        => 'required|max:255',
                'stage'           => 'required|in:idea,prototype,mvp,revenue,scaling',
                'problem_statement' => 'required',
                'solution'        => 'required',
                'business_model'  => 'required',
                'details'         => 'required',
            ]);
        }
    }
}