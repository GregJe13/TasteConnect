<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Taste Connect | {{ $title }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/css/tw-elements.min.css" />
    <script src="https://cdn.tailwindcss.com/3.3.0"></script>

    {{-- CDN for JQUERY --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    
    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    {{-- Swiper --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- AOS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Faculty+Glyphic&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');


        * {
            font-family: 'Inter', sans-serif;
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Untuk Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }

        :root {
            --primary: #4b61dd;
            --secondary: #0b48b3;
            --contrast: #4b61dd;
            --lighten: rgba(75, 97, 221, 0.25);
        }

        .swal2-confirm {
            background: var(--primary) !important;
        }

        .swal2-deny,
        .swal2-cancel {
            background: rgb(242, 73, 73) !important;
        }

        body {
            overflow-x: hidden;
        }
    </style>

    @yield('head')
</head>

<body>
    @include('user.navbar')

    <div class="toast fixed bottom-0 right-[-100vw] p-8 z-[11000] transition-all duration-300">
        <div class=" w-[400px] h-fit bg-green-100 rounded">
            <h2 class="toast-title font-bold text-green-700 text-lg px-4 py-2 w-full border-b-2 border-green-500"></h2>
            <p class="text-green-700 font-medium px-4 py-2 toast-text"></p>
        </div>
    </div>
    <div class="fixed px-12 pt-24 top-0 right-0">
        <button
            class="rounded-full w-[55px] h-[55px] bg-[var(--primary)] flex justify-center items-center hover:cursor-pointer"
            data-twe-target="#notifModal" data-twe-toggle="modal">
            <i class="fa-solid fa-envelope text-white text-2xl"></i>
        </button>
    </div>

    <!-- Mailbox Modal -->
    <div data-twe-modal-init
        class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
        id="notifModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true" role="dialog">
        <div data-twe-modal-dialog-ref
            class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
            <div
                class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none">
                <div
                    class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 p-4">
                    <!-- Modal title -->
                    <h5 class="text-xl font-bold leading-normal text-surface" id="exampleModalCenterTitle">
                        Your Notifications
                    </h5>
                    <!-- Close button -->
                    <button type="button"
                        class="box-content rounded-none border-none text-neutral-500 hover:text-neutral-800 hover:no-underline focus:text-neutral-800 focus:opacity-100 focus:shadow-none focus:outline-none"
                        data-twe-modal-dismiss aria-label="Close">
                        <span class="[&>svg]:h-6 [&>svg]:w-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-4" id="notif-container">
                </div>

                <!-- Modal footer -->
                <div
                    class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 p-4">
                    <button type="button"
                        class="inline-block rounded bg-[var(--lighten)] px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-[var(--primary)] transition duration-150 ease-in-out"
                        data-twe-modal-dismiss data-twe-ripple-init data-twe-ripple-color="teal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    @yield('content')


    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/js/tw-elements.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/tw-elements.umd.min.js"></script>


    <script>
        AOS.init();

        function popToast(success, message) {
            const toast = document.querySelector('.toast');
            const toastTitle = toast.querySelector('.toast-title');
            const toastText = toast.querySelector('.toast-text');
            const toastContainer = toast.querySelector('div');

            // Tentukan warna berdasarkan parameter success
            if (success) {
                toastTitle.classList.remove('text-red-700');
                toastTitle.classList.add('text-green-700');
                toastText.classList.remove('text-red-700');
                toastText.classList.add('text-green-700');
                toastContainer.classList.remove('bg-red-100', 'border-red-500');
                toastContainer.classList.add('bg-green-100', 'border-green-500');
            } else {
                toastTitle.classList.remove('text-green-700');
                toastTitle.classList.add('text-red-700');
                toastText.classList.remove('text-green-700');
                toastText.classList.add('text-red-700');
                toastContainer.classList.remove('bg-green-100', 'border-green-500');
                toastContainer.classList.add('bg-red-100', 'border-red-500');
            }

            // Set isi toast
            toastTitle.textContent = success ? 'Success' : 'Error';
            toastText.textContent = message;

            // Tampilkan toast
            toast.style = 'right: 0';
            setTimeout(() => {
                toast.style = 'right: -100vw';
            }, 2300);
        }

        function getNotif() {
            fetch(`{{ route('notification.get') }}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(response => {
                    if (response.success) {
                        console.log('Fetch notification success');
                        console.log(response.data);
                        const notifContainer = document.getElementById('notif-container');
                        notifContainer.innerHTML = '';

                        response.data.forEach(notif => {

                            const notifDiv = document.createElement('div');
                            notifDiv.classList.add('shadow-lg', 'rounded', 'w-full', 'p-4', 'mb-4', 'border-2',
                                'border-[var(--primary)]');
                            notifDiv.innerHTML = `
                                                <h3 class="text-lg font-bold text-[var(--primary)]">${notif.title}</h3>
                                         `;

                            notifContainer.appendChild(notifDiv);
                        });
                    } else {
                        console.log('Fetch notification failed');
                    }
                })
                .catch(error => {
                    console.error('Error fetching notifications:', error);
                });
        }

        getNotif();
    </script>

</body>

</html>
