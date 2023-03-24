<?php

namespace App\Providers;

use AbdAdmin\RequestersAbstraction\Contracts\Requester;
use AbdAdmin\RequestersAbstraction\Laravel\LaravelRequester;
use AbdAdmin\RespondersAbstraction\Contracts\ViewResponder;
use AbdAdmin\RespondersAbstraction\Contracts\RedirectResponder;
use AbdAdmin\RespondersAbstraction\Contracts\SmartResponder;
use AbdAdmin\RespondersAbstraction\Laravel\BladeViewResponder;
use AbdAdmin\RespondersAbstraction\Laravel\LaravelRedirectResponder;
use AbdAdmin\RespondersAbstraction\Laravel\LaravelSmartResponder;
use AbdAdmin\SessionAbstraction\Contracts\Session;
use AbdAdmin\SessionAbstraction\Laravel\LaravelSession;
use AbdAdmin\ViewAbstraction\Laravel\LayoutViewComposer;
use Domain\Auth\Configs\AuthConfiguration;
use Domain\Auth\Configs\FlowTypeEnum;
use Domain\Auth\Configs\IdentityEnum;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthConfiguration::class, function ($app) {
            return new AuthConfiguration(
                FlowTypeEnum::from($app['config']->get('abdadmin.authentication.flow_type')),
                IdentityEnum::from($app['config']->get('abdadmin.authentication.identity')),
                config('abdadmin.authentication.verification'),
            );
        });

        $this->app->bind(Session::class, LaravelSession::class);
        $this->app->bind(SmartResponder::class, LaravelSmartResponder::class);
        $this->app->bind(ViewResponder::class, BladeViewResponder::class);
        $this->app->bind(RedirectResponder::class, LaravelRedirectResponder::class);
        $this->app->bind(Requester::class, LaravelRequester::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['_layout/guest', '_layout/main'], LayoutViewComposer::class);
    }
}
