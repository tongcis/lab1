<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon" />
    <title>Laboratorium FST UPY | Daftar</title>
    <!-- CSS files -->
    <link href="./dist/css/tabler.min.css?1684106062" rel="stylesheet" />
    <link href="./dist/css/tabler-flags.min.css?1684106062" rel="stylesheet" />
    <link href="./dist/css/tabler-payments.min.css?1684106062" rel="stylesheet" />
    <link href="./dist/css/tabler-vendors.min.css?1684106062" rel="stylesheet" />
    <link href="./dist/css/demo.min.css?1684106062" rel="stylesheet" />
    @vite([])
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body class=" d-flex flex-column">
    <script src="./dist/js/demo-theme.min.js?1684106062"></script>
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <a href="." class="navbar-brand navbar-brand-autodark"><img src="{{ asset('images/logo.png') }}"
                        height="50" alt=""></a>
                <h1>Laboratorium FST UPY</h1>
            </div>
            <form class="card card-md" action="{{ route('register') }}" method="POST" autocomplete="off" novalidate
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Daftarkan diri anda</h2>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" id="name" name="name"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama anda"
                            value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIK</label>
                        <input type="number" id="nik" name="nik"
                            class="form-control @error('nik') is-invalid @enderror" placeholder="Masukkan NIK anda"
                            value="{{ old('nik') }}">
                        @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor KK</label>
                        <input type="number" id="kk_number" name="kk_number"
                            class="form-control @error('kk_number') is-invalid @enderror"
                            placeholder="Masukkan nomor KK anda" value="{{ old('kk_number') }}">
                        @error('kk_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" id="date_of_birth" name="date_of_birth"
                            class="form-control @error('date_of_birth') is-invalid @enderror"
                            placeholder="Masukkan tanggal lahir anda" value="{{ old('date_of_birth') }}">
                        @error('date_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" id="address" name="address"
                            class="form-control @error('address') is-invalid @enderror"
                            placeholder="Masukkan alamat anda" value="{{ old('address') }}">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Agama</label>
                        <select name="religion" id="religion"
                            class="form-select text-center @error('religion') is-invalid @enderror">
                            <option value="" selected disabled>-- Pilih Agama --</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen Protestan">Kristen Protestan</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Kong Hu Cu">Kong Hu Cu</option>
                        </select>
                        @error('religion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Pernikahan</label>
                        <select name="marital_status" id="marital_status"
                            class="form-select text-center @error('marital_status') is-invalid @enderror">
                            <option value="" selected disabled>-- Pilih Status Pernikahan --</option>
                            <option value="Belum Menikah">Belum Menikah</option>
                            <option value="Menikah">Menikah</option>
                            <option value="Bercerai">Bercerai</option>
                        </select>
                        @error('marital_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Email</label>
                        <input type="email" id="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Masukkan email anda" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="number" id="phone" name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            placeholder="Masukkan telepon anda" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Passport <span class="text-danger fs-5">(Gambar/PDF)</span></label>
                        <input type="file" id="passport_url" name="passport_url"
                            class="form-control @error('passport_url') is-invalid @enderror"
                            placeholder="Masukkan telepon anda" value="{{ old('passport_url') }}">
                        @error('passport_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto <span class="text-danger fs-5">(Foto dengan latar
                                putih)</span></label>
                        <input type="file" id="photo_url" name="photo_url"
                            class="form-control @error('photo_url') is-invalid @enderror"
                            placeholder="Masukkan telepon anda" value="{{ old('photo_url') }}">
                        @error('photo_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Istri/Wali</label>
                        <input type="text" id="guardian_name" name="guardian_name"
                            class="form-control @error('guardian_name') is-invalid @enderror"
                            placeholder="Masukkan nama istri/wali anda" value="{{ old('guardian_name') }}">
                        @error('guardian_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Istri/Wali</label>
                        <input type="text" id="guardian_address" name="guardian_address"
                            class="form-control @error('guardian_address') is-invalid @enderror"
                            placeholder="Masukkan alamat istri/wali anda" value="{{ old('guardian_address') }}">
                        @error('guardian_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group input-group-flat">
                            <input type="password" id="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" autocomplete="off"
                                placeholder="Masukkan password anda">
                            <span class="input-group-text">
                                <a id="show-password" href="#" class="link-secondary" title="Show password"
                                    data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path
                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg>
                                </a>
                            </span>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <div class="input-group input-group-flat">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control" autocomplete="off"
                                placeholder="Masukkan konfirmasi password anda">
                            <span class="input-group-text">
                                <a id="show-password-confirmation" href="#" class="link-secondary"
                                    title="Show password"
                                    data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path
                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg>
                                </a>
                            </span>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Daftar</button>
                    </div>
                </div>
            </form>
            <div class="text-center text-muted mt-3">
                Sudah memiliki akun? <a href="{{ route('login') }}" tabindex="-1">Masuk</a>
            </div>
        </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js?1684106062" defer></script>
    <script src="./dist/js/demo.min.js?1684106062" defer></script>
    <script>
        document.getElementById('show-password').addEventListener('click', function() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        })
        document.getElementById('show-password-confirmation').addEventListener('click', function() {
            var x = document.getElementById("password_confirmation");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        })
    </script>
</body>

</html>
