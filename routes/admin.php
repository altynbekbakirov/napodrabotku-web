<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::middleware('auth')->group( function () {

    Route::name('logout')->get('/logout', 'Auth\LoginController@logout');

    Route::name('admin.index')->get('/', ['uses' => 'HomeController@index']);
    Route::name('nav_toggle')->post('/nav_toggle', 'HomeController@nav_toggle');

    Route::name('admin.profile')->get('/profile', ['uses' => 'HomeController@profile']);
    Route::name('admin.chat')->get('/chat', ['uses' => 'HomeController@chat']);
    Route::name('admin.chat.delete')->get('/chat/{chat}/delete', ['uses' => 'HomeController@chat']);
    Route::name('admin.chat.message')->post('/chat/{chat}/message', ['uses' => 'HomeController@message']);

    // Resources
    Route::resources([
        'users' => 'UserController',
        'vacancy_types' => 'VacancyTypeController',
        'busynesses' => 'BusynessController',
        'permissions' => 'PermissionController',
        'roles' => 'RoleController',
        'schedules' => 'ScheduleController',
        'job_types' => 'JobTypeController',
        'countries' => 'CountryController',
        'regions' => 'RegionController',
        'regions.districts' => 'DistrictController',
        'regions.districts.villages' => 'VillageController',
        'vacancies' => 'VacancyController',
        'education_types' => 'EducationTypeController',
        'skillsets' => 'SkillsetController',
        'skillset_categories' => 'SkillsetCategoryController',
        'user_cv' => 'UserCvController',
        'chats' => 'ChatController',
        'currencies' => 'CurrencyController',
    ]);

    // EXPORT
    Route::post('vacancies/export', 'VacancyController@index');

    // CUSTOM ROUTES
    Route::name('user_cv.show')->get('user_cv/{user_vacancy}', ['uses' => 'UserCvController@show']);
    Route::name('user_cv.update_status')->get('user_cv/{id}/{value}', ['uses' => 'UserCvController@update_status']);

    // DELETE ROUTES
    Route::name('users.delete')->get('users/delete/{user}', ['uses' => 'UserController@destroy']);
    Route::name('vacancy_types.delete')->get('vacancy_types/delete/{vacancy_type}', ['uses' => 'VacancyTypeController@destroy']);
    Route::name('busynesses.delete')->get('busynesses/delete/{busyness}', ['uses' => 'BusynessController@destroy']);
    Route::name('schedules.delete')->get('schedules/delete/{busyness}', ['uses' => 'ScheduleController@destroy']);
    Route::name('countries.delete')->get('countries/delete/{country}', ['uses' => 'CountryController@destroy']);
    Route::name('regions.delete')->get('regions/delete/{region}', ['uses' => 'RegionController@destroy']);
    Route::name('regions.districts.delete')->get('regions/{region}/districts/delete/{district}', ['uses' => 'DistrictController@destroy']);
    Route::name('regions.districts.villages.delete')->get('regions/{region}/districts/{district}/villages/delete/{village}', ['uses' => 'VillageController@destroy']);
    Route::name('job_types.delete')->get('job_types/delete/{job_type}', ['uses' => 'JobTypeController@destroy']);
    Route::name('education_types.delete')->get('education_types/delete/{education_type}', ['uses' => 'EducationTypeController@destroy']);
    Route::name('skillsets.delete')->get('skillsets/delete/{skillset}', ['uses' => 'SkillsetController@destroy']);
    Route::name('skillset_categories.delete')->get('skillset_categories/delete/{skillset_category}', ['uses' => 'SkillsetCategoryController@destroy']);

    Route::name('vacancies.delete')->get('vacancies/delete/{vacancy}', ['uses' => 'VacancyController@destroy']);
    Route::name('user_cv.delete')->get('user_cv/delete/{user_cv}', ['uses' => 'UserCvController@destroy']);
    Route::name('chats.delete')->get('chats/delete/{chat}', ['uses' => 'ChatController@destroy']);
    Route::name('currencies.delete')->get('currencies/delete/{currency}', ['uses' => 'CurrencyController@destroy']);

    // Ajax
    Route::name('districts.region')->post('region/districts', ['uses' => 'VacancyController@districts']);
    Route::name('dadata.user')->post('dadata/user', ['uses' => 'AjaxController@dadataUser']);


    // Api Datatable
    Route::prefix('api')->group( function () {
        Route::name('users.api')->get('users_api', ['uses' => 'UserController@api']);
        Route::name('admin.menus')->get('menus','HomeController@menu');
        Route::name('vacancy_types.api')->get('vacancy_types', ['uses' => 'VacancyTypeController@api']);
        Route::name('busynesses.api')->get('busynesses', ['uses' => 'BusynessController@api']);
        Route::name('permissions.api')->get('permissions', ['uses' => 'PermissionController@api']);
        Route::name('roles.api')->get('roles', ['uses' => 'RoleController@api']);
        Route::name('countries.api')->get('countries', ['uses' => 'CountryController@api']);
        Route::name('regions.api')->get('regions', ['uses' => 'RegionController@api']);
        Route::name('regions.districts.api')->get('regions/{region}/districts', ['uses' => 'DistrictController@api']);
        Route::name('regions.districts.villages.api')->get('regions/{region}/districts/{district}/villages', ['uses' => 'VillageController@api']);
        Route::name('schedules.api')->get('schedules', ['uses' => 'ScheduleController@api']);
        Route::name('job_types.api')->get('job_types', ['uses' => 'JobTypeController@api']);
        Route::name('education_types.api')->get('education_types', ['uses' => 'EducationTypeController@api']);
        Route::name('skillsets.api')->get('skillsets', ['uses' => 'SkillsetController@api']);
        Route::name('skillset_categories.api')->get('skillset_categories', ['uses' => 'SkillsetCategoryController@api']);

        Route::name('vacancies.api')->get('vacancies', ['uses' => 'VacancyController@api']);
        Route::name('user_cv.api')->get('user_cv', ['uses' => 'UserCvController@api']);
        Route::name('chats.api')->get('chats', ['uses' => 'ChatController@api']);
        Route::name('currencies.api')->get('currencies', ['uses' => 'CurrencyController@api']);
        Route::name('roll')->get('roll', ['uses' => 'PermissionController@Permission']);
    });
});
