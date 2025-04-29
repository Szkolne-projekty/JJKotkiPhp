<?php

$isLoggedIn = Utils::isLoggedIn();

$redirectTo = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

?>

<!-- Header opiera się o przykład z daisyUI (https://daisyui.com/components/navbar/#responsive-dropdown-menu-on-small-screen-center-menu-on-large-screen) -->
<div class="drawer z-20">
    <input id="nav-drawer" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content flex flex-col">
        <!-- Navbar -->
        <div class="navbar bg-base-300 w-fullpx-8 md:px-20">
            <div class="flex-none md:hidden">
                <label for="nav-drawer" aria-label="open sidebar" class="btn btn-square btn-ghost">
                    <!-- Ikona menu -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        class="inline-block h-6 w-6 stroke-current">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </label>
            </div>
            <div class="mx-2 flex-1 text-2xl md:text-3xl font-bold"><a href="/">Kotki</a></div>
            <div class="hidden flex-none md:block">
                <ul class="menu menu-horizontal">
                    <!-- Zawartość navbaru -->
                    <li><a href="/facts">Ciekawostki</a></li>
                    <li><a href="/blog">Blog</a></li>
                    <li><a href="/photos">Zdjęcia</a></li>
                    <?php if (!$isLoggedIn): ?>
                        <li><a href="/login?redirectTo=<?= $redirectTo ?>">Zaloguj się</a></li>
                    <?php else: ?>
                        <li><a href="/profile">Profil</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="drawer-side z-20">
        <!-- Sidebar -->
        <label for="nav-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
        <div class="h-full flex  bg-base-200  flex-col justify-between">
            <ul class="menu w-80 p-4">
                <!-- Zawartość sidebaru -->
                <li><a href="/facts">Ciekawostki</a></li>
                <li><a href="/blog">Blog</a></li>
                <li><a href="/photos">Zdjęcia</a></li>
            </ul>
            <?php if (!$isLoggedIn): ?>
                <div class="p-4">
                    <a href="/login?redirectTo=<?= $redirectTo ?>" class="btn btn-block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        Zaloguj się
                    </a>
                </div>
            <?php else: ?>
                <div class="p-4">
                    <a href="/profile" class="btn btn-block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        Profil
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>