<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes([
    'register' => false
]);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/changeLanguage/{language}', 'HomeController@changeLanguage')->name('changeLanguage');
Route::post('/logout', 'Auth\LoginController@logout')->middleware('auth:teacher,web,student')->name('logout');
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'login'], function (){
    //Admin Login URLs
    Route::get('/', 'Auth\LoginController@showAdminLoginForm')->name('loginForm');
    Route::post('/', 'Auth\LoginController@adminLogin')->name('login');

    //teacher Login URLs
    Route::get('/teacher', 'Auth\LoginController@showTeacherLoginForm')->name('teacher.showLoginForm');
    Route::post('/teacher', 'Auth\LoginController@teacherLogin')->name('teacher.login');

    //student Login URLs
    Route::get('/student', 'Auth\LoginController@showStudentLoginForm')->name('student.showLoginForm');
    Route::post('/student', 'Auth\LoginController@studentLogin')->name('student.login');
});

Route::group(['prefix' => 'user'], function(){
    //GET: Get all users
    Route::get('/', 'UserController@index')->middleware('auth')->name('user.index');
    //GET: Create a new user view
    Route::get('/create', 'UserController@create')->middleware('auth')->name('user.create');
    //GET: Edit an user view
    Route::get('/{user}/edit', 'UserController@edit')->middleware('auth')->name('user.edit');
    //GET: Show an user view
    Route::get('/{user}/show', 'UserController@show')->middleware('auth')->name('user.show');
    //GET: Import users to Excel
    Route::get('/export', 'UserController@export')->middleware('auth')->name('user.export');
    //POST: Create a new user
    Route::post('/', 'UserController@store')->middleware('auth')->name('user.store');
    //POST: Import users from CSV/Excel
    Route::post('/import', 'UserController@import')->middleware('auth')->name('user.import');
    //PATCH: Update an existing user
    Route::patch('/{user}', 'UserController@update')->middleware('auth')->name('user.update');
    //DELETE: Deletes and user
    Route::delete('/{user}', 'UserController@destroy')->middleware('auth')->name('user.destroy');
});

Route::group(['prefix' => 'role'], function(){
    //GET: Get all user roles
    Route::get('/', 'RoleController@index')->middleware('auth')->name('role.index');
    //GET: Create a new role view
    Route::get('/create', 'RoleController@create')->middleware('auth')->name('role.create');
    //GET: Edit an role view
    Route::get('/{role}/edit', 'RoleController@edit')->middleware('auth')->name('role.edit');
    //GET: Show an role view
    Route::get('/{role}/show', 'RoleController@show')->middleware('auth')->name('role.show');
    //POST: Create a new role
    Route::post('/', 'RoleController@store')->middleware('auth')->name('role.store');
    //PATCH: Update an existing role
    Route::patch('/{role}', 'RoleController@update')->middleware('auth')->name('role.update');
    //DELETE: Deletes and role
    Route::delete('/{role}', 'RoleController@destroy')->middleware('auth')->name('role.destroy');
});

Route::group(['prefix' => 'teacher'], function(){
    //GET: Get all teachers
    Route::get('/', 'TeacherController@index')->middleware('auth')->name('teacher.index');
    //GET: Create a new teacher view
    Route::get('/create', 'TeacherController@create')->middleware('auth')->name('teacher.create');
    //GET: Edit an teacher view
    Route::get('/{teacher}/edit', 'TeacherController@edit')->middleware('auth')->name('teacher.edit');
    //GET: Show an teacher view
    Route::get('/{teacher}/show', 'TeacherController@show')->middleware('auth')->name('teacher.show');
    //GET: Show teacher's dashboard
    Route::get('/home', 'TeacherController@home')->middleware('teacher')->name('teacher.home');
    //GET: Export teachers to Excel
    Route::get('/export', 'TeacherController@export')->middleware('auth')->name('teacher.export');
    //GET: show reset form
    Route::get('/password/reset/{token}', 'AuthTeacher\ResetPasswordController@showResetForm')->name('teacher.password.reset');
    //POST: Create a new teacher
    Route::post('/', 'TeacherController@store')->middleware('auth')->name('teacher.store');
    //POST: Import teachers from CSV/Excel
    Route::post('/import', 'TeacherController@import')->middleware('auth')->name('teacher.import');
    //POST: send reset password email
    Route::post('/password/email', 'AuthTeacher\ForgotPasswordController@sendResetLinkEmail')->name('teacher.password.email');
    //POST: reset password for teachers
    Route::post('/password/reset', 'AuthTeacher\ResetPasswordController@reset');
    //PATCH: Update an existing teacher
    Route::patch('/{teacher}', 'TeacherController@update')->middleware('auth')->name('teacher.update');
    //DELETE: Deletes and teacher
    Route::delete('/{teacher}', 'TeacherController@destroy')->middleware('auth')->name('teacher.destroy');
});

