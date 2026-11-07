<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GlobalStatus;

class Industry extends Model
{
    use GlobalStatus;

    protected $casts = [
        'status' => 'boolean',
    ];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'status'
    ];

    // If you want to automatically generate slugs
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($industry) {
            if (empty($industry->slug)) {
                $industry->slug = \Illuminate\Support\Str::slug($industry->name);
            }
        });
    }

    // Relationship with projects
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    // Scope for active industries
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}