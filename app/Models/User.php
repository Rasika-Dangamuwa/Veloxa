<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'phone',
        'employee_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->is_active === true || $this->is_active === 1;
    }

    /**
     * Get dashboard route based on role
     */
    public function getDashboardRoute(): string
    {
        return match($this->role) {
            'propagandist' => '/propagandist/dashboard',
            'manager' => '/manager/dashboard',
            'hod' => '/hod/dashboard',
            'warehouse' => '/warehouse/dashboard',
            'master_admin' => '/admin/dashboard',
            default => '/dashboard',
        };
    }

    /**
     * Get role display name
     */
    public function getRoleDisplayName(): string
    {
        return match($this->role) {
            'propagandist' => 'Propagandist',
            'manager' => 'Manager',
            'hod' => 'Head of Department',
            'warehouse' => 'Warehouse Staff',
            'master_admin' => 'System Administrator',
            default => 'User',
        };
    }

    /**
     * Scope to get only active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get users by role
     */
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Get all available roles
     */
    public static function getRoles(): array
    {
        return [
            'propagandist' => 'Propagandist',
            'manager' => 'Manager',
            'hod' => 'Head of Department',
            'warehouse' => 'Warehouse Staff',
            'master_admin' => 'System Administrator',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'master_admin';
    }

    /**
     * Check if user is HOD
     */
    public function isHOD(): bool
    {
        return $this->role === 'hod';
    }

    /**
     * Check if user is Manager
     */
    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    /**
     * Check if user is Propagandist
     */
    public function isPropagandist(): bool
    {
        return $this->role === 'propagandist';
    }

    /**
     * Check if user is Warehouse staff
     */
    public function isWarehouse(): bool
    {
        return $this->role === 'warehouse';
    }
}