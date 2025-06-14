<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProveedorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\EnsureSuperAdmin;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\SettingController as AdminSetting;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\InfoController;
use App\Http\Controllers\Admin\RoleController;
use Spatie\Permission\Middleware\PermissionMiddleware;

Auth::routes();

/* ----RUTA PARA EL HOME/******* */
Route::get('/', [HomeController::class, 'index'])
     ->name('inicio');

/* ----RUTA DEL DASHBOARD/******* */
// todas las rutas de /admin protegidas por auth + super-admin
Route::prefix('admin')
     ->middleware(['auth']) // ✅ Solo requiere login, luego se filtra con middlewares por ruta
     ->name('admin.')
     ->group(function () {

          // 1) Dashboard → todos los roles autenticados pueden entrar
          Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
          Route::redirect('/', 'admin/dashboard');

          Route::middleware('permission:ver_usuarios')->group(function () {
               Route::get('users', [UserController::class, 'index'])->name('users.index');
               Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
               Route::post('users/{user}/roles', [UserController::class, 'updateRoles'])->name('users.roles');

               // 🔐 Gestión de roles y permisos
               Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
               Route::put('/roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.update-permissions');

               Route::resource('roles', RoleController::class)->except('show');
          });

          // 3) CMS (páginas, slides, infos) → solo content-editor o super-admin
          Route::middleware('role:content-editor|super-admin')->group(function () {
               Route::get('pages', [AdminPageController::class, 'index'])->name('pages.index');
               Route::get('pages/{page}/edit', [AdminPageController::class, 'edit'])->name('pages.edit');
               Route::put('pages/{page}', [AdminPageController::class, 'update'])->name('pages.update');

               Route::resource('slides', SlideController::class)
                    ->parameters(['slides' => 'slide'])
                    ->except(['show']);

               Route::resource('infos', InfoController::class)
                    ->parameters(['infos' => 'info'])
                    ->except(['show']);
          });

          // 4) Ajuste de logo → solo content-editor o super-admin
          Route::prefix('settings')->middleware('role:content-editor|super-admin')->name('settings.')->group(function () {
               Route::get('logo', [AdminSetting::class, 'editLogo'])->name('logo.edit');
               Route::post('logo', [AdminSetting::class, 'updateLogo'])->name('logo.update');
          });
     });

/* ----RUTA DE QUIENES SOMOS/******* */
Route::get('/quienes-somos', [PageController::class, 'quienesSomos'])
     ->name('quienes-somos');


/* ----RUTA EL REGISTRO DE PROVEEDORES/******* */
Route::get('proveedores/registro', [ProveedorController::class, 'create'])
     ->name('proveedores.create');

Route::post('proveedores', [ProveedorController::class, 'store'])
     ->name('proveedores.store');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('inicio');

Route::get('/test-permiso', function () {
    return '¡Tenés permiso!';
})->middleware('permission:ver_usuarios');
