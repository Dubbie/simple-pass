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

    public function parentFolder()
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    public function scopeRoot()
    {
        return $this->whereNull('parent_id');
    }

    public function entries()
    {
        return $this->hasMany(PasswordEntry::class);
    }

    public function withEntries()
    {
        return Folder::with('entries')->find($this->id);
    }

    protected static function booted()
    {
        static::deleting(function ($folder) {
            // Move the entries to the parent folder.
            if ($folder->parent_id) {
                $folder->entries()->update(['folder_id' => $folder->parent_id]);
            }
        });
    }
}
