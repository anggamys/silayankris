<?php

use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\Periodik\PerBulanController;
use App\Http\Controllers\Admin\Periodik\PerSemesterController;
use App\Http\Controllers\Admin\Periodik\PerTahunController;
use App\Http\Controllers\Admin\GerejaController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\Periodik\PerBulanUserController;
use App\Http\Controllers\User\Periodik\PerSemesterUserController;
use App\Http\Controllers\User\Periodik\PerTahunUserController;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::get('/', function () {
    return view('pages.guest.home');
})->name('landingpage');
Route::get('/layanan', function () {
    return view('pages.guest.layanan');
})->name('layanan');
Route::get('/home', function () {
    return view('pages.guest.home');
})->name('home');
;

// Public routes for Berita
Route::get('/berita', [BeritaController::class, 'publicIndex'])->name('berita.index');
Route::get('/berita/{berita:slug}', [BeritaController::class, 'publicShow'])->name('berita.show');

// Resourceful routes for admin (requires auth)
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {

        // Dashboard route
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        // Resourceful routes for admin entities
        Route::resource('users', UserController::class)->names('users');
        // Berita routes
        Route::resource('berita', BeritaController::class)->parameters([
            'berita' => 'berita'
        ])->names('berita');

        // Sekolah routes
        Route::resource('sekolah', SekolahController::class)->names('sekolah');

        // Periodik routes
        Route::resource('per-bulan', PerBulanController::class)->names('per-bulan');
        Route::resource('per-semester', PerSemesterController::class)->names('per-semester');
        Route::resource('per-tahun', PerTahunController::class)->names('per-tahun');

        // Gereja routes
        Route::resource('gereja', GerejaController::class)->names('gereja');

    });

    Route::middleware(['auth'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/get-kecamatan', [LokasiController::class, 'getKecamatan'])->name('lokasi.kecamatan');
        Route::get('/get-kelurahan', [LokasiController::class, 'getKelurahan'])->name('lokasi.kelurahan');
    });

    // Resourceful routes for PerBulan for users
Route::middleware(['auth', 'role:guru'])
    ->prefix('user/perbulan')
    ->as('user.perbulan.')
    ->group(function () {
        Route::get('/', [PerBulanUserController::class, 'index'])->name('index');
        Route::get('/create', [PerBulanUserController::class, 'create'])->name('create');
        Route::post('/', [PerBulanUserController::class, 'store'])->name('store');
        Route::get('/{perBulan}', [PerBulanUserController::class, 'show'])->name('show');
        // Allow users to edit their incomplete submissions and submit revisions
        Route::get('/{perBulan}/edit', [PerBulanUserController::class, 'edit'])->name('edit');
        Route::match(['put', 'patch'], '/{perBulan}', [PerBulanUserController::class, 'update'])->name('update');
    });


// Resourceful routes for PerSemester for users
Route::middleware(['auth', 'role:guru'])
    ->prefix('user/persemester')
    ->as('user.persemester.')
    ->group(function () {   
        Route::get('/', [PerSemesterUserController::class, 'index'])->name('index');
        Route::get('/create', [PerSemesterUserController::class, 'create'])->name('create');
        Route::post('/', [PerSemesterUserController::class, 'store'])->name('store');
        Route::get('/{perSemester}', [PerSemesterUserController::class, 'show'])->name('show');
        // Allow users to edit their incomplete submissions and submit revisions
        Route::get('/{perSemester}/edit', [PerSemesterUserController::class, 'edit'])->name('edit');
        Route::match(['put', 'patch'], '/{perSemester}', [PerSemesterUserController::class, 'update'])->name('update');
    });

// Resourceful routes for PerTahun for users
Route::middleware(['auth', 'role:guru'])
    ->prefix('user/pertahun')
    ->as('user.pertahun.')
    ->group(function () {   
        Route::get('/', [PerTahunUserController::class, 'index'])->name('index');
        Route::get('/create', [PerTahunUserController::class, 'create'])->name('create');
        Route::post('/', [PerTahunUserController::class, 'store'])->name('store');
        Route::get('/{perTahun}', [PerTahunUserController::class, 'show'])->name('show');
        // Allow users to edit their incomplete submissions and submit revisions
        Route::get('/{perTahun}/edit', [PerTahunUserController::class, 'edit'])->name('edit');
        Route::match(['put', 'patch'], '/{perTahun}', [PerTahunUserController::class, 'update'])->name('update');
    });

// Resourceful routes for Pendataan Gereja for users
    Route::middleware(['auth', 'role:staff-gereja'])
    ->prefix('user')
    ->as('user.')
    ->group(function () {
        Route::get('/pendataan-gereja', [GerejaController::class, 'indexUser'])->name('gereja.index');
        Route::put('/pendataan-gereja/{gereja}', [GerejaController::class, 'updateUser'])->name('gereja.update');
    });

