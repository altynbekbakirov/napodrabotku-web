<?php

Route::group([
    'middleware' => ['api']], function () {
    Route::get('users', ['uses' => 'UserController@index']);
    Route::post('/login', ['uses' => 'AuthController@login']);
    Route::post('/login_phone', ['uses' => 'AuthController@login_phone']);
    Route::post('/logged', ['uses' => 'AuthController@logged']);
    Route::post('/userexist', ['uses' => 'AuthController@checkusername']);
    Route::post('/phoneexist', ['uses' => 'AuthController@checkphone']);
    Route::post('/create', ['uses' => 'UserController@create']);
    Route::put('/change-password/{id}', ['uses' => 'ResetPasswordController@change_pass']);
    Route::post('/resetpassword', ['uses' => 'ResetPasswordController@resetpassword']);
    Route::post('/set_pin_kod/{id}', ['uses' => 'ResetPasswordController@set_pin_kod']);
    Route::get('busyness', ['uses' => 'BusynessController@index']);
    Route::get('countries', ['uses' => 'CountryController@index']);
    Route::get('schedule', ['uses' => 'ScheduleController@index']);
    Route::get('region', ['uses' => 'RegionController@index']);
    Route::get('districts', ['uses' => 'RegionController@districts']);
    Route::get('currencies', ['uses' => 'CurrencyController@index']);
    Route::get('districts_by_region_id', ['uses' => 'RegionController@districtsByRegionId']);
    Route::get('job_type', ['uses' => 'JobTypeController@index']);
    Route::get('education_type', ['uses' => 'EducationTypeController@index']);
    Route::get('skillset', ['uses' => 'SkillsetController@index']);
    Route::get('skillset_category', ['uses' => 'SkillsetCategoryController@index']);
    Route::get('vacancy_type', ['uses' => 'VacancyTypeController@index']);
    Route::post('vacancy', ['uses' => 'VacancyController@index']);
    Route::post('user_vacancy', ['uses' => 'VacancyController@likeOrSubmit']);
    Route::get('user_vacancy/{type}', ['uses' => 'VacancyController@getVacanciesByType']);
    Route::get('num_of/{type}', ['uses' => 'VacancyController@getNumberOfLikedVacancies']);
    Route::get('company_vacancy', ['uses' => 'VacancyController@getVacanciesByCompany']);
    Route::get('company_inactive_vacancy', ['uses' => 'VacancyController@getInactiveVacanciesByCompany']);
    Route::get('num_of_active_vacancies', ['uses' => 'VacancyController@getActiveVacanciesNumber']);
    Route::get('num_of_inactive_vacancies', ['uses' => 'VacancyController@getInactiveVacanciesNumber']);
    Route::post('company/vacancy_delete', ['uses' => 'VacancyController@deleteCompanyVacancy']);
    Route::post('company/activate_deactivate', ['uses' => 'VacancyController@activateDeactivateCompanyVacancy']);
    Route::post('vacancy/save', ['uses' => 'VacancyController@storeCompanyVacancy']);
    Route::get('/users/avatar/{user_id}', ['uses' => 'UserController@avatar']);
    Route::get('user', ['uses' => 'UserController@show']);
    Route::post('users/update/{user_id}', ['uses' => 'UserController@update1']);
    Route::post('users/email_check', ['uses' => 'UserController@checkUserEmail']);
    Route::post('users/user_cv_check', ['uses' => 'UserController@checkUserCv']);
    Route::post('users/send_mail', ['uses' => 'ForgotPasswordController@sendMailToEmail']);
    Route::post('users/validate_code', ['uses' => 'ForgotPasswordController@validateCode']);
    Route::post('users/reset_password', ['uses' => 'ForgotPasswordController@resetPassword']);
    Route::post('users/reset_settings', ['uses' => 'UserController@resetSettings']);
    Route::post('users/company_image', ['uses' => 'UserController@avatar']);
    Route::post('company/submitted_users/{company_id}', ['uses' => 'UserController@getCompanySubmittedUserCvs']);
    Route::post('users/full_info/{user_id}', ['uses' => 'UserController@getUserFullInfo']);
    Route::post('users/filters/{user_id}', ['uses' => 'UserController@saveFilters']);
    Route::get('users/filters/{user_id}/{filter}', ['uses' => 'UserController@getFilters']);
    Route::post('user_skillset', ['uses' => 'UserController@saveUserSkills']);
    Route::get('user/skills', ['uses' => 'UserController@getUserSkills']);
    Route::post('vacancy_skillset', ['uses' => 'VacancyController@saveVacancySkills']);
    Route::get('vacancy_skillset', ['uses' => 'VacancyController@getVacancySkills']);
    Route::post('check_for_new_messages', ['uses' => 'VacancyController@checkingForNewMessages']);
    Route::get('deleteAccount/{user_id}', ['uses' => 'UserController@deleteAccount']);
    Route::post('set_recruit', ['uses' => 'UserController@setUserVacancyRecruit']);
    Route::get('get_recruit/{vacancy_id}', ['uses' => 'UserController@getUserVacancyRecruit']);
    Route::put('deactivateVacancyWithOveredDeadline', ['uses' => 'VacancyController@deactivateVacancyWithOveredDeadline']);

    Route::resources([
        'users' => 'UserController',
        'user_cv' => 'UserCvController',
        'user_cv_experience' => 'UserCvExperienceController',
        'user_cv_education' => 'UserCvEducationController',
        'user_cv_course' => 'UserCvCourseController',
    ]);

    Route::post('user/save/job_sphere', ['uses' => 'UserController@saveJobSphere']);
    Route::post('user/save/opportunity', ['uses' => 'UserController@saveOpportunity']);

    Route::post('user/experience/update/{user_cv_experience}', ['uses' => 'UserCvExperienceController@update']);
    Route::post('user/experience/delete/{user_cv_experience}', ['uses' => 'UserCvExperienceController@delete']);

    Route::post('user/education/update/{user_cv_education}', ['uses' => 'UserCvEducationController@update']);
    Route::post('user/education/delete/{user_cv_education}', ['uses' => 'UserCvEducationController@delete']);

    Route::post('user/course/update/{user_cv_course}', ['uses' => 'UserCvCourseController@update']);
    Route::post('user/course/delete/{user_cv_course}', ['uses' => 'UserCvCourseController@delete']);

    Route::get('chats', ['uses' => 'ChatController@index']);
    Route::post('chats/delete', ['uses' => 'ChatController@destroyChat']);

    Route::get('messages/{receiver_id}/{vacancy_id}', ['uses' => 'ChatController@messages']);
    Route::post('messages', ['uses' => 'ChatController@saveMessage']);

    /// Product Lab
    Route::get('department', ['uses' => 'ReferenceController@departments']);
    Route::get('social_orientation', ['uses' => 'ReferenceController@social_orientations']);
    Route::get('opportunity', ['uses' => 'ReferenceController@opportunities']);
    Route::get('intership_language', ['uses' => 'ReferenceController@intership_languages']);
    Route::get('opportunity_type', ['uses' => 'ReferenceController@opportunity_types']);
    Route::get('opportunity_duration', ['uses' => 'ReferenceController@opportunity_durations']);
    Route::get('recommendation_letter_type', ['uses' => 'ReferenceController@recommendation_letter_types']);
    Route::get('job_sphere', ['uses' => 'ReferenceController@job_spheres']);
});
