<?php

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\UserController;
use App\Controllers\ProjectController;
use App\Controllers\TaskController;
use App\Controllers\CategoryController;
use App\Controllers\TeamController;
use Bramus\Router\Router;

$router = new Router();

// Set base path for router
$router->setBasePath('/du_an_xuong/public');

// =====================
// AUTHENTICATION ROUTES
// =====================
$router->get('/login', AuthController::class . '@loginPage');
$router->post('/login', AuthController::class . '@handleLogin');
$router->get('/register', AuthController::class . '@register');
$router->post('/register', AuthController::class . '@handleRegister');
$router->get('/logout', AuthController::class . '@logout');

// Profile routes
$router->get('/profile', AuthController::class . '@profile');
$router->get('/profile/edit', AuthController::class . '@editProfile');
$router->post('/profile/edit', AuthController::class . '@updateProfile');
$router->get('/profile/change-password', AuthController::class . '@changePassword');
$router->post('/profile/change-password', AuthController::class . '@updatePassword');

// =====================
// DASHBOARD ROUTES
// =====================
$router->get('/dashboard', DashboardController::class . '@index');
$router->get('/dashboard/statistics', DashboardController::class . '@statistics');

// =====================
// USER MANAGEMENT (Admin only)
// =====================
$router->get('/users', UserController::class . '@index');
$router->get('/users/create', UserController::class . '@create');
$router->post('/users/create', UserController::class . '@store');
$router->get('/users/(\d+)', UserController::class . '@show');
$router->get('/users/(\d+)/edit', UserController::class . '@edit');
$router->post('/users/(\d+)/edit', UserController::class . '@update');
$router->get('/users/(\d+)/delete', UserController::class . '@delete');

// =====================
// CATEGORY MANAGEMENT (Admin only)
// =====================
$router->get('/categories', CategoryController::class . '@index');
$router->get('/categories/create', CategoryController::class . '@create');
$router->post('/categories/create', CategoryController::class . '@store');
$router->get('/categories/(\d+)/edit', CategoryController::class . '@edit');
$router->post('/categories/(\d+)/edit', CategoryController::class . '@update');
$router->get('/categories/(\d+)/delete', CategoryController::class . '@delete');

// =====================
// TEAM MANAGEMENT (Admin only)
// =====================
$router->get('/teams', TeamController::class . '@index');
$router->get('/teams/create', TeamController::class . '@create');
$router->post('/teams/create', TeamController::class . '@store');
$router->get('/teams/(\d+)', TeamController::class . '@show');
$router->get('/teams/(\d+)/edit', TeamController::class . '@edit');
$router->post('/teams/(\d+)/edit', TeamController::class . '@update');
$router->post('/teams/add-member', TeamController::class . '@addMember');
$router->get('/teams/(\d+)/remove-member/(\d+)', TeamController::class . '@removeMember');

// =====================
// PROJECT ROUTES
// =====================
$router->get('/projects', ProjectController::class . '@index');
$router->get('/projects/create', ProjectController::class . '@create');
$router->post('/projects/create', ProjectController::class . '@store');
$router->get('/projects/(\d+)', ProjectController::class . '@show');
$router->get('/projects/(\d+)/edit', ProjectController::class . '@edit');
$router->post('/projects/(\d+)/edit', ProjectController::class . '@update');
$router->get('/projects/(\d+)/delete', ProjectController::class . '@delete');

// =====================
// TASK ROUTES
// =====================
$router->get('/tasks', TaskController::class . '@index');
$router->get('/tasks/create', TaskController::class . '@create');
$router->post('/tasks/create', TaskController::class . '@store');
$router->get('/tasks/(\d+)', TaskController::class . '@show');
$router->get('/tasks/(\d+)/edit', TaskController::class . '@edit');
$router->post('/tasks/(\d+)/edit', TaskController::class . '@update');
$router->get('/tasks/(\d+)/delete', TaskController::class . '@delete');
$router->post('/tasks/add-comment', TaskController::class . '@addComment');
$router->post('/tasks/upload-attachment', TaskController::class . '@uploadAttachment');

// =====================
// DEFAULT ROUTE
// =====================
$router->get('/', function() {
    header('Location: /du_an_xuong/public/dashboard');
});

// =====================
// ERROR HANDLING
// =====================
$router->set404(function() {
    http_response_code(404);
    echo "404 - Trang không tìm thấy";
});

// Run router
$router->run();