// Pengaturan Akun routes (User)
Route::middleware(['auth'])
    ->prefix('user/pengaturan-akun')
    ->as('user.settings.')
    ->group(function () {
        Route::get('/', function () {
            return view('pages.user.pengaturan-akun');
        })->name('index');
        
        Route::put('/photo', function (\Illuminate\Http\Request $request) {
            $request->validate([
                'profile_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ],           [
                'profile_photo.mimes' => 'Format gambar harus berupa jpg, jpeg, atau png.',
                'profile_photo.max' => 'Ukuran gambar maksimal adalah 2MB.',
            ]);

            /** @var \App\Models\User $user */
            $user = \Illuminate\Support\Facades\Auth::user();
            
            // Delete old photo if exists 
            if ($user->profile_photo_path) {
                try {
                    if (\Illuminate\Support\Facades\Storage::exists('public/' . $user->profile_photo_path)) {
                        \Illuminate\Support\Facades\Storage::delete('public/' . $user->profile_photo_path);
                    }
                } catch (\Exception $e) {
                    // Ignore deletion errors
                }
            }

            // Store new photo
            $file = $request->file('profile_photo');
            $filename = 'profile_' . \Illuminate\Support\Facades\Auth::id() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profiles', $filename, 'public');
            
            if ($path) {
                $user->profile_photo_path = $path;
                $user->save();
                return back()->with('success', 'Foto profil berhasil diperbarui.');
            }
            
            return back()->with('error', 'Gagal menyimpan foto profil.');
        })->name('update-photo');
        
        Route::put('/password', function (\Illuminate\Http\Request $request) {
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).+$/', // At least one uppercase, one lowercase, and one digit
            ],           [
                'old_password.required' => 'Password lama wajib diisi.',
                'new_password.required' => 'Kata sandi baru wajib diisi.',
                'new_password.min' => 'Kata sandi baru harus terdiri dari minimal 8 karakter.',
                'new_password.confirmed' => 'Konfirmasi kata sandi baru tidak sesuai.',
                'new_password.regex' => 'Kata sandi baru harus mengandung setidaknya satu huruf besar, satu huruf kecil, dan satu angka.',
            ]);

            
            /** @var \App\Models\User $user */
            $user = \Illuminate\Support\Facades\Auth::user();
            
            if (!\Illuminate\Support\Facades\Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'Password lama tidak sesuai.']);
            }
            
            $user->password = \Illuminate\Support\Facades\Hash::make($request->new_password);
            $user->save();
            
            return back()->with('success', 'Password berhasil diperbarui.');
        })->name('update-password');
    });

// Pengaturan Akun routes (Admin)
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin/pengaturan-akun')
    ->as('admin.settings.')
    ->group(function () {
        Route::get('/', function () {
            return view('pages.admin.pengaturan-akun');
        })->name('index');
        
        Route::put('/photo', function (\Illuminate\Http\Request $request) {
            $request->validate([
                'profile_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ],           [
                'profile_photo.mimes' => 'Format gambar harus berupa jpg, jpeg, atau png.',
                'profile_photo.max' => 'Ukuran gambar maksimal adalah 2MB.',
            ]);

            /** @var \App\Models\User $user */
            $user = \Illuminate\Support\Facades\Auth::user();
            
            // Delete old photo if exists
            if ($user->profile_photo_path) {
                try {
                    if (\Illuminate\Support\Facades\Storage::exists('public/' . $user->profile_photo_path)) {
                        \Illuminate\Support\Facades\Storage::delete('public/' . $user->profile_photo_path);
                    }
                } catch (\Exception $e) {
                    // Ignore deletion errors
                }
            }

            // Store new photo
            $file = $request->file('profile_photo');
            $filename = 'profile_' . \Illuminate\Support\Facades\Auth::id() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profiles', $filename, 'public');
            
            if ($path) {
                $user->profile_photo_path = $path;
                $user->save();
                return back()->with('success', 'Foto profil berhasil diperbarui.');
            }
            
            return back()->with('error', 'Gagal menyimpan foto profil.');
        })->name('update-photo');
        
        Route::put('/password', function (\Illuminate\Http\Request $request) {
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).+$/', // At least one uppercase, one lowercase, and one digit
            ],           [
                'old_password.required' => 'Password lama wajib diisi.',
                'new_password.required' => 'Kata sandi baru wajib diisi.',
                'new_password.min' => 'Kata sandi baru harus terdiri dari minimal 8 karakter.',
                'new_password.confirmed' => 'Konfirmasi kata sandi baru tidak sesuai.',
                'new_password.regex' => 'Kata sandi baru harus mengandung setidaknya satu huruf besar, satu huruf kecil, dan satu angka.',
            ]);
            
            /** @var \App\Models\User $user */
            $user = \Illuminate\Support\Facades\Auth::user();
            
            if (!\Illuminate\Support\Facades\Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'Password lama tidak sesuai.']);
            }
            
            $user->password = \Illuminate\Support\Facades\Hash::make($request->new_password);
            $user->save();
            
            return back()->with('success', 'Password berhasil diperbarui.');
        })->name('update-password');
    });

require __DIR__ . '/auth.php';
require __DIR__ . '/gdrive.php';