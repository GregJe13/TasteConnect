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
        <div class="w-full max-w-md bg-white p-8 shadow-lg rounded-md">
            <h2 class="text-2xl font-bold text-center mb-6">Your Reservations</h2>
            <button data-twe-target="#createModal" data-twe-toggle="modal"
                class="w-fit mb-4 px-4 text-xs bg-[var(--primary)] text-white py-3 rounded hover:bg-blue-700 transition">
                Make Reservation
            </button>
            <div class="mb-4">
                <div class="flex items-center gap-x-4 pl-1">
                    <div class="rounded-full w-[15px] h-[15px] bg-green-500"></div>
                    <i class="fa-solid fa-arrow-right"></i>
                    <p>Approved</p>
                </div>
                <div class="flex items-center gap-x-4 pl-1">
                    <div class="rounded-full w-[15px] h-[15px] bg-amber-500"></div>
                    <i class="fa-solid fa-arrow-right"></i>
                    <p>Pending</p>
                </div>
                <div class="flex items-center gap-x-4 pl-1">
                    <div class="rounded-full w-[15px] h-[15px] bg-red-500"></div>
                    <i class="fa-solid fa-arrow-right"></i>
                    <p>Rejected</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                @foreach ($reservations as $reservation)
                    @if ($reservation->status == 0)
                        <div class="shadow-md rounded-xl shadow-amber-500 w-full px-4 py-3 h-fit">
                        @elseif ($reservation->status == 1)
                            <div class="shadow-md rounded-xl shadow-green-500 w-full px-4 py-3 h-fit">
                            @else
                                <div class="shadow-md rounded-xl shadow-red-500 w-full px-4 py-3 h-fit">
                    @endif
                    <p class="font-medium"><i
                            class="fa-solid fa-calendar mr-2"></i>{{ \Carbon\Carbon::parse($reservation->date)->format('Y-m-d') }}
                    </p>
                    <p class="font-medium"><i
                            class="fa-solid fa-clock mr-2"></i>{{ \Carbon\Carbon::parse($reservation->date)->format('H:i') }}
                    </p>

                    {{-- TOMBOL BARU DITAMBAHKAN DI SINI --}}
                    {{-- Hanya muncul jika status 0 (Pending) --}}
                    @if ($reservation->status == 0)
                        <button type="button" onclick="cancelReservation('{{ $reservation->id }}')"
                            class="w-fit mt-2 px-4 text-xs bg-red-600 text-white py-2 rounded transition hover:bg-red-700">
                            Batalkan
                        </button>
                    @endif
                    {{-- AKHIR TOMBOL BARU --}}
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
                        Make a Reservation
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
                        Create Reservation
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script>
        function cancelReservation(reservationId) {
            Swal.fire({
                title: 'Anda yakin?',
                text: "Reservasi ini akan dibatalkan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, batalkan!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/reservation/cancel/${reservationId}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            }
                        }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    'Dibatalkan!',
                                    'Reservasi Anda telah berhasil dibatalkan.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    data.message || 'Terjadi kesalahan saat membatalkan reservasi.',
                                    'error'
                                );
                            }
                        });
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            $('#submit').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Saving...",
                    allowOutSideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                fetch(`{{ route('reservation.store') }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        body: JSON.stringify({
                            date: $('#date').val(),
                        })
                    }).then(response => response.json())
                    .then(response => {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                            });
                        }
                    })
            });
        });
    </script>
@endsection
