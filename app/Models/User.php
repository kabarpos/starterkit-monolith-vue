<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';
    const STATUS_REJECTED = 'rejected';
    const STATUS_BANNED = 'banned';
    const STATUS_INACTIVE = 'inactive';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'status',
        'status_reason',
        'approved_at',
        'approved_by',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    protected $appends = [
        'avatar_url',
    ];

    // Accessor untuk avatar URL
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return Storage::disk('public')->url($this->avatar);
        }
        return '/default-avatar.png';
    }

    // Relationships
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Status Check Methods
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function isBanned()
    {
        return $this->status === self::STATUS_BANNED;
    }

    public function isInactive()
    {
        return $this->status === self::STATUS_INACTIVE;
    }

    // Status Update Methods
    public function approve($reason = null)
    {
        $this->update([
            'status' => self::STATUS_ACTIVE,
            'status_reason' => $reason,
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);
    }

    public function reject($reason)
    {
        $this->update([
            'status' => self::STATUS_REJECTED,
            'status_reason' => $reason,
        ]);
    }

    public function ban($reason)
    {
        $this->update([
            'status' => self::STATUS_BANNED,
            'status_reason' => $reason,
        ]);
    }

    public function deactivate($reason = null)
    {
        $this->update([
            'status' => self::STATUS_INACTIVE,
            'status_reason' => $reason,
        ]);
    }

    public function activate($reason = null)
    {
        $this->update([
            'status' => self::STATUS_ACTIVE,
            'status_reason' => $reason,
        ]);
    }

    // Override the default login check
    public function canLogin()
    {
        return $this->isActive();
    }
}