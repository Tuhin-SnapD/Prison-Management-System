<?php 
require "../src/views/layouts/header_unified.php";
?>

<!-- Hero Section -->
<div class="min-h-screen relative bg-gradient-to-br from-indigo-900 via-purple-900 to-indigo-800">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    
    <!-- Content -->
    <div class="relative z-10 min-h-screen flex items-center justify-center">
        <div class="text-center text-white px-4 sm:px-8 lg:px-16 max-w-6xl mx-auto">
            <!-- Main Heading -->
            <div class="mb-8">
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold mb-6 tracking-tight text-gradient">
                    Prison Management System
                </h1>
                <div class="w-24 h-1 bg-indigo-400 mx-auto rounded-full mb-6"></div>
            </div>

            <!-- Subtitle -->
            <p class="text-xl md:text-2xl mb-12 text-gray-200 max-w-4xl mx-auto leading-relaxed">
                A comprehensive, secure, and modern management solution designed for correctional facilities. 
                Streamline operations, enhance security, and improve efficiency with our advanced system.
            </p>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Feature 1 -->
                <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-xl p-8 border border-white border-opacity-20 hover:bg-opacity-100 transition-all duration-300 transform hover:scale-105">
                    <div class="w-16 h-16 bg-indigo-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-black">Secure Access Control</h3>
                    <p class="text-black leading-relaxed">
                        Role-based authentication system ensuring secure access for administrators, officers, and jailors with comprehensive audit trails.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-xl p-8 border border-white border-opacity-20 hover:bg-opacity-100 transition-all duration-300 transform hover:scale-105">
                    <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-black">Comprehensive Records</h3>
                    <p class="text-black leading-relaxed">
                        Complete management of prisoner records, visitor logs, and facility operations with real-time data synchronization.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-xl p-8 border border-white border-opacity-20 hover:bg-opacity-100 transition-all duration-300 transform hover:scale-105">
                    <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-4 text-black">Real-time Updates</h3>
                    <p class="text-black leading-relaxed">
                        Instant notifications and live updates for all system activities, ensuring timely response to critical events.
                    </p>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-indigo-300 mb-2">100%</div>
                    <div class="text-gray-300 text-sm">Secure</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-purple-300 mb-2">24/7</div>
                    <div class="text-gray-300 text-sm">Available</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-blue-300 mb-2">Real-time</div>
                    <div class="text-gray-300 text-sm">Updates</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-bold text-green-300 mb-2">Easy</div>
                    <div class="text-gray-300 text-sm">Management</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- About Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-8 lg:px-16">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Why Choose Our System?</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Built with modern technology and security best practices to provide the most reliable prison management solution.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Benefit 1 -->
            <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Enhanced Security</h3>
                <p class="text-gray-600">
                    Advanced security protocols and encryption ensure your data remains protected at all times.
                </p>
            </div>

            <!-- Benefit 2 -->
            <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">High Performance</h3>
                <p class="text-gray-600">
                    Optimized for speed and efficiency, providing instant access to critical information when you need it most.
                </p>
            </div>

            <!-- Benefit 3 -->
            <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Mobile Friendly</h3>
                <p class="text-gray-600">
                    Responsive design works seamlessly across all devices, from desktop computers to mobile phones.
                </p>
            </div>
        </div>
    </div>
</section>

<?php
require "../src/views/layouts/footer.php";
?> 