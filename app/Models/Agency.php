<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',            // Nama Kontraktor
        'address',         // Alamat
        'email',           // Email
        'phone',           // Phone
        'pic_name',        // PIC (Personal In Charge)
        'is_active',       // Status aktif/non-aktif
        'tier',            // Tier level (3-5)
        'max_users',       // Maximum users allowed
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'tier' => 'integer',
        'max_users' => 'integer',
    ];

    /**
     * Get all users belonging to this agency
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get current user count for this agency
     */
    public function getCurrentUserCount()
    {
        return $this->users()->count();
    }

    /**
     * Get current admin_kontraktor count for this agency
     */
    public function getAdminKontraktorCount()
    {
        return $this->users()
            ->whereHas('roles', function ($query) {
                $query->where('name', 'admin_kontraktor');
            })
            ->count();
    }

    /**
     * Check if agency can add more admin_kontraktor users (max 5)
     */
    public function canAddAdminKontraktor()
    {
        return $this->getAdminKontraktorCount() < 5;
    }

    /**
     * Get remaining admin_kontraktor slots
     */
    public function getRemainingAdminKontraktorSlots()
    {
        return max(0, 5 - $this->getAdminKontraktorCount());
    }

    /**
     * Check if agency can add more users (general - for tier system if needed)
     */
    public function canAddUser()
    {
        return $this->getCurrentUserCount() < $this->max_users;
    }

    /**
     * Get remaining user slots (general - for tier system if needed)
     */
    public function getRemainingSlots()
    {
        return max(0, $this->max_users - $this->getCurrentUserCount());
    }

    /**
     * Get tier label
     */
    public function getTierLabelAttribute()
    {
        return match($this->tier) {
            3 => 'Basic',
            4 => 'Standard',
            5 => 'Premium',
            default => 'Unknown'
        };
    }
}
