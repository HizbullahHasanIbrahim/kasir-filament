<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Aplikasi Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center h-screen">
    <div class="bg-white shadow-2xl rounded-xl p-10 max-w-4xl text-center transform transition duration-500 hover:scale-105">
        <h1 class="text-5xl font-extrabold text-gray-800 mb-6 animate-pulse">🎉 Selamat Datang di Aplikasi Kasir 🎉</h1>
        <p class="text-gray-700 text-lg mb-6">Kelola transaksi dengan mudah dan cepat menggunakan sistem modern kami.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div class="bg-gradient-to-r from-yellow-400 to-red-500 p-6 rounded-xl shadow-lg transform transition hover:scale-110">
                <h2 class="text-2xl font-bold text-white">📊 Laporan Lengkap</h2>
                <p class="text-white mt-2">Analisis data penjualan secara real-time.</p>
            </div>
            <div class="bg-gradient-to-r from-green-400 to-blue-500 p-6 rounded-xl shadow-lg transform transition hover:scale-110">
                <h2 class="text-2xl font-bold text-white">💰 Manajemen Keuangan</h2>
                <p class="text-white mt-2">Pantau pemasukan dan pengeluaran bisnis Anda.</p>
            </div>
            <div class="bg-gradient-to-r from-purple-400 to-pink-500 p-6 rounded-xl shadow-lg transform transition hover:scale-110">
                <h2 class="text-2xl font-bold text-white">🛍️ Manajemen Produk</h2>
                <p class="text-white mt-2">Atur stok dan kategori produk dengan mudah.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-gradient-to-r from-cyan-400 to-blue-600 p-6 rounded-xl shadow-lg transform transition hover:scale-110">
                <h2 class="text-2xl font-bold text-white">📦 Kelola Stok</h2>
                <p class="text-white mt-2">Pantau stok barang secara akurat.</p>
            </div>
            <div class="bg-gradient-to-r from-orange-400 to-red-600 p-6 rounded-xl shadow-lg transform transition hover:scale-110">
                <h2 class="text-2xl font-bold text-white">💳 Pembayaran Mudah</h2>
                <p class="text-white mt-2">Dukung berbagai metode pembayaran digital.</p>
            </div>
        </div>

        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('filament.admin.auth.login') }}" class="admin-button bg-gradient-to-r from-green-400 to-blue-500 hover:from-green-500 hover:to-blue-600 text-white font-bold py-3 px-6 rounded-full shadow-lg transition-all duration-300 ease-in-out transform hover:scale-110">
                🚀 Login to Admin Panel
            </a>
            <a href="#" class="bg-gradient-to-r from-purple-400 to-pink-500 hover:from-purple-500 hover:to-pink-600 text-white font-bold py-3 px-6 rounded-full shadow-lg transition-all duration-300 ease-in-out transform hover:scale-110">
                📖 Pelajari Lebih Lanjut
            </a>
        </div>
    </div>
</body>
</html>
