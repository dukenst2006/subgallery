<?php

namespace App\Http\ViewComposers;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class HomeComposer
{
    /**
     * The user repository implementation.
     *
     * @var
     */
    protected $roles;

    /**
     * Create a new profile composer.
     *
     * @param Role $roles
     */
    public function __construct(Role $roles)
    {
        // Dependencies automatically resolved by service container...
        $this->roles = $roles;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $data = Cache::remember('roles', 1440, function () {
            return $this->roles->where('guard_name', 'admin')->get();
        });

        $view->with('roles', $data);
    }
}