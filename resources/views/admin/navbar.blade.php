    <!-- Main navigation container -->
    <nav class="fixed z-[100] flex w-full flex-nowrap items-center justify-between bg-zinc-100 xl:px-44 lg:px-24 md:px-12 px-4 py-2 text-black shadow-dark-mild hover:text-neutral-700 focus:text-neutral-700 lg:flex-wrap lg:justify-start lg:py-4"
        data-twe-navbar-ref>
        <div class="flex w-full flex-wrap items-center justify-between">
            <div class="ms-2">
                <a class="text-xl text-black font-extrabold" href="{{ route('index') }}">Taste<span
                        class="text-[var(--contrast)]">Connect</span><span class="text-orange-600">Admin</span></a>
            </div>
            <!-- Hamburger button for mobile view -->
            <button
                class="block border-0 bg-transparent px-2 text-black hover:no-underline hover:shadow-none focus:no-underline focus:shadow-none focus:outline-none focus:ring-0 lg:hidden"
                type="button" data-twe-collapse-init data-twe-target="#navbarSupportedContent2"
                aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="Toggle navigation">
                <!-- Hamburger icon -->
                <span class="[&>svg]:w-7 [&>svg]:stroke-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3 6.75A.75.75 0 013.75 6h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 6.75zM3 12a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 12zm0 5.25a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75a.75.75 0 01-.75-.75z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
            </button>

            <!-- Collapsible navbar container -->
            <div class="!visible mt-2 hidden basis-[100%] items-center lg:mt-0 lg:!flex lg:basis-auto"
                id="navbarSupportedContent2" data-twe-collapse-item>
                <!-- Left links -->
                <ul class="list-style-none me-auto flex flex-col ps-0 lg:mt-1 lg:flex-row" data-twe-navbar-nav-ref>
                    <li class="my-2 ps-2 flex items-center lg:my-0 lg:pe-1 lg:ps-2" data-twe-nav-item-ref>
                        <a class="text-black lg:px-2" aria-current="page" href="{{ route('admin.orders') }}"
                            data-twe-nav-link-ref>Orders</a>
                    </li>
                    <li class="my-2 ps-2 flex items-center lg:my-0 lg:pe-1 lg:ps-2" data-twe-nav-item-ref>
                        <a class="text-black lg:px-2" aria-current="page" href="{{ route('admin.reservation') }}"
                            data-twe-nav-link-ref>Reservations</a>
                    </li>
                    <li class="my-2 ps-2 flex items-center lg:my-0 lg:pe-1 lg:ps-2" data-twe-nav-item-ref>
                        <a class="text-black lg:px-2" aria-current="page" href="{{ route('admin.loyalty.index') }}"
                            data-twe-nav-link-ref>Loyalty</a>
                    </li>
                    <li class="my-2 ps-2 flex items-center lg:my-0 lg:pe-1 lg:ps-2" data-twe-nav-item-ref>
                        <a class="text-black lg:px-2" aria-current="page" href="{{ route('admin.inventory') }}"
                            data-twe-nav-link-ref>Inventory</a>
                    </li>
                    <li class="my-2 ps-2 flex items-center lg:my-0 lg:pe-1 lg:ps-2" data-twe-nav-item-ref>
                        <a class="text-black lg:px-2" aria-current="page" href="{{ route('admin.profile.index') }}"
                            data-twe-nav-link-ref>Profiles</a>
                    </li>
                    <li class="my-2 ps-2 flex items-center lg:my-0 lg:pe-1 lg:ps-2" data-twe-nav-item-ref>
                        <a class="text-black lg:px-2" aria-current="page" href="{{ route('admin.notification.index') }}"
                            data-twe-nav-link-ref>Send Notif</a>
                    </li>
                    <li class="my-2 ps-2 flex items-center lg:my-0 lg:pe-1 lg:ps-2" data-twe-nav-item-ref>
                        <a class="text-black lg:px-2" aria-current="page" href="{{ route('admin.promotion.index') }}"
                            data-twe-nav-link-ref>Promotions</a>
                    </li>
                    @if (session()->has('id'))
                        <li class="my-2 ps-2 flex items-center lg:my-0 lg:pe-1 lg:ps-2" data-twe-nav-item-ref>
                            <a class="text-black lg:px-2" aria-current="page" href="{{ route('logout') }}"
                                data-twe-nav-link-ref>Logout</a>
                        </li>
                    @else
                        <li class="my-2 ps-2 flex items-center lg:my-0 lg:pe-1 lg:ps-2" data-twe-nav-item-ref>
                            <a class="text-black lg:px-2" aria-current="page" href="{{ route('login') }}"
                                data-twe-nav-link-ref>Login</a>
                        </li>
                    @endif
                    <!-- Dropdown -->
                    {{-- <li class="my-2 ps-2 flex items-center lg:my-0 lg:pe-1 lg:ps-2" data-twe-nav-item-ref>
                        <div class="relative" data-twe-dropdown-ref>
                            <a class="flex items-center text-black transition duration-200 hover:text-black/80 hover:ease-in-out focus:text-black/80 active:text-black/80 motion-reduce:transition-none lg:px-2"
                                href="#" type="button" id="dropdownMenuButton2" data-twe-dropdown-toggle-ref
                                aria-expanded="false">
                                Manajemen Panti
                                <span class="ms-2 [&>svg]:w-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </a>
                            <ul class="absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg data-[twe-dropdown-show]:block"
                                aria-labelledby="dropdownMenuButton1" data-twe-dropdown-menu-ref>
                                <li>
                                    <a class="block w-full whitespace-nowrap bg-white px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-zinc-200/60 focus:bg-zinc-200/60 focus:outline-none active:bg-zinc-200/60 active:no-underline"
                                        href="" data-twe-dropdown-item-ref>Jumlah Isi
                                        Panti</a>
                                </li>
                                <li>
                                    <a class="block w-full whitespace-nowrap bg-white px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-zinc-200/60 focus:bg-zinc-200/60 focus:outline-none active:bg-zinc-200/60 active:no-underline"
                                        href="" data-twe-dropdown-item-ref>Keperluan
                                        Panti</a>
                                </li>
                            </ul>
                        </div>
                    </li> --}}
                </ul>
            </div>
        </div>
    </nav>
