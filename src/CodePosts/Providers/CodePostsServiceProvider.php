<?php

namespace CodePress\CodePosts\Providers;


use Cviebrock\EloquentSluggable\ServiceProvider;

class CodePostsServiceProvider extends ServiceProvider
{
    /**
     *
     *  //dizer que isso é uma migração e que é pra copiar pra pasta de migração do laravel no artisan:publish
     */
    public function boot()
    {
        $this->publishes(
            [__DIR__ . '/../../resources/migrations' => base_path('database/migrations')],
            'migrations'
        );
        $this->loadViewsFrom(__DIR__ . '/../../resources/views/codeposts', 'codeposts');
        require __DIR__ . '/../routes.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

}