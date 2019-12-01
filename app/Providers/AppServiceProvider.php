<?php
namespace App\Repositories;
namespace App\Providers;

use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);


        Blade::directive('money', function ($amount) {
            return "<?php echo '৳' . number_format($amount, 2); ?>";
        });

        Blade::directive('dollarMoney', function ($amount) {
            return "<?php echo '$' . number_format($amount, 2); ?>";
        });

    }
}
