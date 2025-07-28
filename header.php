<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect"/>
<link as="style" href="https://fonts.googleapis.com/css2?display=swap&amp;family=Newsreader%3Awght%40400%3B500%3B600%3B700&amp;family=Noto+Sans%3Awght%40400%3B500%3B700" onload="this.rel='stylesheet'" rel="stylesheet"/>
<title>NewsToday - Haber Sitesi</title>
<link href="data:image/x-icon;base64," rel="icon" type="image/x-icon"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-background-color text-primary-color">
<div class="flex size-full min-h-screen flex-col overflow-x-hidden">
<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-sm border-b border-gray-200">
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex h-20 items-center justify-between">
        <div class="flex items-center gap-10">
            <a class="flex items-center gap-3 text-primary-color" href="index.php">
                <svg class="h-8 w-8 text-indigo-600" fill="currentColor" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                    <path d="M44 4H30.6666V17.3334H17.3334V30.6666H4V44H44V4Z" fill="currentColor"></path>
                </svg>
                <h1 class="text-2xl font-bold tracking-tight">NewsToday</h1>
            </a>
            <nav class="hidden md:flex items-center gap-8">
                <a class="nav-link" href="index.php">Ana Sayfa</a>
                <a class="nav-link" href="katagori.php">Teknoloji</a>
                <a class="nav-link" href="katagori.php">Ekonomi</a>
                <a class="nav-link" href="katagori.php">Siyaset</a>
                <a class="nav-link" href="hakkımızda.php">Hakkımızda</a>
            </nav>
        </div>
        <div class="flex items-center gap-2">
            <!-- Desktop Search and Buttons -->
            <div class="hidden md:flex items-center gap-2">
                <label class="relative">
                    <span class="sr-only">Ara</span>
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="size-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    </span>
                    <input class="form-input block w-full rounded-full border-gray-300 bg-transparent py-2 pl-10 pr-3 text-primary-color placeholder:text-gray-400 focus:border-primary-color focus:ring-primary-color sm:text-sm" placeholder="Ara..." type="search"/>
                </label>
                <button class="hidden md:inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Abone Ol</button>
            </div>
            <!-- Mobile Menu Button -->
            <button id="mobile-menu-button" class="icon-button md:hidden">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 6h16M4 12h16m-7 6h7" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </button>
        </div>
    </div>
    <!-- Mobile Menu, hidden by default -->
    <div id="mobile-menu" class="hidden md:hidden">
        <nav class="pt-2 pb-4 space-y-1">
            <a class="nav-link block px-3 py-2 rounded-md" href="index.php">Ana Sayfa</a>
            <a class="nav-link block px-3 py-2 rounded-md" href="katagori.php">Teknoloji</a>
            <a class="nav-link block px-3 py-2 rounded-md" href="katagori.php">Ekonomi</a>
            <a class="nav-link block px-3 py-2 rounded-md" href="katagori.php">Siyaset</a>
            <a class="nav-link block px-3 py-2 rounded-md" href="hakkımızda.php">Hakkımızda</a>
             <a class="nav-link block px-3 py-2 rounded-md" href="iletisim.php">İletişim</a>
        </nav>
    </div>
</div>
</header>

<script>
    const menuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    menuButton.addEventListener('click', () => {
        const isExpanded = menuButton.getAttribute('aria-expanded') === 'true';
        menuButton.setAttribute('aria-expanded', !isExpanded);
        mobileMenu.classList.toggle('hidden');
    });
</script>