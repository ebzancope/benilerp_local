<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Forçar HTTPS só em produção (evita problemas em dev/local)
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        // Se estiver em subpasta (ajuste o caminho conforme seu deploy)
        // $this->app['request']->server->set('SCRIPT_NAME', '/sistema/public/index.php');

        // Paginação com Bootstrap
        Paginator::useBootstrap();
        Paginator::defaultView('vendor.pagination.bootstrap-4');
        Paginator::defaultSimpleView('vendor.pagination.bootstrap-4');

        // Registrar observer
        \App\Models\Cobranca::observe(\App\Observers\CobrancaObserver::class);
    }
}
