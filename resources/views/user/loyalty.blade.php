@extends('user.layout')

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
        <div class="w-full max-w-3xl bg-white p-8 shadow-lg rounded-md">
            <h2 class="text-2xl font-bold text-center mb-8">View and Redeem Loyalty Points</h2>
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="font-bold text-xl text-[var(--primary)] ml-1">Your Points</h2>
                    <h2 class="font-bold text-xl text-yellow-500 ml-1"><i
                            class="fa-solid fa-star mr-2"></i>{{ $customer->loyaltyPoint }}</h2>
                </div>
                <button class="w-fit mt-2 px-4 text-sm bg-yellow-600 text-white py-2 rounded transition"
                    data-twe-target="#rewardsModal" data-twe-toggle="modal">
                    Your Rewards
                </button>
            </div>
            <h2 class="font-bold text-xl text-[var(--primary)] ml-1">Available Offers</h2>
            <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                @foreach ($loyalties as $loyalty)
                    <div class="shadow-xl rounded-xl w-full px-4 py-3 h-fit">
                        <p class="font-medium"><i class="fa-solid fa-ticket mr-2"></i>{{ $loyalty->name }}

                        <p class="font-medium"><i class="fa-solid fa-coins"></i> {{ $loyalty->point }} Points</p>
                        <p class="font-medium"><i class="fa-solid fa-medal"></i> {{ $loyalty->reward }}</p>
                        <p class="font-semibold text-orange-600">Valid Until
                            {{ \Carbon\Carbon::parse($loyalty->endDate)->format('d M Y') }}
                        </p>
                        <button onclick="redeem('{{ $loyalty->id }}')"
                            class="w-fit mt-2 px-4 text-sm bg-[var(--primary)] text-white py-2 rounded hover:bg-blue-700 transition">
                            Redeem Reward
                        </button>
                    </div>
                @endforeach

            </div>
    </section>


    <!-- Rewards Modal -->
    <div data-twe-modal-init
        class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
        id="rewardsModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true" role="dialog">
        <div data-twe-modal-dialog-ref
            class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
            <div
                class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none">
                <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 p-4">
                    <!-- Modal title -->
                    <h5 class="text-xl font-bold leading-normal text-surface" id="exampleModalCenterTitle">
                        Your Rewards
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

                <div class="p-4 flex flex-col gap-y-4 max-h-[460px] overflow-y-scroll">
                    @foreach ($customerLoyalties as $cl)
                        <div class="shadow-xl rounded-xl w-full px-4 py-3 h-fit">
                            <p class="font-medium"><i class="fa-solid fa-ticket mr-2"></i>{{ $cl->loyaltyProgram->name }}

                            <p class="font-medium"><i class="fa-solid fa-medal"></i> {{ $cl->loyaltyProgram->reward }}</p>
                            <p class="font-semibold text-orange-600">Valid Until
                                {{ \Carbon\Carbon::parse($cl->loyaltyProgram->endDate)->format('d M Y') }}
                            </p>
                            <p class="font-medium">Qty: {{ $cl->count }}</p>

                        </div>
                    @endforeach
                </div>

                <!-- Modal footer -->
                <div
                    class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 p-4">
                    <button type="button"
                        class="inline-block rounded bg-[var(--lighten)] px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-[var(--primary)] transition duration-150 ease-in-out"
                        data-twe-modal-dismiss data-twe-ripple-init data-twe-ripple-color="light">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function redeem(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to redeem this reward!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Redeem'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{ route('customer_loyalty.store') }}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                loyalty_program_id: id
                            })
                        }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: data.message,
                                }).then(() => {
                                    location.reload()
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: data.message,
                                })
                            }
                        }).catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            })
                        })
                }
            })
        }
    </script>
@endsection
