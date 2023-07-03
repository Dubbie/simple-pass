<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    protected $with = ['subFolders'];

    protected $fillable = [
        'name', 'user_id', 'description', 'parent_id'
    ];

    public function subFolders()
    {
        return $this->hasMany(Folder::class, 'parent_id', 'id');
    }

    public function scopeRoot()
    {
        return $this->whereNull('parent_id');
    }
}
