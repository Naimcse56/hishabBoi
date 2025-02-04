<?php

namespace Modules\Accounts\App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\App\Models\DayCloseFiscalYear;
use Modules\Accounts\App\Models\FiscalYear;
use Modules\Accounts\App\Repository\Eloquents\LedgerRepository;
use Modules\Accounts\App\Repository\Interfaces\LedgerRepositoryInterface;
use Modules\Accounts\App\Repository\Eloquents\SubLedgerRepository;
use Modules\Accounts\App\Repository\Interfaces\SubLedgerRepositoryInterface;
use Modules\Accounts\App\Repository\Eloquents\WorkOrderRepository;
use Modules\Accounts\App\Repository\Interfaces\WorkOrderRepositoryInterface;
use Modules\Accounts\App\Repository\Eloquents\JournalRepository;
use Modules\Accounts\App\Repository\Interfaces\JournalRepositoryInterface;

class AccountsServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Accounts';

    protected string $moduleNameLower = 'accounts';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/migrations'));
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
        if (env('DB_DATABASE') != "") {
            $this->app->singleton('current_fiscal_year', function () {
                if (auth()->check()) {
                    return FiscalYear::where('is_closed',0)->orderBy('id','desc')->first(['id','from_date','to_date','year']);
                } else {
                    return null;
                }
            });
            $this->app->singleton('prev_fiscal_year', function () {
                if (auth()->check()) {
                    return FiscalYear::where('is_closed',1)->orderBy('id','desc')->first(['id','from_date','to_date','year']);
                } else {
                    return null;
                }
            });
            if (Schema::hasTable('day_close_fiscal_years')) {
                $this->app->singleton('day_closing_info', function () {
                    if (auth()->check()) {
                        return DayCloseFiscalYear::where('is_closed',0)->orderByDesc('id')->first();
                    } else {
                        return null;
                    };
                });
            }
            if (Schema::hasTable('account_configurations')) {
                $this->app->singleton('account_configurations', function () {
                    $settings = DB::table('account_configurations')->get();
                    foreach ($settings as $setting) {
                        $datas[$setting->name] = $setting->value;
                    }
                    return $datas;
                });
            }
            $this->app->bind(LedgerRepositoryInterface::class, LedgerRepository::class);
            $this->app->bind(SubLedgerRepositoryInterface::class, SubLedgerRepository::class);
            $this->app->bind(WorkOrderRepositoryInterface::class, WorkOrderRepository::class);
            $this->app->bind(JournalRepositoryInterface::class, JournalRepository::class);
        }
    }

    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void
    {
        // $this->commands([]);
    }

    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void
    {
        // $this->app->booted(function () {
        //     $schedule = $this->app->make(Schedule::class);
        //     $schedule->command('inspire')->hourly();
        // });
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/'.$this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'Resources/lang'));
        }
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $this->publishes([module_path($this->moduleName, 'config/config.php') => config_path($this->moduleNameLower.'.php')], 'config');
        $this->mergeConfigFrom(module_path($this->moduleName, 'config/config.php'), $this->moduleNameLower);
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/'.$this->moduleNameLower);
        $sourcePath = module_path($this->moduleName, 'resources/views');

        $this->publishes([$sourcePath => $viewPath], ['views', $this->moduleNameLower.'-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);

        $componentNamespace = str_replace('/', '\\', config('modules.namespace').'\\'.$this->moduleName.'\\'.config('modules.paths.generator.component-class.path'));
        Blade::componentNamespace($componentNamespace, $this->moduleNameLower);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir($path.'/modules/'.$this->moduleNameLower)) {
                $paths[] = $path.'/modules/'.$this->moduleNameLower;
            }
        }

        return $paths;
    }
}
