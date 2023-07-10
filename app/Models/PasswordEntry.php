<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class PasswordEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'user_id', 'folder_id', 'username', 'password', 'url', 'notes', 'order'
    ];

    protected $hidden = [
        'password',
        'user_id'
    ];

    protected $appends = [
        'formatted_modified_at',
        'has_password',
    ];

    protected function formattedModifiedAt(): Attribute
    {
        return new Attribute(
            get: fn () => $this->updated_at->format('Y.m.d. H:i:s')
        );
    }

    protected function hasPassword(): Attribute
    {
        return new Attribute(
            get: fn () => $this->password != null
        );
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function moveToFolder($folderId)
    {
        $this->folder_id = $folderId;
        $this->save();
    }

    public function setOrderTo($newOrder)
    {
        $this->order = $newOrder;
        $this->save();

        Log::info(sprintf("Updated order of entry %s, new order is: %d", $this->title, $this->order));
    }
}
