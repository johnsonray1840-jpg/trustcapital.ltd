<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Page;
use App\Models\User;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Location;
use App\Models\Project;
use App\Models\Founder;
use App\Constants\Status;
use App\Models\Subscriber;
use App\Models\TimeSetting;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    public function index()
    {
        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }

        $pageTitle = 'Home';
        $sections = Page::where('tempname', activeTemplate())->where('slug', '/')->first();
        $seoContents = $sections->seo_content;
        $seoImage = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        return view('Template::home', compact('pageTitle', 'sections', 'seoContents', 'seoImage'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname', activeTemplate())->where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        $seoContents = $page->seo_content;
        $seoImage = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        return view('Template::pages', compact('pageTitle', 'sections', 'seoContents', 'seoImage'));
    }

    public function contact()
    {
        $pageTitle = "Contact Us";
        $user = auth()->user();
        $sections = Page::where('tempname', activeTemplate())->where('slug', 'contact')->first();
        $contactContent = Frontend::where('data_keys', 'contact_us.content')->firstOrFail();
        $seoContents = $sections->seo_content;
        $seoImage = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        return view('Template::contact', compact('pageTitle', 'user', 'sections', 'seoContents', 'seoImage', 'contactContent'));
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $request->session()->regenerateToken();

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = Status::PRIORITY_MEDIUM;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = Status::TICKET_OPEN;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new contact message has been submitted';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];
        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug)
    {
        $policy = Frontend::where('slug', $slug)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        $seoContents = $policy->seo_content;
        $seoImage = @$seoContents->image ? frontendImage('policy_pages', $seoContents->image, getFileSize('seo'), true) : null;
        return view('Template::policy', compact('policy', 'pageTitle', 'seoContents', 'seoImage'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    public function blogs()
    {
        $pageTitle = 'Blogs';
        $blogs = Frontend::where('data_keys', 'blog.element')->orderByDesc('id')->paginate(getPaginate());
        $sections = Page::where('tempname', activeTemplate())->where('slug', 'blog')->first();
        $seoContents = $sections->seo_content;
        $seoImage = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        return view('Template::blogs', compact('pageTitle', 'blogs', 'sections', 'seoContents', 'seoImage'));
    }

    public function blogDetails($slug)
    {
        $blog = Frontend::where('slug', $slug)->where('data_keys', 'blog.element')->firstOrFail();
        $latestBlogs = Frontend::where('data_keys', 'blog.element')->where('id', '<>', $blog->id)->orderByDesc('id')->take(5)->get();
        $pageTitle = $blog->data_values->title;
        $seoContents = $blog->seo_content;
        $seoImage = @$seoContents->image ? frontendImage('blog', $seoContents->image, getFileSize('seo'), true) : null;
        return view('Template::blog_details', compact('blog', 'pageTitle', 'seoContents', 'seoImage', 'latestBlogs'));
    }

public function project(Request $request)
{
    $pageTitle = 'Projects';
    
    $projects = Project::query();
    
    // Apply filters if present
    if ($request->industry) {
        $projects->where('industry', $request->industry);
    }
    
    if ($request->stage) {
        $projects->where('stage', $request->stage);
    }
    
    // Get active projects
    $projects = $projects->paginate(getPaginate());
    $user = auth()->user();
    
    // Get distinct industries
    $industries = Project::distinct('industry')
        ->whereNotNull('industry')
        ->pluck('industry');
    
    // Get active projects count
    $activeProjects = Project::where('status', 1)->count();
    
    // Get page sections
    $sections = Page::where('tempname', activeTemplate())
        ->where('slug', 'project')
        ->first();
    
    // SEO content
    $seoContents = $sections?->seo_content;
    $seoImage = @$seoContents->image ? 
        getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : 
        null;
    
    // Remove TimeSetting reference if table doesn't exist
    // $times = TimeSetting::orderBy('time')->active()->get();
    $times = collect([]); // Empty collection
    
    return view('templates.basic.project', compact(
        'pageTitle', 
        'projects', 
        'user', 
        'industries', 
        'sections', 
        'seoContents', 
        'seoImage'
    ));
}

public function founders()
{
    $pageTitle = 'Founders & CEOs';
    $founders = Founder::active()->orderBy('display_order')->get();
    
    $sections = Page::where('tempname', activeTemplate())->where('slug', 'founders')->first();
    $seoContents = $sections?->seo_content;
    $seoImage = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
    
    return view('Template::founders', compact('pageTitle', 'founders', 'seoContents', 'seoImage'));
}

   public function projectDetails($slug)
{
    try {
        // First, try to find the project
        $project = Project::where('slug', $slug)->first();
        
        // If project doesn't exist, show 404
        if (!$project) {
            abort(404, 'Project not found');
        }
        
        // Check if user can access this project
        $user = auth()->user();
        
        if (!$project->isAccessibleByUser($user)) {
            // Log the attempt for monitoring
            \Log::info('Inactive project access attempt', [
                'project_id' => $project->id,
                'project_slug' => $slug,
                'user_id' => $user?->id,
                'ip' => request()->ip()
            ]);
            
            // Show a user-friendly "coming soon" page instead of 404
            return view('templates.basic.project_coming_soon', [
                'project' => $project,
                'pageTitle' => 'Project Coming Soon'
            ]);
        }
        
        // Load relationships for accessible projects
        $project->load(['investments' => function ($investments) use ($user) {
            if ($user) {
                $investments->where('user_id', $user->id);
            }
        }, 'projectDocuments']);
        
        $project->loadSum('investments', 'paid_amount');
        $project->loadCount('investments');
        
        $pageTitle = $project->title . ' - Project Details';
        
        // Get other active projects (excluding current)
        $latestProjects = Project::frontendAccessible()
            ->where('id', '<>', $project->id)
            ->orderByDesc('id')
            ->take(6)
            ->get();
        
        // Get top investors (if needed)
        $investors = User::active()->take(5)->get();
        
        // SEO data
        $seoContents = $project->seo_content;
        $seoImage = @$seoContents->image 
            ? getImage(getFilePath('seo') . '/' . $seoContents->image, getFileSize('seo')) 
            : null;
        
        return view('templates.basic.project_details', compact(
            'pageTitle', 
            'project', 
            'user', 
            'investors', 
            'latestProjects', 
            'seoContents', 
            'seoImage'
        ));
        
    } catch (\Exception $e) {
        \Log::error('Project details error: ' . $e->getMessage(), [
            'slug' => $slug,
            'trace' => $e->getTraceAsString()
        ]);
        
        abort(500, 'Error loading project details');
    }
}

    public function cookieAccept()
    {
        Cookie::queue('gdpr_cookie', gs('site_name'), 43200);
    }

    public function cookiePolicy()
    {
        $cookieContent = Frontend::where('data_keys', 'cookie.data')->first();
        abort_if($cookieContent->data_values->status != Status::ENABLE, 404);
        $pageTitle = 'Cookie Policy';
        $cookie = Frontend::where('data_keys', 'cookie.data')->first();
        return view('Template::cookie', compact('pageTitle', 'cookie'));
    }

    public function placeholderImage($size = null)
    {
        $imgWidth = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font/solaimanLipi_bold.ttf');
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function maintenance()
    {
        $pageTitle = 'Maintenance Mode';
        if (gs('maintenance_mode') == Status::DISABLE) {
            return to_route('home');
        }
        $maintenance = Frontend::where('data_keys', 'maintenance.data')->first();
        return view('Template::maintenance', compact('pageTitle', 'maintenance'));
    }

    public function addSubscriber(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:subscribers,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $subscriber        = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->save();

        return response()->json(['success' => true, 'message' => 'Subscribed successfully']);
    }
}
