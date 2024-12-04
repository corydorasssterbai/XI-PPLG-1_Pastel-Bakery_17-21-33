<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pastel Bakery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        
        @tailwind base;
        @tailwind components;
        @tailwind utilities;

        /* Custom Tailwind theme */
        :root {
            --pinktua: #f3c8b7;
            --pink: #dd9696;
        }
    </style>
</head>
<!-- Memanggil Vite CSS -->
@vite('resources/css/app.css')

<body class="font-poppins bg-white text-gray-900">
   <!-- Header -->
<header class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-10 py-5 bg-white shadow-md">
    <a href="#" class="text-2xl font-bold text-black">Pastel <span class="text-red-200">Bakery</span></a>
    <nav class="flex space-x-5">
        <a href="#home" class="text-lg text-black hover:text-[var(--pinktua)]">Home</a>
        <a href="#about" class="text-lg text-black hover:text-[var(--pinktua)]">About</a>
        <a href="#product" class="text-lg text-black hover:text-[var(--pinktua)]">Product</a>
        <a href="#footer" class="text-lg text-black hover:text-[var(--pinktua)]">Contact</a>
       <!-- User Icon -->
<button onclick="toggleAuthModal('login')" class="flex items-center text-black hover:text-[var(--pinktua)]">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 19.071a1 1 0 001.415 0L12 13.707l5.464 5.364a1 1 0 101.415-1.414l-5.657-5.657a2 2 0 00-2.828 0l-5.657 5.657a1 1 0 000 1.414z" />
        <circle cx="12" cy="8" r="4" />
    </svg>
    <span onclick="toggleAuthModal('login')" class="ml-2 text-lg">User</span>
</button>
</nav>
</header>

<!-- Login/Register Modal -->
<div id="authModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-md">
        <!-- Modal Header -->
        <div class="flex justify-between items-center px-4 py-2 border-b">
            <h3 id="modalTitle" class="text-2xl font-bold">Login</h3>
            <button onclick="toggleAuthModal()" class="text-gray-600 hover:text-red-500 text-2xl">&times;</button>
        </div>
        <!-- Modal Body -->
        <div class="p-6">
            <!-- Login Form -->
            <form id="loginForm" class="hidden">
                <label for="loginEmail" class="block mb-2 text-lg font-semibold">Email</label>
                <input id="loginEmail" type="email" placeholder="Enter your email" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-200" required>
                
                <label for="loginPassword" class="block mb-2 text-lg font-semibold">Password</label>
                <input id="loginPassword" type="password" placeholder="Enter your password" class="w-full px-4 py-2 mb-6 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-200" required>
                
                <button type="submit" class="w-full px-4 py-2 text-white bg-red-400 rounded-lg hover:bg-red-600">Login</button>
                
                <!-- Register Prompt -->
                <p class="mt-4 text-center text-gray-600">
                    Don't have an account? <span onclick="toggleAuthModal('register')" class="text-red-400 hover:underline cursor-pointer">Register Now</span>
                </p>
            </form>
            
            <!-- Register Form -->
            <form id="registerForm" action="{{ route('register.process') }}" method="POST" class="space-y-4">
            @csrf
            <label for="registerName" class="block mb-2 text-lg font-semibold">Name</label>
            <input id="registerName" name="name" type="text" placeholder="Enter your name"
                class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-200" required>
            
            <label for="registerEmail" class="block mb-2 text-lg font-semibold">Email</label>
            <input id="registerEmail" name="email" type="email" placeholder="Enter your email"
                class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-200" required>
            
            <label for="registerPassword" class="block mb-2 text-lg font-semibold">Password</label>
            <input id="registerPassword" name="password" type="password" placeholder="at least password 8 character"
                class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-200" required>
            
            <label for="registerPasswordConfirmation" class="block mb-2 text-lg font-semibold">Confirm Password</label>
            <input id="registerPasswordConfirmation" name="password_confirmation" type="password" placeholder="Confirm your password"
                class="w-full px-4 py-2 mb-6 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-200" required>

            <button type="submit" class="w-full px-4 py-2 text-white bg-red-400 rounded-lg hover:bg-red-600">Create</button>

            <p class="mt-4 text-center text-gray-600">
                Already have an account? <a href="#" onclick="toggleAuthModal('login')" class="text-red-400 hover:underline cursor-pointer">Login</a>
            </p>
        </form>

        </div>
    </div>
