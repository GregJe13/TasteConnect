@extends('admin.layout')

@section('content')
    @if (session()->has('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
            })
        </script>
    @endif
    <section class="w-screen min-h-screen flex items-center justify-center bg-gray-100 py-24">
        <div class="w-full max-w-4xl bg-white p-8 shadow-lg rounded-md">
            <h2 class="text-2xl font-bold text-center mb-4">Customer Orders</h2>
            <div class="mb-4 flex gap-x-10 justify-center">
                <div class="flex items-center gap-x-2 pl-1">
                    <div class="rounded-full w-[15px] h-[15px] bg-amber-500"></div>
                    <i class="fa-solid fa-arrow-right"></i>
                    <p>Processing</p>
                </div>
                <div class="flex items-center gap-x-2 pl-1">
                    <div class="rounded-full w-[15px] h-[15px] bg-blue-500"></div>
                    <i class="fa-solid fa-arrow-right"></i>
                    <p>Delivery</p>
                </div>
                <div class="flex items-center gap-x-2 pl-1">
                    <div class="rounded-full w-[15px] h-[15px] bg-green-500"></div>
                    <i class="fa-solid fa-arrow-right"></i>
                    <p>Completed</p>
                </div>
                <div class="flex items-center gap-x-2 pl-1">
                    <div class="rounded-full w-[15px] h-[15px] bg-red-500"></div>
                    <i class="fa-solid fa-arrow-right"></i>
                    <p>Cancelled</p>
                </div>
            </div>
            <div class="w-full flex gap-x-4">
                <div class="relative mb-4 flex w-3/4 flex-wrap items-stretch">
                    <input id="search" type="search"
                        class="relative m-0 -mr-0.5 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none"
                        placeholder="Search" aria-label="Search" aria-describedby="button-addon1" />

                    <!--Search button-->
                    <button
                        class="relative z-[2] flex items-center rounded-r bg-[var(--primary)] px-6 py-2.5 text-xs font-medium uppercase leading-tight text-white shadow-md transition duration-150 ease-in-out hover:bg-primary-700 hover:shadow-lg focus:bg-primary-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-primary-800 active:shadow-lg"
                        type="button" id="advanced-search-button" data-te-ripple-init data-te-ripple-color="teal">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd"
                                d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <select id="orders-filter"
                    class="w-1/4 h-[40px] py-1 px-2 rounded border border-[var(--primary)] focus:outline-none text-[var(--primary)] font-semibold">
                    <option value="">Filter Orders</option>
                    <option value="today">Today</option>
                    <option value="week">1 Week Ago</option>
                    <option value="month">1 Month Ago</option>
                </select>
            </div>
            <div class="flex gap-x-8 mb-8">
                <button type="button" data-twe-ripple-init data-twe-ripple-color="light"
                    class="w-full px-4 text-sm mt-1 bg-green-700 text-white py-2 rounded font-semibold transition shadow-xl">
                    Export Data as Excel
                </button>
                <button type="button" data-twe-ripple-init data-twe-ripple-color="light"
                    class="w-full px-4 text-sm mt-1 bg-red-700 text-white py-2 rounded font-semibold transition shadow-xl">
                    Export Data as PDF
                </button>
            </div>
            <div class="grid grid-cols-2 gap-x-8 gap-y-6" id="order-container">
                @foreach ($orders as $order)
                    @if ($order->status == 0)
                        <div class="shadow-md rounded-xl shadow-amber-500 w-full px-4 py-3 h-full">
                        @elseif ($order->status == 1)
                            <div class="shadow-md rounded-xl shadow-blue-500 w-full px-4 py-3 h-full">
                            @elseif ($order->status == 2 || $order->status == 4)
                                <div class="shadow-md rounded-xl shadow-green-500 w-full px-4 py-3 h-full">
                                @else
                                    <div class="shadow-md rounded-xl shadow-red-500 w-full px-4 py-3 h-full">
                    @endif
                    <p class="font-medium"><i class="fa-solid fa-user mr-2"></i>{{ $order->customer->name }}
                    </p>
                    <p class="font-medium"><i class="fa-solid fa-envelope mr-2"></i>{{ $order->customer->email }}
                    </p>
                    <p class="font-medium"><i
                            class="fa-solid fa-calendar mr-2"></i>{{ \Carbon\Carbon::parse($order->orderDate)->format('Y-m-d') }}
                    </p>
                    <p class="font-medium"><i
                            class="fa-solid fa-clock mr-2"></i>{{ \Carbon\Carbon::parse($order->orderDate)->format('H:i') }}
                    </p>
                    <p class="font-medium"><i class="fa-solid fa-location-dot mr-2"></i>{{ $order->address }}</p>

                    <div class="flex gap-x-2">
                        <button type="button" onclick="window.location.href='{{ route('admin.orders.show', $order->id) }}'"
                            class="w-fit px-4 text-sm mt-1 bg-[var(--primary)] text-white py-2 rounded font-semibold transition">
                            Details
                        </button>
                        <button type="button" onclick="updateStatus('{{ $order->id }}', 0)"
                            class="w-fit px-4 text-sm mt-1 bg-yellow-500 text-white py-2 rounded font-semibold transition">
                            <i class="fa-solid fa-spinner"></i>
                        </button>
                        <button type="button" onclick="updateStatus('{{ $order->id }}', 1)"
                            class="w-fit px-4 text-sm mt-1 bg-blue-500 text-white py-2 rounded font-semibold transition">
                            <i class="fa-solid fa-motorcycle"></i>
                        </button>
                        <button type="button" onclick="updateStatus('{{ $order->id }}', 2)"
                            class="w-fit px-4 text-sm mt-1 bg-green-500 text-white py-2 rounded font-semibold transition">
                            <i class="fa-solid fa-check"></i>
                        </button>
                        <button type="button" onclick="updateStatus('{{ $order->id }}', 3)"
                            class="w-fit px-4 text-sm mt-1 bg-red-500 text-white py-2 rounded font-semibold transition">
                            <i class="fa-solid fa-ban"></i>
                        </button>
                    </div>
            </div>
            @endforeach

        </div>
    </section>

    <!-- Create Modal -->
    <div data-twe-modal-init
        class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
        id="createModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true" role="dialog">
        <div data-twe-modal-dialog-ref
            class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
            <div
                class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none">
                <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 p-4">
                    <!-- Modal title -->
                    <h5 class="text-xl font-bold leading-normal text-surface" id="exampleModalCenterTitle">
                        Make a order
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
                <div class="relative p-4">
                    <div class="p-6">
                        <label for="date" class="block text-gray-700 font-medium mb-1">Pick Date and Time</label>
                        <input type="datetime-local" id="date" name="date"
                            class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300">
                    </div>
                </div>

                <!-- Modal footer -->
                <div
                    class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 p-4">
                    <button type="button"
                        class="inline-block rounded bg-[var(--lighten)] px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-[var(--primary)] transition duration-150 ease-in-out"
                        data-twe-modal-dismiss data-twe-ripple-init data-twe-ripple-color="teal">
                        Close
                    </button>
                    <button type="button" id="submit"
                        class="ms-1 inline-block rounded bg-[var(--primary)] px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out"
                        data-twe-ripple-init data-twe-ripple-color="teal">
                        Create order
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- fetch(`{{ route('admin.order.update', '') }}/${id}`, { --}}

    <script>
        const orders = @json($orders);

        function updateStatus(id, status) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to update the order status",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'No, cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{ route('admin.order.update.status', '') }}/${id}`, {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                status: status
                            })
                        })
                        .then(response => response.json())
                        .then(response => {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message || 'Something went wrong!',
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: error.message || 'Network error!',
                            });
                        });
                }
            });
        }

        $('#search').on('input', function() {
            var value = $(this).val().toLowerCase();
            $('#order-container > div').each(function() {
                var matches = $(this).text().toLowerCase().indexOf(value) > -1;
                $(this).toggle(matches);
            });
        });

        document.getElementById('orders-filter').addEventListener('change', function() {
            const filterValue = this.value;
            const today = new Date();
            const orderContainer = document.getElementById('order-container');


            Array.from(orderContainer.children).forEach(order => {
                const orderDate = new Date(order.querySelector('p:nth-child(3)').textContent.trim());

                let shouldShow = true;

                if (filterValue === 'today') {
                    shouldShow = orderDate.toDateString() === today.toDateString();
                } else if (filterValue === 'week') {
                    const oneWeekAgo = new Date();
                    oneWeekAgo.setDate(today.getDate() - 7);
                    shouldShow = orderDate >= oneWeekAgo && orderDate <= today;
                } else if (filterValue === 'month') {
                    const oneMonthAgo = new Date();
                    oneMonthAgo.setMonth(today.getMonth() - 1);
                    shouldShow = orderDate >= oneMonthAgo && orderDate <= today;
                }


                order.style.display = shouldShow ? '' : 'none';
            });
        });
    </script>
@endsection
