<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Valentine extends Model
{
    protected $fillable = ['name', 'slug', 'image', 'birth_date', 'message', 'ucapan', 'photos'];

    protected $casts = [
        'birth_date' => 'date',
        'photos' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($valentine) {
            if (empty($valentine->slug)) {
                $valentine->slug = Str::slug($valentine->name);
                $original = $valentine->slug;
                $count = static::where('slug', 'like', $original.'%')->count();
                if ($count > 0) {
                    $valentine->slug = $original.'-'.$count;
                }
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
