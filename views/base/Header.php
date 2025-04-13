<div class="drawer z-20">
    <input id="nav-drawer" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content flex flex-col">
        <!-- Navbar -->
        <div class="navbar bg-base-300 w-fullpx-8 md:px-20">
            <div class="flex-none lg:hidden">
                <label for="nav-drawer" aria-label="open sidebar" class="btn btn-square btn-ghost">
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
            <div class="hidden flex-none lg:block">
                <ul class="menu menu-horizontal">
                    <!-- Navbar menu content here -->
                    <li><a href="/facts">Ciekawostki</a></li>
                    <li><a href="/blog">Blog</a></li>
                    <li><a href="/photos">Zdjęcia</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="drawer-side z-20">
        <label for="nav-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
        <ul class="menu bg-base-200 min-h-full w-80 p-4">
            <!-- Sidebar content here -->
            <li><a href="/facts">Ciekawostki</a></li>
            <li><a href="/blog">Blog</a></li>
            <li><a href="/photos">Zdjęcia</a></li>
        </ul>
    </div>
</div>