<footer class="bg-gray-900 text-white">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div>
                <div class="text-2xl font-bold mb-4">
                    HAWK<span class="text-blue-600">PRINTS</span>
                </div>
                <p class="text-gray-400 mb-4">We may not be the cheaper in the market but best in quality.</p>
                <div class="flex gap-4">
                    <a href="#" class="text-gray-400 hover:text-blue-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047v-2.642c0-3.007 1.802-4.658 4.555-4.658 1.312 0 2.686.082 2.686.082v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.584.07-4.849.151-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.007 0-.014.001-.021.006-1.605 1.307-2.766 2.801-3.574 4.539-.391.942-.586 1.917-.586 2.926 0 .082.003.163.008.244.003-.002.006-.005.01-.007 2.446-1.433 4.147-3.626 4.168-3.684-.011-.055-.034-.113-.034-.181.001-.054.018-.106.019-.16.001-.015-.001-.03-.004-.044z"/></svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-blue-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.37-4.42 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-3.34V9.4a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.07z"/></svg>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">Let us help</h4>
                <ul class="space-y-2">
                    <li><a href="/contact" class="text-gray-400 hover:text-blue-600">My Account</a></li>
                    <li><a href="/about" class="text-gray-400 hover:text-blue-600">About Us</a></li>
                    <li><a href="/contact" class="text-gray-400 hover:text-blue-600">Contact Us</a></li>
                    <li><a href="/contact" class="text-gray-400 hover:text-blue-600">Privacy Policy</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">Our Company</h4>
                <ul class="space-y-2">
                    <li><a href="/contact" class="text-gray-400 hover:text-blue-600">Terms & Conditions</a></li>
                    <li><a href="/contact" class="text-gray-400 hover:text-blue-600">Annual Returns</a></li>
                    <li><a href="/contact" class="text-gray-400 hover:text-blue-600">Public Recognition</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">DON'T MISS A BEAT</h4>
                <p class="text-gray-400 mb-4">Join Our Newsletter Today!</p>
                <form action="/newsletter/subscribe" method="POST" class="flex flex-col gap-2">
                    @csrf
                    <input type="email" name="email" placeholder="Enter your email" class="px-4 py-2 bg-gray-800 border border-gray-700 rounded focus:outline-none focus:border-blue-600 text-white" required>
                    <button type="submit" class="px-4 py-2 bg-blue-700 hover:bg-blue-800 rounded font-semibold">Subscribe</button>
                </form>
                <p class="text-gray-500 text-sm mt-2">We don't spam! Read our privacy policy.</p>
            </div>
        </div>
    </div>

    <div class="bg-gray-950 py-4">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-gray-500 text-sm">Hawk Prints Inc. &copy; {{ date('Y') }} All rights reserved.</p>
            <div class="flex items-center gap-2">
                <img src="https://hawkprints.ca/wp-content/uploads/2023/01/visa.jpg" alt="Visa" class="h-8">
            </div>
        </div>
    </div>
</footer>