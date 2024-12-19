Autentikasi Pengguna dengan Laravel Auth dan Session
Dokumentasi ini menjelaskan cara menggunakan Laravel Auth dan Session untuk menangani autentikasi pengguna dalam aplikasi Laravel.

1. Login dengan Auth::attempt()
Pada saat pengguna mencoba login, Anda dapat menggunakan Auth::attempt() untuk memverifikasi kredensial pengguna (email dan password). Jika kredensial yang dimasukkan valid, pengguna akan otomatis terautentikasi, dan session akan dibuat untuk pengguna tersebut.

Contoh kode untuk proses login:

php
if (Auth::attempt($request->only('email', 'password'))) {
    return redirect()->route('dashboard');  // Redirect ke dashboard jika login berhasil
}
Penjelasan:

Auth::attempt() menerima array berisi kredensial (misalnya email dan password) yang ingin divalidasi.
Jika kredensial valid, Laravel akan membuat session yang menyimpan informasi pengguna yang sedang login, memungkinkan pengguna untuk tetap terautentikasi selama sesi tersebut.

2. Logout dengan Auth::logout()
Pada saat pengguna logout, Anda dapat menggunakan Auth::logout() untuk menghapus sesi pengguna dan menghentikan status login.

Contoh kode untuk proses logout:

php
public function logout()
{
    Auth::logout();  // Menghapus sesi pengguna
    return redirect('login');  // Redirect ke halaman login
}
Penjelasan:

Auth::logout() akan menghapus sesi yang menyimpan informasi pengguna yang sedang login, sehingga pengguna dianggap keluar dari aplikasi.
Setelah logout, pengguna akan diarahkan kembali ke halaman login.

3. Middleware auth
Untuk membatasi akses hanya kepada pengguna yang sudah login, Anda dapat menggunakan middleware auth pada route yang memerlukan autentikasi.

Contoh penerapan middleware auth pada route:

php
Route::get('dashboard', [DashboardController::class, 'index'])->middleware('auth');
Penjelasan:

Middleware auth memastikan hanya pengguna yang sudah terautentikasi yang dapat mengakses halaman tersebut.
Jika pengguna belum login, mereka akan diarahkan ke halaman login.

4. Login Otomatis Setelah Register
Pada bagian register, setelah pengguna berhasil mendaftar, Anda dapat langsung login pengguna tersebut menggunakan Auth::login($user). Hal ini memungkinkan pengguna yang baru terdaftar untuk langsung diarahkan ke halaman dashboard tanpa perlu memasukkan kredensial login lagi.

Contoh kode untuk login otomatis setelah registrasi:

php
public function register(Request $request)
{
    // Validasi input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:3|confirmed',
    ]);

    // Membuat pengguna baru
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Login otomatis setelah registrasi
    Auth::login($user);

    // Redirect ke dashboard
    return redirect()->route('dashboard');
}
Penjelasan:

Auth::login($user) akan langsung login pengguna yang baru terdaftar.
Setelah login, pengguna akan langsung diarahkan ke halaman dashboard tanpa perlu login manual.
Ringkasan
Login: Menggunakan Auth::attempt() untuk memverifikasi kredensial pengguna dan membuat session.
Logout: Menggunakan Auth::logout() untuk menghapus sesi dan logout pengguna.
Middleware auth: Digunakan untuk membatasi akses ke route tertentu hanya untuk pengguna yang sudah login.
Login Otomatis setelah Register: Menggunakan Auth::login($user) untuk langsung login pengguna yang baru terdaftar.
Dengan cara ini, Laravel akan menangani sesi secara otomatis, memastikan pengguna yang sudah login dapat mengakses aplikasi dengan aman dan mudah.

