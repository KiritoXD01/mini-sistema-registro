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
    'register' => false,
    'reset' => false
]);

Route::get('/', function () {
    return view('welcome');
});

//teacher Login URLs
Route::get('/login/teacher', 'Auth\LoginController@showTeacherLoginForm')->name('teacher.showLoginForm');
Route::post('/login/teacher', 'Auth\LoginController@teacherLogin')->name('teacher.login');

//student Login URLs
Route::get('/login/student', 'Auth\LoginController@showStudentLoginForm')->name('student.showLoginForm');
Route::post('/login/student', 'Auth\LoginController@studentLogin')->name('student.login');

Route::get('/home', 'HomeController@index')->name('home');

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
    //POST: Create a new teacher
    Route::post('/', 'TeacherController@store')->middleware('auth')->name('teacher.store');
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
    //POST: Create a new student
    Route::post('/', 'StudentController@store')->middleware('auth')->name('student.store');
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
    //POST: Create a new course
    Route::post('/', 'CourseController@store')->middleware('auth')->name('course.store');
    //POST: Add a student to a course
    Route::post('/{course}/addstudent', 'CourseController@addStudent')->middleware('auth')->name('course.addStudent');
    //POST: Get the student's certification
    Route::post('/certification', 'CourseController@getCertification')->middleware('auth:student,web')->name('course.getCertification');
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
    //POST: Create a new study subject
    Route::post('/', 'StudySubjectController@store')->middleware('auth')->name('studySubject.store');
    //PATCH: Update an existing study subject
    Route::patch('/{studySubject}', 'StudySubjectController@update')->middleware('auth')->name('studySubject.update');
    //DELETE: Deletes a study subject
    Route::delete('/{studySubject}', 'StudySubjectController@destroy')->middleware('auth')->name('studySubject.destroy');
});
