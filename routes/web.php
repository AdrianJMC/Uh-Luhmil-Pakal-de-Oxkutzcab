<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\AgrupacionController;
use App\Http\Controllers\AgrupacionDashboardController;
use App\Http\Controllers\Auth\LoginAgrupacionController;
use App\Http\Controllers\Auth\AgrupacionPasswordController;
use App\Http\Controllers\ProductoController as AgrupacionProductoController;
use App\Http\Controllers\Agrupacion\PedidoController as AgrupacionPedidoController;

// Middleware
use App\Http\Middleware\TieneRolMiddleware;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\InfoController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController as AdminSetting;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\CatalogoController as AdminCatalogoController;
use App\Http\Controllers\Admin\PedidoAdminController;

// -----------------------------
// RUTAS PÚBLICAS
// -----------------------------

// Inicio y Home
Route::get('/', [HomeController::class, 'index'])->name('inicio');
Route::get('/home', [HomeController::class, 'index'])->name('inicio');

// Quiénes somos
Route::get('/quienes-somos', [PageController::class, 'quienesSomos'])->name('quienes-somos');

// Catálogo público
Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo');
Route::get('/catalogos/{catalogo}/agrupaciones', [App\Http\Controllers\Api\CatalogoController::class, 'agrupacionesPorCatalogo']);

// Registro de agrupaciones
Route::get('agrupaciones/registro', [AgrupacionController::class, 'create'])->name('agrupaciones.create');
Route::post('agrupaciones', [AgrupacionController::class, 'store'])->name('agrupaciones.store');

// Agrupaciones públicas
Route::get('/agrupaciones', [App\Http\Controllers\AgrupacionPublicController::class, 'index'])->name('agrupaciones.public.index');

// Página de selección de acceso
Route::get('/seleccion-acceso', function () {
    return view('auth.seleccion-login');
})->name('seleccion.login');

// -----------------------------
// AUTH GENERAL
// -----------------------------

Auth::routes();

// -----------------------------
// LOGIN AGRUPACIONES
// -----------------------------

Route::get('/agrupaciones/login', [LoginAgrupacionController::class, 'showLoginForm'])->name('agrupaciones.login');
Route::post('/agrupaciones/login', [LoginAgrupacionController::class, 'login']);

Route::get('/crear-contraseña', [AgrupacionPasswordController::class, 'showForm'])->name('agrupaciones.password.form');
Route::post('/crear-contraseña', [AgrupacionPasswordController::class, 'store'])->name('agrupaciones.password.store');

Route::post('/logout-agrupacion', function (Request $request) {
    Auth::guard('agrupacion')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('inicio');
})->name('logout.agrupacion');

// -----------------------------
// DASHBOARD AGRUPACIONES
// -----------------------------

Route::prefix('agrupaciones')
    ->middleware(\App\Http\Middleware\RedirectIfNotAgrupacion::class)
    ->name('agrupaciones.')
    ->group(function () {
        Route::get('/dashboard', [AgrupacionDashboardController::class, 'index'])->name('dashboard');

        // Productos (propios)
        Route::resource('productos', AgrupacionProductoController::class)->names('productos');

        // Pedidos
        Route::get('/pedidos', [AgrupacionPedidoController::class, 'index'])->name('pedidos.index');
        Route::get('/pedidos/{pedido}/productos', [AgrupacionPedidoController::class, 'verProductos'])->name('pedidos.ver');
    });

// -----------------------------
// CARRITO Y PEDIDO (USUARIOS AUTENTICADOS)
// -----------------------------

Route::middleware(['auth'])->group(function () {
    Route::get('/carrito', [CartController::class, 'index'])->name('carrito');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/realizar-pedido', [PedidoController::class, 'realizar'])->name('pedido.realizar');
});

// -----------------------------
// PANEL ADMIN (prefijo /admin)
// -----------------------------

