<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\LembagaController;
use App\Http\Controllers\LisensiController;
use App\Http\Controllers\ParalelController;
use App\Http\Controllers\SambutanController;
use App\Http\Controllers\StrukturController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DataAsesorController;

use App\Http\Controllers\DataPesertaController;
use App\Http\Controllers\SertifikasiController;
use App\Http\Controllers\Backend\HeroController;

use App\Http\Controllers\Backend\StatController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\ProsesUjikomController;
use App\Http\Controllers\Backend\AsesorController;
use App\Http\Controllers\Backend\FooterController;
use App\Http\Controllers\Backend\UploadController;
use App\Http\Controllers\Backend\LicenseController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\ServiceController;
use App\Http\Controllers\Backend\AdminFaqController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\ManajemenPenggunaController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Backend\AdminEventController;
use App\Http\Controllers\Backend\ProfileLspController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Backend\AdminGaleriController;
use App\Http\Controllers\Backend\ParalelPageController;
use App\Http\Controllers\Backend\AdminArtikelController;
use App\Http\Controllers\Backend\AdminLembagaController;
use App\Http\Controllers\Backend\SambutanPageController;
use App\Http\Controllers\Backend\ProfileSectionController;
use App\Http\Controllers\Backend\AssociationLogoController;
use App\Http\Controllers\Backend\AdminSertifikasiController;
use App\Http\Controllers\Backend\AdminProsesUjikomController;
use App\Http\Controllers\Backend\PesertaSertifikatController;
use App\Http\Controllers\Backend\StrukturOrganisasiController;
use App\Http\Controllers\Backend\CertificationSchemeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/coming-soon', function () {
    return view('under-maintanance.index');
})->name('coming.soon');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::get('/lisensi', [LisensiController::class, 'index'])->name('lisensi');
Route::get('/sambutan', [SambutanController::class, 'index'])->name('sambutan');
Route::get('/profil/{slug}', [ParalelController::class, 'index'])->name('profil.static');
Route::get('/struktur', [StrukturController::class, 'index'])->name('struktur');
Route::get('/informasi/proses-ujikom', [ProsesUjikomController::class, 'index'])->name('proses-ujikom');
Route::get('/informasi/manajemen', [ManajemenPenggunaController::class, 'index'])->name('informasi.manajemen');
Route::get('/informasi/faq', [FaqController::class, 'index'])->name('informasi.faq');
Route::get('/informasi/galeri', [GaleriController::class, 'index'])->name('informasi.galeri');
Route::get('/informasi/event', [EventController::class, 'index'])->name('informasi.event');
Route::get('/informasi/event/{slug}', [EventController::class, 'show'])->name('informasi.event.show');
// Route::get('/informasi/lembaga', [LembagaController::class, 'index'])->name('informasi.lembaga');
Route::get('informasi/lembaga-pelatihan', [LembagaController::class, 'index'])->name('informasi.lembaga.index');
// Menampilkan detail lembaga berdasarkan slug
Route::get('informasi/lembaga-pelatihan/search', [LembagaController::class, 'search'])->name('informasi.lembaga.search');
Route::get('informasi/lembaga-pelatihan/{slug}', [LembagaController::class, 'show'])->name('informasi.lembaga.show');

Route::get('/informasi/artikel', [ArtikelController::class, 'index'])->name('informasi.artikel');
Route::get('informasi/artikel/search', [ArtikelController::class, 'search'])->name('informasi.artikel.search');
Route::get('/informasi/artikel/{slug}', [ArtikelController::class, 'show'])->name('informasi.artikel.show');
Route::prefix('sertifikasi')
    ->name('sertifikasi.')
    ->group(function () {
        Route::get('/', [SertifikasiController::class, 'index'])->name('index');
        Route::get('/{slug}', [SertifikasiController::class, 'show'])->name('show');
    });

Route::resource('asesor', DataAsesorController::class)->except(['show']);
Route::get('asesor/data', [DataAsesorController::class, 'index'])->name('asesor.data');
Route::resource('asesi', DataPesertaController::class)->except(['show']);
Route::get('asesi/data', [DataPesertaController::class, 'index'])->name('asesi.data');

