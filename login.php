<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Registrasi — SM Irigasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: "Segoe UI", Arial, sans-serif; }
        .tab-aktif    { background-color: #2e7d32; color: #fff; }
        .tab-nonaktif { background-color: #e8f5e9; color: #2e7d32; }
        .panel        { display: none; }
        .panel.aktif  { display: block; }
        input:focus, select:focus {
            outline: none;
            border-color: #2e7d32;
            box-shadow: 0 0 0 3px rgba(46,125,50,0.2);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col" style="background-color:#e8f5e9;">

    <nav style="background-color:#2e7d32;" class="shadow-md">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <span class="text-white font-bold text-xl">💧 SM Irigasi</span>
            <div class="hidden md:flex gap-6 text-sm" style="color:#c8e6c9;">
                <a href="index.php#monitoring" class="hover:text-white transition">Monitoring</a>
                <a href="index.php#fitur"      class="hover:text-white transition">Fitur</a>
                <a href="index.php#lapor"      class="hover:text-white transition">Laporan</a>
            </div>
        </div>
    </nav>

    <main class="flex-1 flex items-center justify-center py-10 px-4">
        <div class="w-full max-w-md">

            <div class="text-center mb-6">
                <div class="text-5xl mb-2">💧</div>
                <h1 class="text-2xl font-bold" style="color:#1b5e20;">SM Irigasi</h1>
                <p class="text-gray-500 text-sm mt-1">Sistem Monitoring Irigasi Sawah Berbasis Sensor</p>
            </div>

            <?php
            // Tampilkan pesan dari redirect
            if (isset($_GET['error'])) {
                $pesan = '';
                switch ($_GET['error']) {
                    case 'kosong':  $pesan = 'Mohon isi username dan password.'; break;
                    case 'salah':   $pesan = '❌ Username atau password salah.'; break;
                    case 'gagal':   $pesan = 'Terjadi kesalahan, coba lagi.'; break;
                }
                echo '<div class="mb-4 p-3 rounded-lg text-sm text-center bg-red-50 border border-red-400 text-red-800">' . $pesan . '</div>';
            }
            if (isset($_GET['sukses']) && $_GET['sukses'] === 'register') {
                echo '<div class="mb-4 p-3 rounded-lg text-sm text-center bg-green-50 border border-green-400 text-green-800">✅ Akun berhasil dibuat! Silakan login.</div>';
            }
            if (isset($_GET['reg_error'])) {
                $pesan = '';
                switch ($_GET['reg_error']) {
                    case 'kosong':    $pesan = 'Mohon lengkapi semua kolom.'; break;
                    case 'duplikat':  $pesan = 'Username atau email sudah digunakan.'; break;
                    case 'beda':      $pesan = 'Password dan konfirmasi tidak cocok.'; break;
                    case 'pendek':    $pesan = 'Password minimal 6 karakter.'; break;
                    case 'gagal':     $pesan = 'Gagal mendaftar, coba lagi.'; break;
                }
                // Tampilkan di tab register
            }
            $tab_aktif = isset($_GET['tab']) && $_GET['tab'] === 'register' ? 'register' : 'login';
            ?>

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="flex">
                    <button id="tab-login" onclick="tampilTab('login')"
                        class="flex-1 py-3 text-sm font-semibold transition rounded-tl-2xl <?= $tab_aktif==='login' ? 'tab-aktif' : 'tab-nonaktif' ?>">
                        🔑 Masuk
                    </button>
                    <button id="tab-register" onclick="tampilTab('register')"
                        class="flex-1 py-3 text-sm font-semibold transition rounded-tr-2xl <?= $tab_aktif==='register' ? 'tab-aktif' : 'tab-nonaktif' ?>">
                        📝 Daftar Akun
                    </button>
                </div>

                <!-- ════ PANEL LOGIN ════ -->
                <div id="panel-login" class="panel <?= $tab_aktif==='login' ? 'aktif' : '' ?> p-6">
                    <h2 class="text-lg font-bold mb-4" style="color:#1b5e20;">Masuk ke Sistem</h2>

                    <!-- FORM pakai method POST ke proseslogin.php -->
                    <form action="proseslogin.php" method="POST">

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                            <input type="text" name="username" placeholder="Masukkan username"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm transition" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <div class="relative">
                                <input type="password" id="login-pass" name="password"
                                    placeholder="Masukkan password"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm pr-10 transition" required>
                                <button type="button" onclick="togglePassword('login-pass', this)"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">👁</button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mb-5">
                            <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                                <input type="checkbox" name="remember"> Ingat saya
                            </label>
                            <a href="#" class="text-sm hover:underline" style="color:#2e7d32;">Lupa password?</a>
                        </div>

                        <button type="submit" name="login"
                            class="w-full text-white font-semibold py-2.5 rounded-lg transition text-sm"
                            style="background-color:#2e7d32;"
                            onmouseover="this.style.backgroundColor='#1b5e20'"
                            onmouseout="this.style.backgroundColor='#2e7d32'">
                            Masuk ke Sistem
                        </button>
                    </form>

                    <p class="text-center text-sm text-gray-500 mt-4">
                        Belum punya akun?
                        <button onclick="tampilTab('register')" class="font-semibold hover:underline" style="color:#2e7d32;">Daftar sekarang</button>
                    </p>
                </div>

                <!-- ════ PANEL REGISTER ════ -->
                <div id="panel-register" class="panel <?= $tab_aktif==='register' ? 'aktif' : '' ?> p-6">
                    <h2 class="text-lg font-bold mb-4" style="color:#1b5e20;">Buat Akun Baru</h2>

                    <!-- FORM pakai method POST ke prosesregistrasi.php -->
                    <form action="prosesregistrasi.php" method="POST" id="regForm">

                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                            <input type="text" name="username" placeholder="Buat username unik"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm transition" required>
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" placeholder="contoh@email.com"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm transition" required>
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <div class="relative">
                                <input type="password" id="reg-pass" name="password"
                                    placeholder="Min. 6 karakter"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm pr-10 transition"
                                    oninput="cekKekuatan(this.value)" required>
                                <button type="button" onclick="togglePassword('reg-pass', this)"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">👁</button>
                            </div>
                            <div class="mt-1.5 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                <div id="strength-bar" class="h-full w-0 rounded-full transition-all duration-300"></div>
                            </div>
                            <p id="strength-label" class="text-xs text-gray-400 mt-0.5"></p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                            <input type="password" id="reg-konfirm" name="konfirm"
                                placeholder="Ulangi password"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm transition" required>
                            <p id="match-hint" class="text-xs mt-0.5"></p>
                        </div>

                        <?php if (isset($_GET['tab']) && $_GET['tab'] === 'register' && isset($_GET['reg_error'])): ?>
                        <?php
                            $re = '';
                            switch ($_GET['reg_error']) {
                                case 'kosong':   $re = 'Mohon lengkapi semua kolom.'; break;
                                case 'duplikat': $re = 'Username atau email sudah digunakan.'; break;
                                case 'beda':     $re = 'Password dan konfirmasi tidak cocok.'; break;
                                case 'pendek':   $re = 'Password minimal 6 karakter.'; break;
                                case 'gagal':    $re = 'Gagal mendaftar, coba lagi.'; break;
                            }
                        ?>
                        <div class="mb-3 p-3 rounded-lg text-sm text-center bg-red-50 border border-red-400 text-red-800"><?= $re ?></div>
                        <?php endif; ?>

                        <button type="submit" name="register"
                            class="w-full text-white font-semibold py-2.5 rounded-lg transition text-sm"
                            style="background-color:#2e7d32;"
                            onmouseover="this.style.backgroundColor='#1b5e20'"
                            onmouseout="this.style.backgroundColor='#2e7d32'">
                            Daftar Sekarang
                        </button>
                    </form>

                    <p class="text-center text-sm text-gray-500 mt-4">
                        Sudah punya akun?
                        <button onclick="tampilTab('login')" class="font-semibold hover:underline" style="color:#2e7d32;">Masuk di sini</button>
                    </p>
                </div>

            </div>
        </div>
    </main>

    <footer class="text-center text-xs py-3 text-green-100" style="background-color:#1b5e20;">
        © 2026 SM Irigasi — Universitas Sebelas Maret · Sistem Monitoring Irigasi Sawah
    </footer>

    <script>
        function tampilTab(tab) {
            document.getElementById('panel-login').classList.toggle('aktif', tab === 'login');
            document.getElementById('panel-register').classList.toggle('aktif', tab === 'register');
            document.getElementById('tab-login').className    = 'flex-1 py-3 text-sm font-semibold transition rounded-tl-2xl ' + (tab === 'login' ? 'tab-aktif' : 'tab-nonaktif');
            document.getElementById('tab-register').className = 'flex-1 py-3 text-sm font-semibold transition rounded-tr-2xl ' + (tab === 'register' ? 'tab-aktif' : 'tab-nonaktif');
        }
        function togglePassword(id, btn) {
            var el = document.getElementById(id);
            el.type = el.type === 'password' ? 'text' : 'password';
            btn.textContent = el.type === 'password' ? '👁' : '🙈';
        }
        function cekKekuatan(pass) {
            var skor = 0;
            if (pass.length >= 6)          skor++;
            if (/[A-Z]/.test(pass))        skor++;
            if (/[0-9]/.test(pass))        skor++;
            if (/[^A-Za-z0-9]/.test(pass)) skor++;
            var warna = ['','bg-red-500','bg-orange-400','bg-yellow-400','bg-green-500'];
            var level = ['','Sangat Lemah 😟','Lemah 😐','Sedang 🙂','Kuat 💪'];
            var lebar = ['0%','25%','50%','75%','100%'];
            var bar   = document.getElementById('strength-bar');
            bar.className   = 'h-full rounded-full transition-all duration-300 ' + (warna[skor]||'');
            bar.style.width = lebar[skor]||'0%';
            document.getElementById('strength-label').textContent = pass.length ? (level[skor]||'') : '';
        }
        document.getElementById('reg-konfirm').addEventListener('input', function() {
            var pw   = document.getElementById('reg-pass').value;
            var hint = document.getElementById('match-hint');
            if (!this.value) { hint.textContent = ''; return; }
            if (this.value === pw) {
                hint.textContent = '✅ Password cocok';
                hint.style.color = '#16a34a';
            } else {
                hint.textContent = '❌ Belum cocok';
                hint.style.color = '#dc2626';
            }
        });
        document.getElementById('regForm').addEventListener('submit', function(e) {
            if (document.getElementById('reg-pass').value !== document.getElementById('reg-konfirm').value) {
                e.preventDefault();
                alert('Password dan konfirmasi tidak cocok!');
            }
        });
    </script>
</body>
</html>