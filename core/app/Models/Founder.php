<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Founder extends Model
{
    protected $casts = [
        'social_links' => 'array'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function photoUrl(): Attribute
    {
        return new Attribute(function() {
            if ($this->photo) {
                return getImage(getFilePath('founder') . '/' . $this->photo, getFileSize('founder'));
            }
            return getImage('placeholder');
        });
    }
}