// BACK END -----------------------------------------------------------------------------------------------------------------------------------

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        // Route::get('/dashboard', action: function () {
        //     return view('Backend.dashboard');
        // })->name('dashboard');

        // User Management
        Route::resource('users', UserController::class)->except(['show']);
        Route::get('users/data', [UserController::class, 'data'])->name('users.data');

        // Site Configuration
        Route::prefix('site')
            ->name('site.')
            ->group(function () {
                // Footer Settings
                Route::get('footer', [FooterController::class, 'index'])->name('footer.index');
                Route::put('footer', [FooterController::class, 'update'])->name('footer.update');
            });

        // Home Page Management
        Route::prefix('home')
            ->name('home.')
            ->group(function () {
                // Hero Section
                Route::get('hero', [HeroController::class, 'index'])->name('hero.index');
                Route::post('hero', [HeroController::class, 'update'])->name('hero.update');

                // Statistics Section
                Route::get('statistics', [StatController::class, 'index'])->name('statistics.index');
                Route::put('statistics', [StatController::class, 'update'])->name('statistics.update');

                // Profile Section
                Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
                Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

                // Certification Schemes
                Route::resource('certifications', CertificationSchemeController::class)->except(['show']);
                Route::get('certifications/data', [CertificationSchemeController::class, 'data'])->name('certifications.data');

                // Services
                Route::resource('services', ServiceController::class);
                Route::get('services/data', [ServiceController::class, 'data'])->name('services.data');

                // Association Management
                Route::resource('associations', AssociationLogoController::class)->except(['show']);
                Route::get('associations/data', [AssociationLogoController::class, 'data'])->name('associations.data');
            });

        // LSP Profile Management
        Route::prefix('lsp-profile')
            ->name('lsp.')
            ->group(function () {
                // Main LSP Profile
                Route::get('/', [ProfileLspController::class, 'index'])->name('index');
                Route::get('{id}/edit', [ProfileLspController::class, 'edit'])->name('edit');
                Route::put('{id}', [ProfileLspController::class, 'update'])->name('update');

                // Profile Sections
                Route::prefix('sections')
                    ->name('sections.')
                    ->group(function () {
                        Route::get('/', [ProfileSectionController::class, 'index'])->name('index');
                        Route::get('data', [ProfileSectionController::class, 'getData'])->name('data');
                        Route::get('create', [ProfileSectionController::class, 'create'])->name('create');
                        Route::post('/', [ProfileSectionController::class, 'store'])->name('store');
                        Route::get('{key}/edit', [ProfileSectionController::class, 'edit'])->name('edit');
                        Route::put('{key}', [ProfileSectionController::class, 'update'])->name('update');
                        Route::delete('{key}', [ProfileSectionController::class, 'destroy'])->name('destroy');

                        // AJAX Operations
                        Route::post('reorder', [ProfileSectionController::class, 'reorder'])->name('reorder');
                        Route::post('upload-image', [ProfileSectionController::class, 'uploadImage'])->name('upload_image');
                    });
            });

        // Global Upload Handler
        Route::post('upload-image', [UploadController::class, 'uploadImage'])->name('uploadImage');

        // License Management Routes
        Route::resource('licenses', LicenseController::class);

        // Additional license routes
        Route::get('licenses-data', [LicenseController::class, 'data'])->name('licenses.data');
        Route::put('license-settings', [LicenseController::class, 'updateSettings'])->name('licenses.settings.update');

        Route::prefix('sambutan')
            ->name('sambutan.')
            ->group(function () {
                Route::get('/', [SambutanPageController::class, 'index'])->name('index');
                Route::post('admin/sambutan/{id}/update', [SambutanPageController::class, 'update'])->name('update');
                Route::get('/preview', [SambutanPageController::class, 'preview'])->name('preview');
            });

        Route::prefix('paralel')
            ->name('paralel.')
            ->group(function () {
                Route::get('{slug}/edit', [ParalelPageController::class, 'edit'])->name('edit');
                Route::post('{slug}/update', [ParalelPageController::class, 'update'])->name('update');
            });

        Route::prefix('struktur')
            ->name('struktur.')
            ->group(function () {
                Route::get('/', [StrukturOrganisasiController::class, 'index'])->name('index');
                Route::post('/update-title', [StrukturOrganisasiController::class, 'updateTitle'])->name('updateTitle');
                Route::post('/append-image', [StrukturOrganisasiController::class, 'appendImage'])->name('appendImage');
                Route::post('/delete-image/{index}', [StrukturOrganisasiController::class, 'deleteImage'])->name('deleteImage');
            });

        // Sertifikasi Routes
        Route::prefix('sertifikasi')
            ->name('sertifikasi.')
            ->group(function () {
                // Main CRUD Routes
                Route::get('/', [AdminSertifikasiController::class, 'index'])->name('index');
                Route::get('/create', [AdminSertifikasiController::class, 'create'])->name('create');
                Route::post('/', [AdminSertifikasiController::class, 'store'])->name('store');
                Route::get('/{sertifikasi}', [AdminSertifikasiController::class, 'show'])->name('show');
                Route::get('/{sertifikasi}/edit', [AdminSertifikasiController::class, 'edit'])->name('edit');
                Route::put('/{sertifikasi}', [AdminSertifikasiController::class, 'update'])->name('update');
                Route::delete('/{sertifikasi}', [AdminSertifikasiController::class, 'destroy'])->name('destroy');

                // Status Toggle Route
                Route::post('/{sertifikasi}/toggle-status', [AdminSertifikasiController::class, 'toggleStatus'])->name('toggle-status');

                // Unit Kompetensi Routes
                Route::get('/{sertifikasi}/unit-kompetensi', [AdminSertifikasiController::class, 'unitKompetensi'])->name('unit-kompetensi');
                Route::put('/{sertifikasi}/unit-kompetensi', [AdminSertifikasiController::class, 'updateUnitKompetensi'])->name('unit-kompetensi.update');

                // Persyaratan Dasar Routes (Only for child sertifikasi)
                Route::get('/{sertifikasi}/persyaratan-dasar', [AdminSertifikasiController::class, 'persyaratanDasar'])->name('persyaratan-dasar');
                Route::put('/{sertifikasi}/persyaratan-dasar', [AdminSertifikasiController::class, 'updatePersyaratanDasar'])->name('persyaratan-dasar.update');

                // Biaya Uji Routes (Only for child sertifikasi)
                Route::get('/{sertifikasi}/biaya-uji', [AdminSertifikasiController::class, 'biayaUji'])->name('biaya-uji');
                Route::put('/{sertifikasi}/biaya-uji', [AdminSertifikasiController::class, 'updateBiayaUji'])->name('biaya-uji.update');
            });

        Route::prefix('ujikom')
            ->name('ujikom.')
            ->group(function () {
                Route::get('/', [AdminProsesUjikomController::class, 'index'])->name('index');
                Route::post('/update-title', [AdminProsesUjikomController::class, 'updateTitle'])->name('updateTitle');
                Route::post('/append-image', [AdminProsesUjikomController::class, 'appendImage'])->name('appendImage');
                Route::post('/delete-image/{index}', [AdminProsesUjikomController::class, 'deleteImage'])->name('deleteImage');
            });
        Route::prefix('galeri')
            ->name('galeri.')
            ->group(function () {
                Route::get('/', [AdminGaleriController::class, 'index'])->name('index');
                Route::post('/update-title', [AdminGaleriController::class, 'updateTitle'])->name('updateTitle');
                Route::post('/append-image', [AdminGaleriController::class, 'appendImage'])->name('appendImage');
                Route::post('/delete-image/{index}', [AdminGaleriController::class, 'deleteImage'])->name('deleteImage');
            });

        Route::resource('faq', AdminFaqController::class);
        Route::get('faq-data', [AdminFaqController::class, 'getData'])->name('faq.data');
        Route::patch('faq/{id}/toggle-status', [AdminFaqController::class, 'toggleStatus'])->name('faq.toggle-status');

        Route::resource('lembaga', AdminLembagaController::class);
        Route::get('lembaga-data', [AdminLembagaController::class, 'data'])->name('lembaga.data');

        Route::resource('artikel', AdminArtikelController::class);
        Route::get('artikel-data', [AdminArtikelController::class, 'data'])->name('artikel.data');

        Route::resource('event', AdminEventController::class);
        Route::get('event-data', [AdminEventController::class, 'data'])->name('event.data');

        Route::get('peserta-sertifikat/data', [PesertaSertifikatController::class, 'index'])->name('peserta-sertifikat.data');
        Route::get('peserta-sertifikat/import', [PesertaSertifikatController::class, 'importForm'])->name('peserta-sertifikat.import.form');
        Route::post('peserta-sertifikat/import', [PesertaSertifikatController::class, 'import'])->name('peserta-sertifikat.import');

        Route::resource('peserta-sertifikat', PesertaSertifikatController::class)->except(['show']);
        Route::resource('asesor', AsesorController::class)->except(['show']);
        Route::get('asesor/data', [AsesorController::class, 'index'])->name('asesor.data');
        Route::get('asesor/import', [AsesorController::class, 'importForm'])->name('asesor.import.form');
        Route::post('asesor/import', [AsesorController::class, 'import'])->name('asesor.import');
    });

// ---------------------------------------------------------------------------------------------------------------------------------------------
// AUTH ROUTE
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('proses.login');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
