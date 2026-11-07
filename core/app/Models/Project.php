<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;


class Project extends Model
{
    use GlobalStatus;

    protected $casts = [
        'amenities' => 'array',
        'keywords'   => 'array',
        'seo_content' => 'object',
        'team_members' => 'array'
    ];

    public function industry()
    {
    return $this->belongsTo(Industry::class, 'industry_id');
    }

    public function investments()
    {
        return $this->hasMany(Invest::class);
    }

    public function founder()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', Status::ENABLE)->where('complete_step', 2);
    }

    public function scopeFunding($query)
    {
        return $query->where('stage', 'funding');
    }

    public function scopeFunded($query)
    {
        return $query->where('stage', 'funded');
    }

    public function fundingProgress(): Attribute
    {
        return new Attribute(function () {
            $fundingRaised = $this->investments()->sum('paid_amount') ?? 0;
            $fundingGoal = $this->funding_goal ?? 0;

            if ($fundingRaised > 0 && $fundingGoal > 0) {
                $progress = ($fundingRaised * 100) / $fundingGoal;
            } else {
                $progress = 0;
            }

            return $progress;
        });
    }

    public function fundingStatus(): Attribute
    {
        return new Attribute(function () {
            $progress = $this->funding_progress;
            
            if ($progress >= 100) {
                return '<span class="badge badge--success">' . trans('Fully Funded') . '</span>';
            } elseif ($progress > 0) {
                return '<span class="badge badge--primary">' . trans('Funding') . ' (' . getAmount($progress) . '%)</span>';
            } else {
                return '<span class="badge badge--warning">' . trans('Seeking Funding') . '</span>';
            }
        });
    }
    
    public function getFundingProgressAttribute()
{
    $invested = $this->investments()->sum('paid_amount') ?? 0;
    $goal = $this->funding_goal ?? 0;
    
    if ($goal > 0) {
        return ($invested * 100) / $goal;
    }
    
    return 0;
}

// Add to the model class
protected static function boot()
{
    parent::boot();
    
    static::creating(function ($project) {
        if (empty($project->slug)) {
            $project->slug = Str::slug($project->title) . '-' . Str::random(6);
        }
    });
    
    static::updating(function ($project) {
        if (empty($project->slug)) {
            $project->slug = Str::slug($project->title) . '-' . Str::random(6);
        }
    });
}

// Add these methods to your existing Project model

/**
 * Scope for frontend - only show projects that should be public
 */
public function scopeFrontendAccessible($query)
{
    return $query->where('status', Status::ENABLE)
                 ->where('complete_step', 2);
}

/**
 * Check if project is accessible by current user
 */
public function isAccessibleByUser($user = null)
{
    // Admin can always access
    if ($user && $user->isAdmin()) {
        return true;
    }
    
    // Project owner can access their own projects even if inactive
    if ($user && $this->user_id == $user->id) {
        return true;
    }
    
    // For everyone else, must be active
    return $this->status == Status::ENABLE && $this->complete_step == 2;
}

/**
 * Get appropriate projects based on user role
 */
public function scopeForUser($query, $user = null)
{
    if ($user && $user->isAdmin()) {
        // Admin sees all
        return $query;
    }
    
    if ($user) {
        // Regular users see their own projects + all active projects
        return $query->where(function($q) use ($user) {
            $q->where('user_id', $user->id)
              ->orWhere(function($subQ) {
                  $subQ->frontendAccessible();
              });
        });
    }
    
    // Guests only see active projects
    return $query->frontendAccessible();
}

public function projectDocuments()
{
    return $this->hasMany(ProjectDocument::class);
}

    public function stageBadge(): Attribute
    {
        return new Attribute(function () {
            $stageColors = [
                'idea' => 'warning',
                'prototype' => 'info',
                'mvp' => 'primary',
                'revenue' => 'success',
                'scaling' => 'dark'
            ];
            
            $color = $stageColors[$this->stage] ?? 'secondary';
            return '<span class="badge badge--' . $color . '">' . trans(ucfirst($this->stage)) . '</span>';
        });
    }
}