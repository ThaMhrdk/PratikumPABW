<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\PsikologController as UserPsikologController;
use App\Http\Controllers\User\BookingController as UserBookingController;
use App\Http\Controllers\User\ConsultationController as UserConsultationController;
use App\Http\Controllers\Psikolog\DashboardController as PsikologDashboardController;
use App\Http\Controllers\Psikolog\ScheduleController as PsikologScheduleController;
use App\Http\Controllers\Psikolog\BookingController as PsikologBookingController;
use App\Http\Controllers\Psikolog\ConsultationController as PsikologConsultationController;
use App\Http\Controllers\Psikolog\ArticleController as PsikologArticleController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PsikologVerificationController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ForumManagementController;
use App\Http\Controllers\Pemerintah\DashboardController as PemerintahDashboardController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Articles
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRoleSelection'])->name('register.role');
    Route::get('/register/{role}', [AuthController::class, 'showRegisterForm'])->name('register')
        ->where('role', 'user|psikolog');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Forum Routes (Requires Authentication)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('forum')->name('forum.')->group(function () {
    Route::get('/', [ForumController::class, 'index'])->name('index');
    Route::get('/create', [ForumController::class, 'create'])->name('create');
    Route::post('/store', [ForumController::class, 'store'])->name('store');
    Route::get('/topic/{topic}', [ForumController::class, 'topic'])->name('topic');
    Route::get('/post/{post}', [ForumController::class, 'showPost'])->name('post');
    Route::get('/topic/{topic}/create', [ForumController::class, 'createPost'])->name('create-post');
    Route::post('/topic/{topic}/post', [ForumController::class, 'storePost'])->name('store-post');
    Route::post('/post/{post}/comment', [ForumController::class, 'storeComment'])->name('store-comment');
});

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Psikolog browsing
    Route::get('/psikolog', [UserPsikologController::class, 'index'])->name('psikolog.index');
    Route::get('/psikolog/{psikolog}', [UserPsikologController::class, 'show'])->name('psikolog.show');
    Route::get('/psikolog/{psikolog}/schedules', [UserPsikologController::class, 'schedules'])->name('psikolog.schedules');

    // Booking
    Route::get('/booking', [UserBookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/create/{schedule}', [UserBookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [UserBookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{booking}', [UserBookingController::class, 'show'])->name('booking.show');
    Route::get('/booking/{booking}/payment', [UserBookingController::class, 'payment'])->name('booking.payment');
    Route::post('/booking/{booking}/payment', [UserBookingController::class, 'processPayment'])->name('booking.process-payment');
    Route::post('/booking/{booking}/cancel', [UserBookingController::class, 'cancel'])->name('booking.cancel');

    // Consultation
    Route::get('/consultation', [UserConsultationController::class, 'index'])->name('consultation.index');
    Route::get('/consultation/{consultation}', [UserConsultationController::class, 'show'])->name('consultation.show');
    Route::get('/consultation/{consultation}/chat', [UserConsultationController::class, 'chat'])->name('consultation.chat');
    Route::post('/consultation/{consultation}/chat', [UserConsultationController::class, 'sendMessage'])->name('consultation.send-message');
    Route::get('/consultation/{consultation}/feedback', [UserConsultationController::class, 'feedback'])->name('consultation.feedback');
    Route::post('/consultation/{consultation}/feedback', [UserConsultationController::class, 'storeFeedback'])->name('consultation.store-feedback');
});