</div>

<script>
    document.getElementById('registerForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        // Ambil data dari form
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        try {
            const response = await fetch('/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify(data),
            });

            if (response.ok) {
                const result = await response.json();
                alert(result.message); // Tampilkan pesan sukses
                toggleAuthModal('login')
            } else {
                // Jika respons bukan JSON, coba lihat isi sebenarnya
                const errorText = await response.text();
                console.error('Server Error:', errorText); // Debug respons HTML
                alert('An error occurred. Please check console for details.');
            }
        } catch (err) {
            console.error('Fetch Error:', err);
            alert('Failed to process the request.');
        }

    });

    // Toggle Login/Register Modal
    function toggleAuthModal(type = null) {
    const modal = document.getElementById('authModal'); // Modal utama
    const loginForm = document.getElementById('loginForm'); // Form login
    const registerForm = document.getElementById('registerForm'); // Form register
    const modalTitle = document.getElementById('modalTitle'); // Judul modal

    if (type === 'login') {
        // Tampilkan form login, sembunyikan form register
        loginForm.classList.remove('hidden');
        registerForm.classList.add('hidden');
        modalTitle.textContent = 'Login';
    } else if (type === 'register') {
        // Tampilkan form register, sembunyikan form login
        loginForm.classList.add('hidden');
        registerForm.classList.remove('hidden');
        modalTitle.textContent = 'Register';
    }

    // Tampilkan modal jika belum terlihat
    modal.classList.remove('hidden');
}

</script>



    <!-- Home Section -->
    <section id="home" class="flex items-center justify-between min-h-screen px-10 bg-cover bg-center" style="bg-slate-100">
        <div class="flex-1">
            <h3 class="text-6xl font-bold">
                Pastel <span class="text-red-200">Bakery</span>
            </h3>
            <p class="mt-4 text-lg">
                Pastel Bakery offers a delightful selection of freshly baked pastries and cakes, crafted with care and
                high-quality ingredients. Whether for special occasions or everyday treats, we bring a touch of sweetness to
                your life.
            </p>
        </div>
        <div class="flex-1">
            <img src="/Aset image/cupcake 3.png" alt="Example Image" class="w-200 h-200" >
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-red-200 text-white">
        <div class="container mx-auto">
            <h1 class="mb-8 text-4xl font-bold text-center">About <span class="text-black">Us</span></h1>
            <div class="flex flex-wrap items-center gap-8">
                <div class="flex-1">
                    <img src="/Aset image/Hitam dan Putih Gading Minimal Elegan Menu Kue Mancanegara Tiramisu Instagram Square Post (5) 1.png" alt="About Image" class="rounded-lg">
                </div>
                <div class="flex-1 text-lg">
                    <h3 class="mb-4 text-3xl font-semibold">Welcome at Pastel Bakery!</h3>
                    <p>
                        At Pastel Bakery, we are passionate about creating delicious, high-quality baked goods that bring joy
                        to every occasion. Whether it’s a small treat or a custom cake for a special celebration, we take pride
                        in making each creation with love and care.
                    </p>
                </div>
            </div>
        </div>
    </section>

   <!-- Product Section -->
