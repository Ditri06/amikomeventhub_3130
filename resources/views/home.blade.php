<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">


<nav class="bg-white shadow-md p-4 flex justify-between items-center">
    <h1 class="text-xl font-bold text-blue-600">AmikomEventHub</h1>
    
    <div class="space-x-3">
        <a href="/profil" class="text-gray-700 hover:text-blue-500">Profil</a>
        <a href="/katalog" class="text-gray-700 hover:text-blue-500">Katalog</a>
        <a href="/bantuan" class="text-gray-700 hover:text-blue-500">Bantuan</a>
    </div>
</nav>


<section class="text-center py-16 bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
    <h2 class="text-4xl font-bold mb-4">Selamat Datang di AmikomEventHub</h2>
    <p class="text-lg mb-6">Temukan berbagai event menarik di kampus dengan mudah</p>

    <a href="/katalog" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition">
        Lihat Event
    </a>
</section>


<section class="p-8">
    <h3 class="text-2xl font-bold text-center mb-6">Menu Utama</h3>

    <div class="grid md:grid-cols-3 gap-6">

     
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg hover:scale-105 transition text-center">
            <h4 class="text-xl font-semibold mb-2">Profil</h4>
            <p class="text-gray-600 mb-4">Lihat informasi data diri praktikan</p>
            <a href="/profil" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Buka
            </a>
        </div>

   
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg hover:scale-105 transition text-center">
            <h4 class="text-xl font-semibold mb-2">Katalog Event</h4>
            <p class="text-gray-600 mb-4">Jelajahi daftar event kampus</p>
            <a href="/katalog" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                Buka
            </a>
        </div>

      
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg hover:scale-105 transition text-center">
            <h4 class="text-xl font-semibold mb-2">Bantuan</h4>
            <p class="text-gray-600 mb-4">Lihat FAQ dan panduan penggunaan</p>
            <a href="/bantuan" class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600">
                Buka
            </a>
        </div>

    </div>
</section>


<footer class="bg-white text-center p-4 mt-10 shadow-inner">
    <p class="text-gray-500">© 2026 AmikomEventHub</p>
</footer>

</body>
</html>