<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;

use App\Models\Main;
use App\Models\Message;
use App\Models\UserVacancy;
use App\Models\Vacancy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
        Carbon::setLocale('ky');

        view()->composer('*', function ($view) {
            $view->with('current_first', Request::capture()->segment(1));
            $view->with('current_path', substr(Request::capture()->path(), 3));

            $view->with('locale', app()->getLocale());

            $view->with('main', Main::first());
            if (auth()->user() && auth()->user()->type == 'COMPANY') {
                $view->with('unread_messages', Message::where('user_id', '<>', auth()->user()->id)->where('read', false)->count());
                $vacancy_ids = Vacancy::where('company_id',  auth()->user()->id)->pluck('id')->toArray();
                $view->with('user_vacancy_feedbacks', UserVacancy::whereIn('vacancy_id', $vacancy_ids)->where('type', 'SUBMITTED')->where('status', 'not_processed')->count());
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('admin.components.subheader', 'subheader');
        Blade::component('admin.components.content', 'content');
    }
}
