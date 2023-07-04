<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'user_id', 'folder_id', 'username', 'password', 'url', 'notes'
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
}
