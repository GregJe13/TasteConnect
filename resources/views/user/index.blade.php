@extends('user.layout')

@section('content')
    @if (session()->has('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
            })
        </script>
    @endif
    @if (session()->has('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
            })
        </script>
    @endif
    <section class="w-screen h-screen flex justify-center py-24 px-44">
        <div class="w-full">
            <div class="w-full flex justify-between">
                <h1 class="text-4xl font-bold text-black">Best Menu</h1>
                <button class="flex items-center justify-center gap-x-4 bg-[var(--primary)] shadow-xl px-4 py-2 rounded"
                    data-twe-ripple-init data-twe-ripple-color="light" data-twe-target="#cartModal" data-twe-toggle="modal">
                    <i class="fa-solid fa-cart-shopping text-white"></i>
                    <p class="text-white">Your Cart</p>
                </button>
            </div>
            <div class="grid grid-cols-3 gap-8 pb-12">
                @foreach ($menus as $menu)
                    {{-- Kita tambahkan class 'relative' di sini agar bisa menempatkan teks di atas gambar --}}
                    <div class="relative shadow-xl rounded-xl w-full px-8 py-6 h-fit @if ($menu->stock == 0) opacity-50 bg-gray-100 @endif"
                        data-stock="{{ $menu->stock }}">

                        {{-- TAMBAHKAN KELAS 'grayscale' JIKA STOK 0 --}}
                        <img src="{{ asset('assets/' . $menu->image) }}" alt="{{ $menu->name }}"
                            class="w-full h-48 object-cover rounded @if ($menu->stock == 0) grayscale @endif">

                        {{-- TAMBAHKAN BLOK INI UNTUK MENAMPILKAN TEKS "HABIS" --}}
                        @if ($menu->stock == 0)
                            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-40 rounded-t-lg top-0 mx-8 mt-6"
                                style="height: 192px;">
                                <span class="text-white text-2xl font-bold border-2 border-white px-4 py-2">Sold Out</span>
                            </div>
                        @endif

                        <div class="flex justify-between items-center mt-2">
                            <p class="font-semibold">{{ $menu->name }}</p>
                            <p class="font-semibold">Rp{{ number_format($menu->price) }}</p>
                        </div>
                        <p class="text-sm text-gray-600 font-medium">Stock: {{ $menu->stock }}</p>
                        <div class="flex justify-between items-center mt-2">
                            <div class="flex gap-x-4">
                                <button
                                    class="rounded-full bg-[var(--primary)] text-white text-lg w-[30px] h-[30px] flex justify-center items-center minus-btn"
                                    data-id="{{ $menu->id }}" data-twe-ripple-init data-twe-ripple-color="light"
                                    @if ($menu->stock == 0) disabled @endif>-</button>
                                <input type="number" id="quantity-{{ $menu->id }}" disabled
                                    class="bg-none outline-none border-none w-[20px] text-center" value="0"
                                    min="1" max="{{ $menu->stock }}">
                                <button
                                    class="rounded-full bg-[var(--primary)] text-white text-lg w-[30px] h-[30px] flex justify-center items-center plus-btn"
                                    data-id="{{ $menu->id }}" data-twe-ripple-init data-twe-ripple-color="light"
                                    @if ($menu->stock == 0) disabled @endif>+</button>
                            </div>

                            <button class="w-fit px-4 py-2 bg-[var(--contrast)] rounded-md text-sm text-white"
                                onclick="addToCart('{{ $menu->id }}')" data-twe-ripple-init
                                data-twe-ripple-color="light" @if ($menu->stock == 0) disabled @endif>Add to
                                Cart</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Cart Modal -->
    <div data-twe-modal-init
        class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
        id="cartModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true" role="dialog">
        <div data-twe-modal-dialog-ref
            class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
            <div
                class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none">
                <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 p-4">
                    <!-- Modal title -->
                    <h5 class="text-xl font-bold leading-normal text-[var(--primary)]" id="exampleModalCenterTitle">
                        Your Cart
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
                <div class="relative p-4 w-full">
                    <div class="w-full flex flex-col gap-y-4 cart-item-container">
                        <p class="text-lg font-bold ml-2">Total: Rp{{ number_format($carts->sum('price')) }}</p>
                        @foreach ($carts as $cart)
                            <div class="shadow-xl rounded-lg flex p-4 gap-x-4 w-full" id="{{ 'cart-' . $cart->id }}">
                                <img src="{{ asset('assets/' . $cart->menu->image) }}" class="max-w-[110px] rounded">
                                <div class="w-full">
                                    <p class="font-semibold text-lg">{{ $cart->menu->name }}</p>
                                    <p class="font-medium">{{ $cart->quantity }} x
                                        Rp{{ number_format($cart->menu->price) }}
                                    </p>
                                    <p class="font-medium">Rp{{ number_format($cart->price) }}</p>
                                    <div class="flex justify-between items-center mt-2 w-full">
                                        <div class="flex gap-x-4">
                                            <button
                                                class="rounded-full bg-[var(--primary)] text-white text-lg w-[30px] h-[30px] flex justify-center items-center cart-minus-btn"
                                                data-id="{{ $cart->id }}" data-twe-ripple-init
                                                data-twe-ripple-color="light">-</button>
                                            <input type="number" id="cart-quantity-{{ $cart->id }}" disabled
                                                class="bg-none outline-none border-none w-[20px] text-center"
                                                value="{{ $cart->quantity }}" min="1">
                                            <button
                                                class="rounded-full bg-[var(--primary)] text-white text-lg w-[30px] h-[30px] flex justify-center items-center cart-plus-btn"
                                                data-id="{{ $cart->id }}" data-twe-ripple-init
                                                data-twe-ripple-color="light">+</button>
                                        </div>

                                        <button class="w-fit px-4 py-2 bg-danger rounded-md text-sm text-white"
                                            onclick="deleteItem('{{ $cart->id }}')" data-twe-ripple-init
                                            data-twe-ripple-color="light"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Modal footer -->
                <div
                    class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 p-4">
                    <button type="button"
                        class="inline-block rounded bg-[var(--lighten)] px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-[var(--primary)] transition duration-150 ease-in-out"
                        data-twe-modal-dismiss data-twe-ripple-init data-twe-ripple-color="light">
                        Close
                    </button>
                    <button type="button" onclick="continuePayment()"
                        class="ms-1 inline-block rounded bg-[var(--primary)] px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out"
                        data-twe-ripple-init data-twe-ripple-color="light">
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const minusButtons = document.querySelectorAll('.minus-btn');
            const plusButtons = document.querySelectorAll('.plus-btn');

            minusButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const input = document.getElementById(`quantity-${id}`);
                    let value = parseInt(input.value) || 0;

                    if (value > 0) {
                        input.value = value - 1;
                    }
                });
            });

            plusButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const input = document.getElementById(`quantity-${id}`);
                    // Ambil stock dari data attribute
                    const stock = parseInt(this.closest('[data-stock]').getAttribute('data-stock'));
                    let value = parseInt(input.value) || 0;

                    // Ubah kondisi batas atas dari 20 menjadi stock
                    if (value < stock) {
                        input.value = value + 1;
                    }
                });
            });
        });


        var cartMinusButtons = document.querySelectorAll('.cart-minus-btn');
        var cartPlusButtons = document.querySelectorAll('.cart-plus-btn');


        function updateCartUI(carts) {
            const cartContainer = document.querySelector('.cart-item-container');
            cartContainer.innerHTML = '';
            const totalElement = document.createElement('p');
            totalElement.className = 'text-lg font-bold ml-2';
            cartContainer.appendChild(totalElement);

            var total = 0;
            carts.forEach(cart => {
                total += parseInt(cart.price);
                console.log(cart.price);
                const cartItem = document.createElement('div');
                cartItem.className = 'shadow-xl rounded-lg flex p-4 gap-x-4 w-full';
                cartItem.id = `cart-${cart.id}`;
                cartItem.innerHTML = `
                        <img src="{{ asset('assets') }}/${cart.menu.image}" class="max-w-[110px] rounded">
                            <div class="w-full">
                                <p class="font-semibold text-lg">${cart.menu.name}</p>
                                <p class="font-medium">${cart.quantity} x
                                    Rp${new Intl.NumberFormat('id-ID').format(cart.menu.price)}
                                </p>
                                <p class="font-medium">Rp${new Intl.NumberFormat('id-ID').format(cart.price)}</p>
                                <div class="flex justify-between items-center mt-2 w-full">
                                    <div class="flex gap-x-4">
                                        <button
                                            class="rounded-full bg-[var(--primary)] text-white text-lg w-[30px] h-[30px] flex justify-center items-center cart-minus-btn"
                                            data-id="${cart.id}" data-twe-ripple-init
                                            data-twe-ripple-color="light">-</button>
                                        <input type="number" id="cart-quantity-${cart.id}" disabled
                                            class="bg-none outline-none border-none w-[20px] text-center"
                                            value="${cart.quantity}" min="1">
                                        <button
                                            class="rounded-full bg-[var(--primary)] text-white text-lg w-[30px] h-[30px] flex justify-center items-center cart-plus-btn"
                                            data-id="${cart.id}" data-twe-ripple-init
                                            data-twe-ripple-color="light">+</button>
                                    </div>

                                    <button class="w-fit px-4 py-2 bg-danger rounded-md text-sm text-white"
                                        onclick="deleteItem('${cart.id}')" data-twe-ripple-init
                                        data-twe-ripple-color="light"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </div>
                    `;
                cartContainer.appendChild(cartItem);

            });

            totalElement.textContent = `Total: Rp${new Intl.NumberFormat('id-ID').format(total)}`;
            renderButtons();
        }

        function getCart() {
            fetch(`{{ route('cart.index') }}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCartUI(data.data);
                    }
                });
        }

        function addToCart(id) {
            const quantity = document.getElementById(`quantity-${id}`).value;
            if (quantity <= 0) {
                // Jangan lakukan apa-apa jika jumlahnya 0
                return;
            }

            // Gunakan Blade directive untuk memeriksa apakah sesi 'id' ada
            @if (session()->has('id'))
                // JIKA SUDAH LOGIN: Lakukan panggilan fetch seperti biasa
                Swal.fire({
                    title: 'Saving...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch(`{{ route('cart.store') }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            menu_id: id,
                            quantity: quantity
                        })
                    }).then(response => response.json())
                    .then(data => {
                        Swal.close();
                        if (data.success) {
                            popToast(data.success, data.message);
                            getCart();
                            document.getElementById(`quantity-${id}`).value = 0; // Reset counter
                        } else {
                            popToast(data.success, data.message);
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        });
                    });
            @else
                // JIKA BELUM LOGIN: Arahkan ke halaman login dengan query parameter
                const loginUrl = new URL('{{ route('login') }}');
                loginUrl.searchParams.append('menu_id', id);
                loginUrl.searchParams.append('quantity', quantity);

                // Simpan pesan untuk ditampilkan setelah login
                Swal.fire({
                    icon: 'info',
                    title: 'Silakan Login',
                    text: 'Anda harus login terlebih dahulu untuk menambahkan item ke keranjang.',
                    confirmButtonText: 'Login Sekarang'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = loginUrl.toString();
                    }
                });
            @endif
        }


        function deleteItem(id) {
            document.getElementById(`cart-${id}`).remove();
            fetch(`{{ route('cart.destroy', '') }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        popToast(data.success, data.message);
                        getCart();
                    } else {
                        popToast(data.success, data.message);
                    }
                });
        }

        function renderButtons() {
            cartMinusButtons = document.querySelectorAll('.cart-minus-btn');
            cartPlusButtons = document.querySelectorAll('.cart-plus-btn');
            cartMinusButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const input = document.getElementById(`cart-quantity-${id}`);
                    let value = parseInt(input.value) || 0;
                    console.log(value);
                    if (value <= 1) {
                        console.log('msk');
                        deleteItem(id);
                        return;
                    }

                    fetch(`{{ route('cart.update', '') }}/${id}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                deduct: true
                            })
                        }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                input.value = value - 1;
                                getCart();
                            } else {
                                popToast(data.success, data.message);
                            }
                        });
                })
            });

            cartPlusButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const input = document.getElementById(`cart-quantity-${id}`);
                    let value = parseInt(input.value) || 0;

                    fetch(`{{ route('cart.update', '') }}/${id}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                deduct: false
                            })
                        }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                input.value = value + 1;
                                getCart();
                            } else {
                                popToast(data.success, data.message);
                            }
                        });
                })
            });
        }

        function continuePayment() {
            const cartContainer = document.querySelector('.cart-item-container');
            if (cartContainer.children.length <= 1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Your cart is empty!',
                });
                return;
            } else {
                window.location.href = '{{ route('payment') }}';
            }

            document.getElementById('cartModal').click();
        }

        renderButtons();
    </script>
@endsection
