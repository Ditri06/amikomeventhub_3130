<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daftar Partner - AmikomEventHub</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-50 flex items-center justify-center p-6">

    <div class="w-full max-w-lg">

        {{-- Logo --}}
        <div class="text-center mb-8">

            <div class="w-16 h-16 bg-indigo-600 rounded-2xl
                        flex items-center justify-center
                        text-white font-black text-2xl
                        mx-auto mb-4 shadow-lg">
                AH
            </div>

            <h1 class="text-3xl font-black text-slate-800">
                Daftar sebagai Partner
            </h1>

            <p class="text-slate-500 mt-2">
                Daftarkan organisasi atau kepanitiaan Anda
                untuk mengelola event di AmikomEventHub.
            </p>

        </div>


        {{-- Form Registrasi --}}
        <div class="bg-white rounded-[2rem]
                    border border-slate-100
                    shadow-sm p-8">

            <form
                action="{{ route('register.store') }}"
                method="POST"
                class="space-y-6"
            >

                @csrf


                {{-- Nama Organisasi --}}
                <div>

                    <label
                        for="name"
                        class="block text-sm font-bold text-slate-700 mb-2"
                    >
                        Nama Organisasi / Kepanitiaan
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Contoh: HIMA Sistem Informasi"
                        class="w-full px-4 py-3 rounded-xl
                               border border-slate-200
                               focus:outline-none
                               focus:ring-2
                               focus:ring-indigo-500"
                        required
                    >

                    @error('name')
                        <p class="text-sm text-red-500 mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Email --}}
                <div>

                    <label
                        for="email"
                        class="block text-sm font-bold text-slate-700 mb-2"
                    >
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="contoh@email.com"
                        class="w-full px-4 py-3 rounded-xl
                               border border-slate-200
                               focus:outline-none
                               focus:ring-2
                               focus:ring-indigo-500"
                        required
                    >

                    @error('email')
                        <p class="text-sm text-red-500 mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Password --}}
                <div>

                    <label
                        for="password"
                        class="block text-sm font-bold text-slate-700 mb-2"
                    >
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        class="w-full px-4 py-3 rounded-xl
                               border border-slate-200
                               focus:outline-none
                               focus:ring-2
                               focus:ring-indigo-500"
                        required
                    >

                    @error('password')
                        <p class="text-sm text-red-500 mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Konfirmasi Password --}}
                <div>

                    <label
                        for="password_confirmation"
                        class="block text-sm font-bold text-slate-700 mb-2"
                    >
                        Konfirmasi Password
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Ulangi password"
                        class="w-full px-4 py-3 rounded-xl
                               border border-slate-200
                               focus:outline-none
                               focus:ring-2
                               focus:ring-indigo-500"
                        required
                    >

                </div>


                {{-- Tombol Daftar --}}
                <button
                    type="submit"
                    class="w-full py-4
                           bg-indigo-600
                           text-white
                           rounded-xl
                           font-bold
                           hover:bg-indigo-700
                           transition"
                >
                    Daftar sebagai Partner
                </button>

            </form>


            {{-- Link Login --}}
            <div class="text-center mt-6">

                <p class="text-sm text-slate-500">
                    Sudah memiliki akun?

                    <a
                        href="{{ route('admin.login') }}"
                        class="text-indigo-600 font-bold hover:underline"
                    >
                        Login
                    </a>
                </p>

            </div>

        </div>


        {{-- Informasi --}}
        <div class="mt-6 p-4
                    bg-indigo-50
                    border border-indigo-100
                    rounded-2xl">

            <p class="text-sm text-indigo-700 text-center">
                Setelah mendaftar, akun Anda akan diperiksa oleh Admin.
                Anda dapat mengakses Dashboard Partner setelah pendaftaran
                disetujui.
            </p>

        </div>

    </div>

</body>

</html>
