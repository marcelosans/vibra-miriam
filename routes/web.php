<?php

use App\Livewire\AboutMe;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\BlogDetailPage;
use App\Livewire\BlogsPage;
use App\Livewire\ContactPage;
use App\Livewire\HomePage;
use App\Livewire\MisCitas;
use App\Livewire\MyProfilePage;
use App\Livewire\ReservarCita;
use Illuminate\Support\Facades\Route;


Route::get('/',HomePage::class)->name('homepage');
Route::get('/sobre-mi',AboutMe::class);
Route::get('/blog',BlogsPage::class);
Route::get('/blog-detail/{slug}',BlogDetailPage::class);
Route::get('/contacto',ContactPage::class);
Route::get('/reservar-cita',ReservarCita::class);
Route::get('/perfil',MyProfilePage::class);
Route::get('/login',LoginPage::class)->name('login');
Route::get('/register',RegisterPage::class)->name('register');
Route::get('/mis-citas',MisCitas::class);