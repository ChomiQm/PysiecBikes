<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Document;
use App\Policies\DocumentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        Document::class => DocumentPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
