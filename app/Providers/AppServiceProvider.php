<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use PowerComponents\LivewirePowerGrid\Button;

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
        $this->configureDefaults();

        Schema::defaultstringLength(191);

        Button::macro('form', function (string $route, $method= 'post', array $params=[], string $target = '_self', $buttonClass = '', string $token='') {
            $this->tag('form');

            $this->attributes([
                'action' => route($route, $params),
                'target' => $target,
                'method' => 'post',
            ]);

            $this->slot = Blade::render('
                @method("' . $method . '")
                @csrf
                <button class="'.$buttonClass.'"  type="submit">' . $this->slot . '</button>
            </form>');

            return $this;
        });

        Collection::macro('recursive', function () {
            return $this->map(function ($value) {
                if (is_array($value) || is_object($value)) {
                    return collect($value)->recursive();
                }

                return $value;
            });
        });

        // Common Variables
        // values assigned from controllers.
        view()->share('appTitle', '');
        view()->share('activeApp', '');
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null
        );
    }
}
