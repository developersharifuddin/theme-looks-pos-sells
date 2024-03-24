<?php

namespace App\Console\Commands;

use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log; // Import Log facade

class InsertRoutePermissions extends Command
{
    protected $signature = 'permissions:insert-route-permissions';
    protected $description = 'Insert route permissions into the permissions table';

    public function handle()
    {
        $routes = collect(Route::getRoutes())->map(function ($route) {

            Log::info('group_name:' . $this->getRouteGroupName($route));
            return [
                'name' => $route->getName(),
                'guard_name' => 'sanctum',
                'group_name' => $this->getRouteGroupName($route),
            ];
        })->filter()->unique();

        foreach ($routes as $route) {
            // Ensure group_name is not null
            if ($route['group_name'] !== null) {
                try {
                    Permission::firstOrCreate($route);
                } catch (\Exception $e) {
                    // Log any exceptions that occur during insertion
                    Log::error('Error inserting route permission: ' . $e->getMessage());
                }
            }
        }

        $this->info('Route permissions inserted successfully.');
        Log::info('Route permissions inserted successfully.');
    }

    protected function getRouteGroupName($route)
    {
        $uri = $route->uri();

        // Extract the segment after the first slash
        $segments = explode('/', $uri);

        // Check if there's at least one segment after the first slash
        if (count($segments) > 1) {
            // Return the group name which is the second segment
            return $segments[1];
        }

        return null; // Return null if group name not found
    }
}