<section id="product" class="py-16 bg-white">
    <div class="container mx-auto">
        <h1 class="mb-8 text-4xl font-bold text-center">Our <span class="text-red-200">Products</span></h1>
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Product Cards -->
            @foreach ($product as $produk)
            <div class="p-4 border rounded-lg shadow hover:shadow-lg cursor-pointer" onclick="openModal('Tiramisu', 'Creamy and rich tiramisu with layers of coffee-soaked sponge and mascarpone cream. Perfect for coffee lovers!', 50000, '/Aset image/tiramisu.png')">
            <img src="{{ Storage::url($produk->image) }}" alt="{{ $produk->title }}" class="w-full rounded-lg">
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Modal Overlay -->
<div id="productModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-3xl">
        <!-- Modal Header -->
        <div class="flex justify-between items-center px-4 py-2 border-b">
            <h3 id="modalTitle" class="text-2xl font-bold">Product Title</h3>
            <button onclick="closeModal()" class="text-gray-600 hover:text-red-500 text-2xl">&times;</button>
        </div>
        <!-- Modal Body -->
        <div class="p-4 flex flex-col sm:flex-row">
            <!-- Product Image -->
            <img id="modalImage" src="" alt="Product Image" class="w-full sm:w-1/2 rounded-lg mb-4 sm:mb-0 sm:mr-4">
            <!-- Product Details -->
            <div>
                <p id="modalDescription" class="text-lg mb-4">Product description here...</p>
                <p id="modalPrice" class="text-lg font-semibold text-red-400 mb-4">Price: IDR 0</p>
                <!-- Button Actions -->
                <button id="buyNowButton" class="px-6 py-2 text-white bg-red-400 rounded-lg hover:bg-red-200">Buy Now</button>
            </div>
        </div>
        <!-- Modal Footer -->
        <div class="flex justify-end px-4 py-2 border-t">
            <button class="px-4 py-2 text-white bg-gray-500 rounded-lg hover:bg-gray-600" onclick="closeModal()">Close</button>
        </div>
    </div>
</div>

<script>
    // Open modal with product details
    function openModal(title, description, price, imageSrc) {
        document.getElementById('modalTitle').innerText = title;
        document.getElementById('modalDescription').innerText = description;
        document.getElementById('modalPrice').innerText = 'Price: IDR ' + price.toLocaleString();
        document.getElementById('modalImage').src = imageSrc;
        // Update WhatsApp link dynamically
        const waMessage = `Halo, saya tertarik membeli ${title}. Apakah tersedia? Harganya IDR ${price.toLocaleString()}.`;
        document.getElementById('buyNowButton').onclick = function() {
            window.open(`https://wa.me/6282138801353?text=${encodeURIComponent(waMessage)}`, '_blank');
        };
        document.getElementById('productModal').classList.remove('hidden');
    }

    // Close modal
    function closeModal() {
        document.getElementById('productModal').classList.add('hidden');
    }
</script>


     <!-- Footer -->
     <footer id="footer" class="py-12 bg-red-200 text-white">
        <div class="container mx-auto flex flex-col md:flex-row gap-12">
            <!-- Get in Touch Section -->
            <div class="flex-1">
                <h3 class="mb-6 text-3xl font-bold">Get in Touch</h3>
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="text" name="name" placeholder="Your Name"
                        class="w-full px-4 py-2 border rounded-md text-gray-800 focus:outline-none focus:ring-2 focus:ring-[var(--pinktua)]">
                    <input type="email" name="email" placeholder="Your Email"
                        class="w-full px-4 py-2 border rounded-md text-gray-800 focus:outline-none focus:ring-2 focus:ring-[var(--pinktua)]">
                    <textarea name="message" placeholder="Your Message" rows="4"
                        class="w-full px-4 py-2 border rounded-md text-gray-800 focus:outline-none focus:ring-2 focus:ring-[var(--pinktua)]"></textarea>
                    <button type="submit"
                        class="w-full px-4 py-2 text-white bg-red-400 rounded-md hover:bg-[var(--pink)] focus:ring-2 focus:ring-[var(--pink)]">
                        Send Message
                    </button>
                </form>

            </div>

            <!-- Location Section -->
            <div class="flex-1">
                <h3 class="mb-6 text-3xl font-bold">Our Location</h3>
                <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden shadow-md">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d64432.19891484285!2d109.22128143713951!3d-7.4561084716593635!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e655e9d1768e4d1%3A0x959269c10818fa0c!2sSMK%20Telkom%20Purwokerto!5e0!3m2!1sen!2sid!4v1733199182606!5m2!1sen!2sid"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
                <p class="mt-4 text-lg">
                    Jl. DI Panjaitan No.128, Purwokerto, Indonesia <br>
                    Phone: +62 123-4567-890 <br>
                    Email: PastelBakery@gmail.com
                </p>
            </div>
        </div>
        <div class="mt-12 text-center text-sm text-white-200">
            &copy; 2024 Pastel Bakery. All rights reserved.
        </div>
    </footer>
</body>

</html>