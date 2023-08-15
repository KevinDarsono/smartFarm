<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Compilers\BladeCompiler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('role', function ($value) {
            $roles = explode("|", $value);
            return in_array(Auth::user()->role, $roles);
        });

        $this->app->extend('blade.compiler', function (BladeCompiler $bladeCompiler) {
            $bladeCompiler->directive('breadcrumbs', function ($expression) {
                return "<?php \$__env->startSection('breadcrumbs'); ?>\n"
                    . "<?php echo \$__env->make('includes.breadcrumbs', \Illuminate\Support\Arr::except(array_merge(get_defined_vars(), ['breadcrumbs' => {$expression}]), ['__data', '__path']))->render(); ?>\n"
                    . "<?php \$__env->stopSection(); ?>\n";
            });

            return $bladeCompiler;
        });
    }
}