Route::prefix('admin')
    ->middleware(['auth', TieneRolMiddleware::class]) // todos autenticados
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::redirect('/', 'admin/dashboard');

        // === GESTIÓN DE USUARIOS ===
        Route::middleware(['auth', 'permission:ver_usuarios'])->group(function () {
            Route::get('users', [UserController::class, 'index'])->name('users.index');
            Route::post('users/{user}/roles', [UserController::class, 'updateRoles'])->middleware('permission:editar_usuarios')->name('users.roles');
            Route::delete('users/{user}', [UserController::class, 'destroy'])->middleware('permission:eliminar_usuarios')->name('users.destroy');


            // Gestión de roles con permisos individuales
            Route::middleware(['permission:gestionar_perfiles'])->group(function () {
                Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
            });
            Route::middleware(['permission:crear_perfiles'])->group(function () {
                Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
                Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
            });
            Route::middleware(['permission:editar_perfiles'])->group(function () {
                Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
                Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
                Route::put('/roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.update-permissions');
            });
            Route::middleware(['permission:eliminar_perfiles'])->group(function () {
                Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
            });
        });

        // === CMS: páginas ===
        Route::middleware('permission:ver_pagina_inicio|editar_pagina_inicio|ver_pagina_quienes|editar_pagina_quienes')->group(function () {
            Route::get('pages', [AdminPageController::class, 'index'])->name('pages.index');
            Route::get('pages/{page}/edit', [AdminPageController::class, 'edit'])->middleware('permission:editar_pagina_inicio|editar_pagina_quienes')->name('pages.edit');
            Route::put('pages/{page}', [AdminPageController::class, 'update'])->middleware('permission:editar_pagina_inicio|editar_pagina_quienes')->name('pages.update');
        });
        // === Infos ===
        Route::middleware('permission:ver_infos|crear_infos|editar_infos|eliminar_infos')->group(function () {
            Route::resource('infos', InfoController::class)->except(['show']);
        });
        // === Slides ===
        Route::middleware('permission:ver_slides|crear_slides|editar_slides|eliminar_slides')->group(function () {
            Route::resource('slides', SlideController::class)->except(['show']);
        });
        // === Ajustes del sistema (logo) ===
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('logo', [AdminSetting::class, 'editLogo'])->middleware('permission:ver_logo')->name('logo.edit');
            Route::post('logo', [AdminSetting::class, 'updateLogo'])->middleware('permission:editar_logo')->name('logo.update');
        });

        // === Agrupaciones ===
        Route::middleware(['auth', 'permission:ver_agrupaciones'])->group(function () {
            Route::get('/gestor-agrupaciones', [AgrupacionController::class, 'index'])->name('agrupaciones.index'); // Ya tiene el permiso por fuera
            Route::post('/agrupaciones/{id}/aprobar', [AgrupacionController::class, 'aprobar'])->middleware('permission:aprobar_agrupacion')->name('agrupaciones.aprobar');
            Route::post('/agrupaciones/{id}/rechazar', [AgrupacionController::class, 'rechazar'])->middleware('permission:rechazar_agrupacion')->name('agrupaciones.rechazar');
            Route::get('/agrupaciones/{agrupacion}/edit', [AgrupacionController::class, 'edit'])->middleware('permission:editar_agrupacion')->name('agrupaciones.edit');
            Route::put('/agrupaciones/{agrupacion}', [AgrupacionController::class, 'update'])->middleware('permission:editar_agrupacion')->name('agrupaciones.update');
            Route::delete('/agrupaciones/{agrupacion}', [AgrupacionController::class, 'destroy'])->middleware('permission:eliminar_agrupacion')->name('agrupaciones.destroy');
            Route::get('/agrupaciones/{id}/ver', [AgrupacionController::class, 'show'])->middleware('permission:ver_detalles_agrupacion')->name('agrupaciones.detalles_agrupaciones');
        });

        // === Productos ===
        Route::middleware(['auth', 'permission:ver_productos'])->group(function () {
            Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
            Route::get('/productos/{id}/detalles', [ProductoController::class, 'detalles'])->middleware('permission:ver_detalles_producto')->name('productos.detalles');
            Route::get('/productos/{id}/edit', [ProductoController::class, 'edit'])->middleware('permission:editar_producto')->name('productos.edit');
            Route::put('/productos/{id}', [ProductoController::class, 'update'])->middleware('permission:editar_producto')->name('productos.update');
            Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->middleware('permission:eliminar_producto')->name('productos.destroy');
            Route::post('/productos/{id}/aprobar', [ProductoController::class, 'aprobar'])->middleware('permission:aprobar_producto')->name('productos.aprobar');
            Route::post('/productos/{id}/rechazar', [ProductoController::class, 'rechazar'])->middleware('permission:rechazar_producto')->name('productos.rechazar');
            Route::post('/productos/aprobar-multiples', [ProductoController::class, 'aprobarMultiples'])->middleware('permission:aprobar_productos_multiples')->name('productos.aprobar.multiples');
            Route::post('/productos/rechazar-multiples', [ProductoController::class, 'rechazarMultiples'])->middleware('permission:rechazar_productos_multiples')->name('productos.rechazar.multiples');
        });

        // === Catálogos ===
        Route::middleware(['auth', 'permission:ver_catalogos|crear_catalogo|editar_catalogo|eliminar_catalogo'])->group(function () {
            Route::resource('catalogos', AdminCatalogoController::class)->except(['show']);
        });

        // === Pedidos ===
        Route::middleware(['auth', 'permission:ver_pedidos|ver_productos_pedido'])->group(function () {
            Route::get('/pedidos', [PedidoAdminController::class, 'index'])->middleware('permission:ver_pedidos')->name('pedidos.index');
            Route::get('/pedidos/{pedido}/productos', [PedidoAdminController::class, 'verProductos'])->middleware('permission:ver_productos_pedido')->name('pedidos.ver-productos');
        });
    });
