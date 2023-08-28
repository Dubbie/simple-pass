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
        return $this->hasMany(Folder::class, 'parent_id', 'id')->orderBy('order');
    }

    public function parentFolder()
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function entries()
    {
        return $this->hasMany(PasswordEntry::class)->orderBy('order');
    }

    public function withEntries()
    {
        return Folder::with('entries')->find($this->id);
    }

    public function updateParent($newParentId)
    {
        $this->parent_id = $newParentId;
        $this->save();
    }

    public function updateOrder($order)
    {
        $this->order = $order;
        $this->save();
    }

    public function updateSubfoldersParent($newParentId)
    {
        $subFolders = $this->subFolders;

        foreach ($subFolders as $subFolder) {
            $subFolder->parent_id = $newParentId;
            $subFolder->save();

            $subFolder->updateSubfoldersParent($subFolder->id);
        }
    }

    public function deleteSubfolders()
    {
        if ($this->subFolders()->count() > 0) {
            foreach ($this->subFolders as $subFolder) {
                $subFolder->delete();

                $subFolder->deleteSubfolders();
            }
        }
    }

    public function deleteEntries()
    {
        $ids = $this->entries->pluck('id')->toArray();
        PasswordEntry::whereIn('id', $ids)->delete();
    }

    protected static function booted()
    {
        static::deleting(function ($folder) {
            // Move the entries to the parent folder.
            $folder->entries()->update(['folder_id' => $folder->parent_id]);
        });
    }
}
