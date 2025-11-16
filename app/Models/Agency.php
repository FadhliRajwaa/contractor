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
    ];

    protected $casts = [
        'is_active' => 'boolean',
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

}
