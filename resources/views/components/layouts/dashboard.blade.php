<div class="overflow-auto">

    <button
        class="ms-3 mt-2 inline-flex items-center rounded-lg p-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 sm:hidden"
        data-drawer-target="separator-sidebar" data-drawer-toggle="separator-sidebar" aria-controls="separator-sidebar"
        type="button">
        <span class="sr-only">Open sidebar</span>
        <svg class="h-6 w-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
            </path>
        </svg>
    </button>

    <aside class="fixed left-0 top-0 z-0 h-full w-52 -translate-x-full transition-transform sm:translate-x-0"
        id="separator-sidebar" aria-label="Sidebar">
        <div class="h-full overflow-y-auto bg-gray-50 px-3 py-4 pt-32">
            <ul class="mt-8 space-y-2 font-medium">
                <li>
                    <a class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100"
                        href="{{ route('dashboard') }}">
                        <svg class="h-5 w-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 22 21">
                            <path
                                d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path
                                d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>


                <li>
                    <a class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100"
                        href="{{ route('settings.profile') }}">
                        <svg class="h-5 w-5 shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 18">
                            <path
                                d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                        </svg>
                        <span class="ms-3 flex-1 whitespace-nowrap">Edit Profile</span>
                    </a>
                </li>
                <li>
                    <a class="group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100"
                        href="{{ route('upload') }}">
                        <svg class="h-5 w-5 shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 18 20">
                            <path
                                d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z" />
                        </svg>
                        <span class="ms-3 flex-1 whitespace-nowrap">upload</span>
                    </a>
                </li>


            </ul>
            <ul class="mt-4 space-y-2 border-t border-gray-200 pt-4 font-medium">
                <li>
                    <form class="w-full" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            class="group flex w-full cursor-pointer items-center rounded-lg p-2 text-start text-gray-900 hover:bg-gray-100"
                            type="submit">
                            <svg class="h-5 w-5 shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900"
                                aria-hidden="true" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M14 4L18 4C19.1046 4 20 4.89543 20 6V18C20 19.1046 19.1046 20 18 20H14M3 12L15 12M3 12L7 8M3 12L7 16"
                                        stroke="#001A72" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </g>
                            </svg>

                            <span class="ms-3 flex-1 whitespace-nowrap">Log Out</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </aside>

    <div class="my-20 p-4 sm:ml-52">
        {{ $slot }}
    </div>
</div>
