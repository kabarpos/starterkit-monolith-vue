<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class PermissionService
{
    /**
     * Generate permissions based on routes
     */
    public function generatePermissions(): array
    {
        $routes = Route::getRoutes();
        $permissions = [];
        
        foreach ($routes as $route) {
            // Skip routes yang tidak perlu permission
            if ($this->shouldSkipRoute($route)) {
                continue;
            }
            
            $permissions = array_merge(
                $permissions,
                $this->generatePermissionsForRoute($route)
            );
        }
        
        // Create permissions if not exists
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        
        return $permissions;
    }
    
    /**
     * Generate permissions for a single route
     */
    protected function generatePermissionsForRoute($route): array
    {
        $permissions = [];
        $routeName = $route->getName();
        
        if (!$routeName) {
            return [];
        }
        
        // Remove common prefixes like 'admin.'
        $baseRouteName = Str::after($routeName, 'admin.');
        
        // Split route name into segments
        $segments = explode('.', $baseRouteName);
        
        // Get the resource name (usually the first segment)
        $resource = $segments[0];
        
        // Get the action (usually the last segment)
        $action = end($segments);
        
        // Map route actions to permission verbs
        $permissionMap = [
            'index' => 'view',
            'show' => 'view',
            'create' => 'create',
            'store' => 'create',
            'edit' => 'edit',
            'update' => 'edit',
            'destroy' => 'delete'
        ];
        
        if (isset($permissionMap[$action])) {
            $permissions[] = $permissionMap[$action] . ucfirst($resource);
        } else {
            // For custom actions
            $permissions[] = $action . ucfirst($resource);
        }
        
        return $permissions;
    }
    
    /**
     * Check if route should be skipped for permission generation
     */
    protected function shouldSkipRoute($route): bool
    {
        $skipPrefixes = ['_', 'sanctum', 'ignition', 'horizon'];
        $skipNames = ['login', 'logout', 'register', 'password'];
        
        // Skip routes without names
        if (!$route->getName()) {
            return true;
        }
        
        // Skip routes with certain prefixes
        foreach ($skipPrefixes as $prefix) {
            if (Str::startsWith($route->getName(), $prefix)) {
                return true;
            }
        }
        
        // Skip authentication routes
        foreach ($skipNames as $name) {
            if (Str::contains($route->getName(), $name)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Get module permissions structure for UI
     */
    public function getModulePermissions(): array
    {
        $permissions = Permission::all();
        $modules = [];
        
        foreach ($permissions as $permission) {
            // Extract module name using regex
            preg_match('/^(view|create|edit|delete|manage)(.+)$/', $permission->name, $matches);
            
            if (count($matches) >= 3) {
                $action = $matches[1];
                $module = Str::snake($matches[2]);
                
                if (!isset($modules[$module])) {
                    $modules[$module] = [
                        'name' => Str::title(str_replace('_', ' ', $module)),
                        'permissions' => []
                    ];
                }
                
                $modules[$module]['permissions'][] = [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'action' => $action
                ];
            }
        }
        
        return $modules;
    }
} 