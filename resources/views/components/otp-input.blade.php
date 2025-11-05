<div class="font-inter relative antialiased">

    <main class="relative flex min-h-screen flex-col justify-center overflow-hidden bg-slate-50">
        <div class="mx-auto w-full max-w-6xl px-4 py-24 md:px-6">
            <div class="flex justify-center">

                <div class="mx-auto max-w-md rounded-xl bg-white px-4 py-10 text-center shadow sm:px-8">
                    <header class="mb-8">
                        <h1 class="mb-1 text-2xl font-bold">Mobile Phone Verification</h1>
                        <p class="text-[15px] text-slate-500">Enter the 4-digit verification code that was sent to your
                            phone number.</p>
                    </header>
                    <form id="otp-form">
                        <div class="flex items-center justify-center gap-3">
                            <input
                                class="h-14 w-14 appearance-none rounded border border-transparent bg-slate-100 p-4 text-center text-2xl font-extrabold text-slate-900 outline-none hover:border-slate-200 focus:border-indigo-400 focus:bg-white focus:ring-2 focus:ring-indigo-100"
                                type="text" pattern="\d*" maxlength="1" />
                            <input
                                class="h-14 w-14 appearance-none rounded border border-transparent bg-slate-100 p-4 text-center text-2xl font-extrabold text-slate-900 outline-none hover:border-slate-200 focus:border-indigo-400 focus:bg-white focus:ring-2 focus:ring-indigo-100"
                                type="text" maxlength="1" />
                            <input
                                class="h-14 w-14 appearance-none rounded border border-transparent bg-slate-100 p-4 text-center text-2xl font-extrabold text-slate-900 outline-none hover:border-slate-200 focus:border-indigo-400 focus:bg-white focus:ring-2 focus:ring-indigo-100"
                                type="text" maxlength="1" />
                            <input
                                class="h-14 w-14 appearance-none rounded border border-transparent bg-slate-100 p-4 text-center text-2xl font-extrabold text-slate-900 outline-none hover:border-slate-200 focus:border-indigo-400 focus:bg-white focus:ring-2 focus:ring-indigo-100"
                                type="text" maxlength="1" />
                        </div>
                        <div class="mx-auto mt-4 max-w-[260px]">
                            <button
                                class="inline-flex w-full justify-center whitespace-nowrap rounded-lg bg-indigo-500 px-3.5 py-2.5 text-sm font-medium text-white shadow-sm shadow-indigo-950/10 transition-colors duration-150 hover:bg-indigo-600 focus:outline-none focus:ring focus:ring-indigo-300 focus-visible:outline-none focus-visible:ring focus-visible:ring-indigo-300"
                                type="submit">Verify
                                Account</button>
                        </div>
                    </form>
                    <div class="mt-4 text-sm text-slate-500">Didn't receive code? <a
                            class="font-medium text-indigo-500 hover:text-indigo-600" href="#0">Resend</a></div>
                </div>

            </div>
        </div>
    </main>

    <!-- Page footer -->
    <footer class="absolute bottom-4 left-6 right-6 text-center md:bottom-8 md:left-12 md:right-auto md:text-left">
        <a class="text-xs text-slate-500 hover:underline" href="https://cruip.com">&copy;Cruip - Tailwind CSS
            templates</a>
    </footer>

    <!-- Banner with links -->
    <div class="fixed bottom-0 right-0 z-50 w-full md:bottom-6 md:right-12 md:w-auto"
        :class="bannerOpen ? '' : 'hidden'" x-data="{ bannerOpen: true }">
        <div class="flex justify-between bg-slate-800 p-3 text-sm shadow md:rounded">
            <div class="inline-flex text-slate-500">
                <a class="font-medium text-slate-300 hover:underline"
                    href="https://cruip.com/otp-form-example-made-with-tailwind-css-and-javascript/" target="_blank">
                    Read Tutorial
                </a>
                <span class="px-1.5 italic">or</span>
                <a class="flex items-center font-medium text-indigo-500 hover:underline"
                    href="https://github.com/cruip/cruip-tutorials/blob/main/otp-form/index.html" target="_blank"
                    rel="noreferrer">
                    <span>Download</span>
                    <svg class="ml-1 fill-indigo-400" xmlns="http://www.w3.org/2000/svg" width="9" height="9">
                        <path d="m1.649 8.514-.91-.915 5.514-5.523H2.027l.01-1.258h6.388v6.394H7.158l.01-4.226z" />
                    </svg>
                </a>
            </div>
            <button class="ml-3 border-l border-slate-700 pl-2 text-slate-500 hover:text-slate-400"
                @click="bannerOpen = false">
                <span class="sr-only">Close</span>
                <svg class="h-4 w-4 shrink-0 fill-current" viewBox="0 0 16 16">
                    <path
                        d="M12.72 3.293a1 1 0 00-1.415 0L8.012 6.586 4.72 3.293a1 1 0 00-1.414 1.414L6.598 8l-3.293 3.293a1 1 0 101.414 1.414l3.293-3.293 3.293 3.293a1 1 0 001.414-1.414L9.426 8l3.293-3.293a1 1 0 000-1.414z" />
                </svg>
            </button>
        </div>
    </div>

</div>
