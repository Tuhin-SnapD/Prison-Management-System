<?php
/**
 * Unified Header Template
 * 
 * Dynamic navigation based on user authentication status and role
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize Auth class for navigation
require_once SRC_PATH . '/includes/auth/Auth.php';
require_once SRC_PATH . '/includes/database/dbh.inc.php';

$auth = new Auth($pdo);
$currentUser = $auth->getCurrentUser();

// Navigation configuration
$navigationConfig = [
    'guest' => [
        'items' => [
            ['url' => 'home', 'text' => 'About Us', 'icon' => 'info'],
            ['url' => 'signin-admin', 'text' => 'Admin Login', 'icon' => 'user-shield'],
            ['url' => 'signin-officer', 'text' => 'Officer Login', 'icon' => 'user-tie'],
            ['url' => 'signin-jailor', 'text' => 'Jailor Login', 'icon' => 'user-cog']
        ]
    ],
    'admin' => [
        'items' => [
            ['url' => 'admin', 'text' => 'Admin Dashboard', 'icon' => 'tachometer-alt'],
            ['url' => 'visitor', 'text' => 'Add Visitor', 'icon' => 'user-plus'],
            ['url' => 'officer', 'text' => 'Add Officer', 'icon' => 'user-tie'],
            ['url' => 'jailor', 'text' => 'Add Jailor', 'icon' => 'user-cog'],
            ['url' => 'home', 'text' => 'About Us', 'icon' => 'info'],
            ['url' => 'logout&type=admin', 'text' => 'Logout', 'icon' => 'sign-out-alt', 'class' => 'text-red-600']
        ]
    ],
    'officer' => [
        'items' => [
            ['url' => 'officer-dashboard', 'text' => 'Officer Dashboard', 'icon' => 'tachometer-alt'],
            ['url' => 'crime', 'text' => 'Add Crime', 'icon' => 'gavel'],
            ['url' => 'crime_view', 'text' => 'View Crimes', 'icon' => 'list'],
            ['url' => 'ipc_view', 'text' => 'IPC Codes', 'icon' => 'code'],
            ['url' => 'home', 'text' => 'About Us', 'icon' => 'info'],
            ['url' => 'logout&type=officer', 'text' => 'Logout', 'icon' => 'sign-out-alt', 'class' => 'text-red-600']
        ]
    ],
    'jailor' => [
        'items' => [
            ['url' => 'jailor-dashboard', 'text' => 'Jailor Dashboard', 'icon' => 'tachometer-alt'],
            ['url' => 'prisoner_view', 'text' => 'View Prisoners', 'icon' => 'users'],
            ['url' => 'section_view', 'text' => 'View Sections', 'icon' => 'building'],
            ['url' => 'home', 'text' => 'About Us', 'icon' => 'info'],
            ['url' => 'logout&type=jailor', 'text' => 'Logout', 'icon' => 'sign-out-alt', 'class' => 'text-red-600']
        ]
    ]
];

// Determine current navigation type
$navType = 'guest';
if ($currentUser) {
    $navType = $currentUser['type'];
}

$navItems = $navigationConfig[$navType]['items'] ?? $navigationConfig['guest']['items'];

// Helper function to get icon HTML
function getIconHtml($iconName) {
    $icons = [
        'tachometer-alt' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>',
        'user-shield' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>',
        'user-tie' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
        'user-cog' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>',
        'user-plus' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>',
        'gavel' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        'list' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>',
        'code' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>',
        'users' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg>',
        'building' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>',
        'info' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        'sign-out-alt' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>'
    ];
    
    return $icons[$iconName] ?? '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo defined('APP_NAME') ? APP_NAME : 'PMS'; ?></title>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet" />
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="antialiased flex flex-col min-h-screen bg-gray-50" x-data="{ isOpen: false }">
    
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="?page=home" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-gray-900"><?php echo defined('APP_NAME') ? APP_NAME : 'PMS'; ?></span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <?php foreach ($navItems as $item): ?>
                        <a href="?page=<?php echo $item['url']; ?>" 
                           class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 <?php echo $item['class'] ?? ''; ?>">
                            <?php echo getIconHtml($item['icon']); ?>
                            <span><?php echo $item['text']; ?></span>
                        </a>
                    <?php endforeach; ?>
                </nav>

                <!-- User Info (if logged in) -->
                <?php if ($currentUser): ?>
                    <div class="hidden md:flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="text-sm">
                                <p class="text-gray-900 font-medium"><?php echo ucfirst($currentUser['type']); ?></p>
                                <p class="text-gray-500"><?php echo $currentUser['username']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button @click="isOpen = !isOpen" 
                            class="text-gray-700 hover:text-indigo-600 focus:outline-none focus:text-indigo-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!isOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="isOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div x-show="isOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-1"
             class="md:hidden border-t border-gray-200">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-white">
                <?php foreach ($navItems as $item): ?>
                    <a href="?page=<?php echo $item['url']; ?>" 
                       class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 px-3 py-2 rounded-md text-base font-medium transition-colors duration-200 <?php echo $item['class'] ?? ''; ?>"
                       @click="isOpen = false">
                        <?php echo getIconHtml($item['icon']); ?>
                        <span><?php echo $item['text']; ?></span>
                    </a>
                <?php endforeach; ?>
                
                <?php if ($currentUser): ?>
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <div class="flex items-center space-x-2 px-3 py-2">
                            <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="text-sm">
                                <p class="text-gray-900 font-medium"><?php echo ucfirst($currentUser['type']); ?></p>
                                <p class="text-gray-500"><?php echo $currentUser['username']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