Route::group(['prefix' => 'student'], function(){
    //GET: Get all student
    Route::get('/', 'StudentController@index')->middleware('auth')->name('student.index');
    //GET: Create a new student view
    Route::get('/create', 'StudentController@create')->middleware('auth')->name('student.create');
    //GET: Edit an student view
    Route::get('/{student}/edit', 'StudentController@edit')->middleware('auth')->name('student.edit');
    //GET: Edit an student view
    Route::get('/{student}/show', 'StudentController@show')->middleware('auth')->name('student.show');
    //GET: Shows the student dashboard
    Route::get('/home', 'StudentController@home')->middleware('student')->name('student.home');
    //GET: Export students to Excel
    Route::get('/export', 'StudentController@export')->middleware('auth')->name('student.export');
    //GET: show reset form
    Route::get('/password/reset/{token}', 'AuthStudent\ResetPasswordController@showResetForm')->name('student.password.reset');
    //GET: check if email exists
    Route::get('/checkEmail', 'StudentController@checkEmail')->name('student.checkEmail');
    //POST: Create a new student
    Route::post('/', 'StudentController@store')->middleware('auth')->name('student.store');
    //POST: Import teachers from CSV/Excel
    Route::post('/import', 'StudentController@import')->middleware('auth')->name('student.import');
    //POST: send reset password email
    Route::post('/password/email', 'AuthStudent\ForgotPasswordController@sendResetLinkEmail')->name('student.password.email');
    //POST: reset password for teachers
    Route::post('/password/reset', 'AuthStudent\ResetPasswordController@reset');
    //PATCH: Update an existing student
    Route::patch('/{student}', 'StudentController@update')->middleware('auth')->name('student.update');
    //DELETE: Deletes a student
    Route::delete('/{student}', 'StudentController@destroy')->middleware('auth')->name('student.destroy');
});

Route::group(['prefix' => 'course'], function(){
    //GET: Get all courses
    Route::get('/', 'CourseController@index')->middleware('auth:teacher,student,web')->name('course.index');
    //GET: Create a new course view
    Route::get('/create', 'CourseController@create')->middleware('auth')->name('course.create');
    //GET: Edit an course view
    Route::get('/{course}/edit', 'CourseController@edit')->middleware('auth:teacher,web')->name('course.edit');
    //GET: Show an course view
    Route::get('/{course}/show', 'CourseController@show')->middleware('auth:teacher,web')->name('course.show');
    //GET: Verify certification
    Route::get('/checkCertification/{course}/{student}', 'CourseController@checkCertification')->name('course.checkCertification');
    //POST: Create a new course
    Route::post('/', 'CourseController@store')->middleware('auth')->name('course.store');
    //POST: Add a student to a course
    Route::post('/{course}/addstudent', 'CourseController@addStudent')->middleware('auth')->name('course.addStudent');
    //POST: Get the student's certification
    Route::post('/certification/{courseStudent}', 'CourseController@getCertification')->middleware('auth:student,web')->name('course.getCertification');
    //PATCH: Update an existing course
    Route::patch('/{course}', 'CourseController@update')->middleware('auth')->name('course.update');
    //PATCH: Update the student points
    Route::patch('/{course}/updatepoints', 'CourseController@updatePoints')->middleware('auth:teacher,web')->name('course.updatePoints');
    //DELETE: Deletes a course
    Route::delete('/{course}', 'CourseController@destroy')->middleware('auth')->name('course.destroy');
    //DELETE: Remove a student from a course
    Route::delete('/{course}/removestudent', 'CourseController@removeStudent')->middleware('auth')->name('course.removeStudent');
});

Route::group(['prefix' => 'studysubject'], function(){
    //GET: Get all study subjects
    Route::get('/', 'StudySubjectController@index')->middleware('auth')->name('studySubject.index');
    //GET: Create a new study subject view
    Route::get('/create', 'StudySubjectController@create')->middleware('auth')->name('studySubject.create');
    //GET: Edit an study subject view
    Route::get('/{studySubject}/edit', 'StudySubjectController@edit')->middleware('auth')->name('studySubject.edit');
    //GET: Show an study subject view
    Route::get('/{studySubject}/show', 'StudySubjectController@show')->middleware('auth')->name('studySubject.show');
    //GET: Export students to Excel
    Route::get('/export', 'StudySubjectController@export')->middleware('auth')->name('studySubject.export');
    //POST: Create a new study subject
    Route::post('/', 'StudySubjectController@store')->middleware('auth')->name('studySubject.store');
    //POST: Import study subjects from CSV/Excel
    Route::post('/import', 'StudySubjectController@import')->middleware('auth')->name('studySubject.import');
    //PATCH: Update an existing study subject
    Route::patch('/{studySubject}', 'StudySubjectController@update')->middleware('auth')->name('studySubject.update');
    //DELETE: Deletes a study subject
    Route::delete('/{studySubject}', 'StudySubjectController@destroy')->middleware('auth')->name('studySubject.destroy');
});

Route::group(['prefix' => 'institution'], function(){
    //GET: Show the institution info
    Route::get('/show', 'InstitutionController@show')->middleware('auth')->name('institution.show');
    //GET: Edit the institution info
    Route::get('/edit', 'InstitutionController@edit')->middleware('auth')->name('institution.edit');
    //POST: Update institution
    Route::post('/', 'InstitutionController@update')->middleware('auth')->name('institution.update');
});

Route::group(['prefix' => 'courseType'], function (){
    //GET: Get all course types
    Route::get('/', 'CourseTypeController@index')->middleware('auth')->name('courseType.index');
    //GET: Create a new course type view
    Route::get('/create', 'CourseTypeController@create')->middleware('auth')->name('courseType.create');
    //GET: Edit a course type view
    Route::get('/{courseType}/edit', 'CourseTypeController@edit')->middleware('auth')->name('courseType.edit');
    //GET: Show a course type view
    Route::get('/{courseType}/show', 'CourseTypeController@show')->middleware('auth')->name('courseType.show');
    //POST: Create a new course type
    Route::post('/', 'CourseTypeController@store')->middleware('auth')->name('courseType.store');
    //PATCH: Update an existing course type
    Route::patch('/{courseType}', 'CourseTypeController@update')->middleware('auth')->name('courseType.update');
    //DELETE: Deletes and course type
    Route::delete('/{courseType}', 'CourseTypeController@destroy')->middleware('auth')->name('courseType.destroy');
});