/*
|--------------------------------------------------------------------------
| Psikolog Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:psikolog'])->prefix('psikolog')->name('psikolog.')->group(function () {
    Route::get('/dashboard', [PsikologDashboardController::class, 'index'])->name('dashboard');

    // Schedule
    Route::get('/schedule', [PsikologScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/schedule/create', [PsikologScheduleController::class, 'create'])->name('schedule.create');
    Route::post('/schedule', [PsikologScheduleController::class, 'store'])->name('schedule.store');
    Route::get('/schedule/{schedule}/edit', [PsikologScheduleController::class, 'edit'])->name('schedule.edit');
    Route::put('/schedule/{schedule}', [PsikologScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/schedule/{schedule}', [PsikologScheduleController::class, 'destroy'])->name('schedule.destroy');

    // Booking Management
    Route::get('/booking', [PsikologBookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/{booking}', [PsikologBookingController::class, 'show'])->name('booking.show');
    Route::post('/booking/{booking}/confirm', [PsikologBookingController::class, 'confirm'])->name('booking.confirm');
    Route::post('/booking/{booking}/reject', [PsikologBookingController::class, 'reject'])->name('booking.reject');

    // Consultation
    Route::get('/consultation', [PsikologConsultationController::class, 'index'])->name('consultation.index');
    Route::get('/consultation/start/{booking}', [PsikologConsultationController::class, 'start'])->name('consultation.start');
    Route::get('/consultation/{consultation}', [PsikologConsultationController::class, 'show'])->name('consultation.show');
    Route::get('/consultation/{consultation}/chat', [PsikologConsultationController::class, 'chat'])->name('consultation.chat');
    Route::post('/consultation/{consultation}/chat', [PsikologConsultationController::class, 'sendMessage'])->name('consultation.send-message');
    Route::post('/consultation/{consultation}/complete', [PsikologConsultationController::class, 'complete'])->name('consultation.complete');

    // Articles
    Route::get('/article', [PsikologArticleController::class, 'index'])->name('article.index');
    Route::get('/article/create', [PsikologArticleController::class, 'create'])->name('article.create');
    Route::post('/article', [PsikologArticleController::class, 'store'])->name('article.store');
    Route::get('/article/{article}/edit', [PsikologArticleController::class, 'edit'])->name('article.edit');
    Route::put('/article/{article}', [PsikologArticleController::class, 'update'])->name('article.update');
    Route::delete('/article/{article}', [PsikologArticleController::class, 'destroy'])->name('article.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Psikolog Verification
    Route::get('/psikolog', [PsikologVerificationController::class, 'index'])->name('psikolog.index');
    Route::get('/psikolog/{psikolog}', [PsikologVerificationController::class, 'show'])->name('psikolog.show');
    Route::post('/psikolog/{psikolog}/verify', [PsikologVerificationController::class, 'verify'])->name('psikolog.verify');
    Route::post('/psikolog/{psikolog}/reject', [PsikologVerificationController::class, 'reject'])->name('psikolog.reject');

    // Reports
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/create', [ReportController::class, 'create'])->name('report.create');
    Route::post('/report', [ReportController::class, 'store'])->name('report.store');
    Route::get('/report/{report}', [ReportController::class, 'show'])->name('report.show');
    Route::post('/report/{report}/send', [ReportController::class, 'send'])->name('report.send');

    // Forum Management
    Route::get('/forum', [ForumManagementController::class, 'index'])->name('forum.index');
    Route::get('/forum/posts', [ForumManagementController::class, 'posts'])->name('forum.posts');
    Route::delete('/forum/post/{post}', [ForumManagementController::class, 'deletePost'])->name('forum.delete-post');
    Route::delete('/forum/comment/{comment}', [ForumManagementController::class, 'deleteComment'])->name('forum.delete-comment');
    Route::get('/forum/topic/create', [ForumManagementController::class, 'createTopic'])->name('forum.create-topic');
    Route::post('/forum/topic', [ForumManagementController::class, 'storeTopic'])->name('forum.store-topic');
});

/*
|--------------------------------------------------------------------------
| Pemerintah Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:pemerintah'])->prefix('pemerintah')->name('pemerintah.')->group(function () {
    Route::get('/dashboard', [PemerintahDashboardController::class, 'index'])->name('dashboard');
    Route::get('/reports', [PemerintahDashboardController::class, 'reports'])->name('reports');
    Route::get('/report/{report}', [PemerintahDashboardController::class, 'showReport'])->name('report.show');
    Route::get('/statistics', [PemerintahDashboardController::class, 'statistics'])->name('statistics');
});
