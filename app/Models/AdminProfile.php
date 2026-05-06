<?php
// App/Models/AdminProfile.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminProfile extends Model
{
    protected $table = 'admin_profiles';
    
    protected $fillable = [
        'user_id',
        'matricule',
        'prenom',
        'service_origine',
        'access_level',
        'permissions',
        'type_identite',
        'numero_identite',
        'additional_info',
    ];
    
    protected $casts = [
        'permissions' => 'array',
        'additional_info' => 'array',
    ];
    
    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Vérifier si le profil a une permission spécifique
     */
    public function hasPermission($permission)
    {
        return in_array($permission, $this->permissions ?? []);
    }
    
    /**
     * Ajouter une permission
     */
    public function addPermission($permission)
    {
        $permissions = $this->permissions ?? [];
        if (!in_array($permission, $permissions)) {
            $permissions[] = $permission;
            $this->permissions = $permissions;
            $this->save();
        }
        return $this;
    }
    
    /**
     * Retirer une permission
     */
    public function removePermission($permission)
    {
        $permissions = $this->permissions ?? [];
        $key = array_search($permission, $permissions);
        if ($key !== false) {
            unset($permissions[$key]);
            $this->permissions = array_values($permissions);
            $this->save();
        }
        return $this;
    }
    
    /**
     * Scope pour les profils par service
     */
    public function scopeByService($query, $service)
    {
        return $query->where('service_origine', $service);
    }
    
    /**
     * Scope pour les profils par niveau d'accès
     */
    public function scopeByAccessLevel($query, $level)
    {
        return $query->where('access_level', $level);
    }
}