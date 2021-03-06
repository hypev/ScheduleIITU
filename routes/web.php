<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SelectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDegreesController;
use App\Http\Controllers\AdminDepartmentsController;
use App\Http\Controllers\AdminGroupsController;
use App\Http\Controllers\AdminSpecialitiesController;
use App\Http\Controllers\AdminUsersController;


Route::get('/', [HomeController::class, 'home'])->name('index');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/oidc', [AuthController::class, 'openID'])->name('openID');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::prefix('timetable')->group(function () {
   Route::name('timetable.')->group(function () {
      Route::get('group/{id}', [ScheduleController::class, 'group'])->name('group');
      Route::get('teacher/{id}', [ScheduleController::class, 'teacher'])->name('teacher');
      Route::get('room/{id}', [ScheduleController::class, 'room'])->name('room');
   });
});
Route::middleware(['auth.only'])->group(function () {
   Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
   Route::middleware(['not.user'])->group(function () {
      Route::get('/select', [SelectController::class, 'select'])->name('select');
      Route::get('/schedule', [ScheduleController::class, 'schedule'])->name('schedule');
      Route::prefix('profile')->group(function () {
         Route::name('profile.')->group(function () {

            Route::get('', [ProfileController::class, 'profile'])->name('index');
            Route::get('groupmates', [ProfileController::class, 'groupmates'])->name('groupmates');
            Route::get('exams', [ProfileController::class, 'exams'])->name('exams');
            Route::get('teachers', [ProfileController::class, 'teachers'])->name('teachers');
            Route::get('subjects', [ProfileController::class, 'subjects'])->name('subjects');
            Route::get('free', [ProfileController::class, 'free'])->name('free');

            Route::get('departmentmates', [ProfileController::class, 'departmentmates'])->name('departmentmates');

            Route::prefix('group')->group(function () {
               Route::name('group.')->group(function () {
                  Route::post('add', [ProfileController::class, 'groupAdd'])->name('add');
                  Route::post('delete', [ProfileController::class, 'groupDelete'])->name('delete');
               });
            });

            Route::prefix('subject')->group(function () {
               Route::name('subject.')->group(function () {
                  Route::post('block', [ProfileController::class, 'subjectBlock'])->name('block');
                  Route::post('show', [ProfileController::class, 'subjectShow'])->name('show');
               });
            });
         });
      });
   });
   Route::middleware(['admin.only'])->group(function () {
      Route::prefix('admin')->group(function () {
         Route::name('admin.')->group(function () {
            Route::get('login', [AdminController::class, 'login'])->name('login');
            Route::post('auth', [AdminController::class, 'auth'])->name('auth');

            Route::middleware(['admin.logged'])->group(function () {
               // * [ READY ]
               Route::get('', [AdminController::class, 'dashboard'])->name('dashboard');
               Route::get('settings', [AdminController::class, 'settings'])->name('settings');
               Route::post('change_password', [AdminController::class, 'changePassword'])->name('changePassword');

               // ! [ MAKING ]
               Route::get('users', [AdminController::class, 'users'])->name('users');
               Route::get('groups', [AdminController::class, 'groups'])->name('groups');
               Route::get('specialities', [AdminController::class, 'specialities'])->name('specialities');
               Route::get('departments', [AdminController::class, 'departments'])->name('departments');
               Route::get('degrees', [AdminController::class, 'degrees'])->name('degrees');
               Route::get('timetables', [AdminController::class, 'timetables'])->name('timetables');
               Route::get('exams', [AdminController::class, 'exams'])->name('exams');


               Route::prefix('api')->group(function () {
                  Route::name('api.')->group(function () {
                     Route::get('users', [AdminUsersController::class, 'users'])->name('users');
                     Route::post('add-user', [AdminUsersController::class, 'addUser'])->name('add-user');
                     Route::post('edit-user', [AdminUsersController::class, 'editUser'])->name('edit-user');
                     Route::post('delete-user', [AdminUsersController::class, 'deleteUser'])->name('delete-user');
                     Route::get('students', [AdminUsersController::class, 'students'])->name('students');
                     Route::get('teachers', [AdminUsersController::class, 'teachers'])->name('teachers');
                     Route::get('deans', [AdminUsersController::class, 'deans'])->name('deans');

                     Route::get('groups', [AdminGroupsController::class, 'groups'])->name('groups');
                     Route::get('specialities', [AdminSpecialitiesController::class, 'specialities'])->name('specialities');

                     Route::get('departments', [AdminDepartmentsController::class, 'departments'])->name('departments');
                     Route::get('degrees', [AdminDegreesController::class, 'degrees'])->name('degrees');
                  });
               });
            });
         });
      });
   });
});
