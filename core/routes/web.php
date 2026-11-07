<?php

use Illuminate\Support\Facades\Route;

Route::get('/clear', function(){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

Route::get('cron', 'CronController@cron')->name('cron');
Route::get('founders', 'SiteController@founders')->name('founders');

// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', 'supportTicket')->name('index');
    Route::get('new', 'openSupportTicket')->name('open');
    Route::post('create', 'storeSupportTicket')->name('store');
    Route::get('view/{ticket}', 'viewTicket')->name('view');
    Route::post('reply/{id}', 'replyTicket')->name('reply');
    Route::post('close/{id}', 'closeTicket')->name('close');
    Route::get('download/{attachment_id}', 'ticketDownload')->name('download');
});

Route::controller('SiteController')->group(function () {
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');
    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');
    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');
    Route::get('blog', 'blogs')->name('blog');
    Route::get('blog/{slug}', 'blogDetails')->name('blog.details');
    Route::get('projects', 'SiteController@project')->name('project');
    Route::get('project/details/{slug}', 'SiteController@projectDetails')->name('project.details'); // ✅ Keep this one
    Route::get('policy/{slug}', 'policyPages')->name('policy.pages');
    Route::post('/subscribe', 'addSubscriber')->name('subscribe');
    Route::get('placeholder-image/{size}', 'placeholderImage')->withoutMiddleware('maintenance')->name('placeholder.image');
    Route::get('maintenance-mode','maintenance')->withoutMiddleware('maintenance')->name('maintenance');
    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');
});

// ❌ REMOVE or COMMENT OUT this entire block:
// Route::get('/project/details/{slug}', [ProjectController::class, 'details'])->name('project.details');

// Add this route
Route::get('/generate-cis', [PdfController::class, 'generateCis'])->name('generate.cis');

Route::get('/debug-project/{slug}', function($slug) {
    try {
        // Check if project exists
        $project = \App\Models\Project::where('slug', $slug)->first();
        
        if (!$project) {
            return "No project found with slug: $slug";
        }
        
        return response()->json([
            'exists' => true,
            'id' => $project->id,
            'title' => $project->title,
            'status' => $project->status,
            'complete_step' => $project->complete_step,
            'slug' => $project->slug
        ]);
        
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});