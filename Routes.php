<?php
    return [
        App\Core\Route::get('|^user/register/?$|',                  'Main',                   'getRegister'),
        App\Core\Route::post('|^user/register/?$|',                 'Main',                   'postRegister'),
        App\Core\Route::get('|^user/login/?$|',                     'Main',                   'getLogin'),
        App\Core\Route::post('|^user/login/?$|',                    'Main',                   'postLogin'),
        App\Core\Route::get('|^user/logout/?$|',                    'Main',                   'getLogout'),
        App\Core\Route::get('|^about/?$|',                          'Main',                   'getAbout'),

        // # Admin login/out
        App\Core\Route::get('|^admin/login/?$|',                     'Main',                   'getAdminLogin'),
        App\Core\Route::post('|^admin/login/?$|',                    'Main',                   'postAdminLogin'),
        App\Core\Route::get('|^admin/logout/?$|',                    'Main',                   'getAdminLogout'),
        
        // # Admin role routes:
        App\Core\Route::get('|^admin/profile/?$|',            'AdminProfileManagement',                   'getProfile'),
        App\Core\Route::post('|^admin/profile/?$|',            'AdminProfileManagement',                   'postProfile'),
        
        App\Core\Route::get('|^admin/surveys/?$|',            'AdminSurveyManagement',                   'getSurveys'),

        App\Core\Route::get('|^admin/surveys/edit/([0-9]+)/?$|',  'AdminSurveyManagement', 'getEdit'),
        App\Core\Route::post('|^admin/surveys/edit/([0-9]+)/?$|', 'AdminSurveyManagement', 'postEdit'),

        App\Core\Route::get('|^admin/users/?$|',  'AdminUserManagement', 'getUsers'),
        App\Core\Route::get('|^admin/users/edit/([0-9]+)/?$|', 'AdminUserManagement', 'getEdit'),
        App\Core\Route::post('|^admin/users/edit/([0-9]+)/?$|', 'AdminUserManagement', 'postEdit'),

        App\Core\Route::get('|^admin/users/logins/?$|',  'AdminUserManagement', 'getUserLogins'),

        // # Main routes
        App\Core\Route::post('|^search/?$|',                        'Survey',                   'postSearch'),
        App\Core\Route::get('|^surveys/([a-zA-Z0-9+/]+)/?$|',        'Survey',                'getShow'),
        App\Core\Route::post('|^surveys/([a-zA-Z0-9+/]+)/?$|',       'Survey',                'postShow'),

        // # API rute:
        App\Core\Route::get('|^api/bookmarks/?$|',                  'ApiBookmark',            'getBookmarks'),
        App\Core\Route::get('|^api/bookmarks/add/([0-9]+)/?$|',     'ApiBookmark',            'addBookmark'),
        App\Core\Route::get('|^api/bookmarks/clear/?$|',            'ApiBookmark',            'clear'),

        # User role routes:
        App\Core\Route::get('|^user/surveys/?$|',            'UserSurveyManagement',                   'surveys'),
        App\Core\Route::get('|^user/surveys/([0-9]+)/?$|',   'UserSurveyManagement',                   'show'),
        App\Core\Route::post('|^user/surveys/answers/([0-9]+)/?$|',   'UserSurveyManagement',                   'postAnswers'),
        App\Core\Route::get('|^user/surveys/answers/([0-9]+)/?$|',   'UserSurveyManagement',                   'getAnswers'),

        App\Core\Route::get('|^user/surveys/edit/?$|',  'UserSurveyManagement', 'getEdit'),//add
        App\Core\Route::get('|^user/surveys/edit/([0-9]+)/?$|',  'UserSurveyManagement', 'getEdit'),
        App\Core\Route::post('|^user/surveys/edit/?$|', 'UserSurveyManagement', 'postEdit'),
        App\Core\Route::post('|^user/surveys/edit/([0-9]+)/?$|', 'UserSurveyManagement', 'postEdit'),
        App\Core\Route::any('|^.*$|',                               'Main',                   'home')
    ];
