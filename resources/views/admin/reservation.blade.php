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
    <section class="w-screen min-h-screen flex items-center justify-center bg-gray-100 py-24 px-4">
        <div class="w-full max-w-4xl bg-white p-8 shadow-lg rounded-md">
            <h2 class="text-2xl font-bold text-center mb-6">Customer Reservations</h2>

            {{-- Penjelasan Warna (Legend) --}}
            <div class="mb-4 flex gap-x-10 justify-center">
                <div class="flex items-center gap-x-2">
                    <div class="rounded-full w-[15px] h-[15px] bg-green-500"></div>
                    <i class="fa-solid fa-arrow-right"></i>
                    <p>Approved</p>
                </div>
                <div class="flex items-center gap-x-2">
                    <div class="rounded-full w-[15px] h-[15px] bg-amber-500"></div>
                    <i class="fa-solid fa-arrow-right"></i>
                    <p>Pending</p>
                </div>
                <div class="flex items-center gap-x-2">
                    <div class="rounded-full w-[15px] h-[15px] bg-red-500"></div>
                    <i class="fa-solid fa-arrow-right"></i>
                    <p>Rejected</p>
                </div>
            </div>

            {{-- BAGIAN FILTER YANG DIPERBAIKI --}}
            <div class="w-full flex flex-col md:flex-row md:items-center gap-4 mb-6">
                {{-- Search Bar --}}
                <div class="relative flex items-stretch w-full md:flex-grow">
                    <input id="search-input" type="search"
                        class="relative m-0 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)]"
                        placeholder="Cari nama atau email..." />
                    <button
                        class="relative z-[2] flex items-center rounded-r bg-[var(--primary)] px-4 py-2.5 text-xs font-medium uppercase leading-tight text-white shadow-md transition duration-150 ease-in-out hover:bg-blue-700 focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800"
                        type="button" id="search-button">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd"
                                d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                {{-- Filter Tanggal --}}
                <div class="flex-shrink-0 w-full md:w-auto">
                    <input type="date" id="date-filter"
                        class="block w-full h-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                </div>

                {{-- Filter Status --}}
                <select id="reservation-filter"
                    class="w-3/10 h-[40px] py-1 px-2 rounded border border-[var(--primary)] focus:outline-none text-[var(--primary)] font-semibold">
                    <option value="all">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>

            {{-- Kontainer untuk Kartu Reservasi --}}
            <div id="reservation-container" class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                @foreach ($reservations as $reservation)
                    @php
                        $statusClass = '';
                        $statusText = '';
                        if ($reservation->status == 0) {
                            $statusClass = 'shadow-amber-500';
                            $statusText = 'pending';
                        } elseif ($reservation->status == 1) {
                            $statusClass = 'shadow-green-500';
                            $statusText = 'approved';
                        } else {
                            $statusClass = 'shadow-red-500';
                            $statusText = 'rejected';
                        }
                    @endphp
                    {{-- Tambahkan atribut data-date dan class reservation-card --}}
                    <div data-status="{{ $statusText }}"
                        data-date="{{ \Carbon\Carbon::parse($reservation->date)->format('Y-m-d') }}"
                        class="reservation-card shadow-md rounded-xl {{ $statusClass }} w-full px-4 py-3 h-full">
                        <p class="font-medium"><i class="fa-solid fa-user mr-2"></i>{{ $reservation->customer->name }}</p>
                        <p class="font-medium"><i class="fa-solid fa-envelope mr-2"></i>{{ $reservation->customer->email }}
                        </p>
                        <p class="font-medium"><i
                                class="fa-solid fa-calendar mr-2"></i>{{ \Carbon\Carbon::parse($reservation->date)->format('Y-m-d') }}
                        </p>
                        <p class="font-medium"><i
                                class="fa-solid fa-clock mr-2"></i>{{ \Carbon\Carbon::parse($reservation->date)->format('H:i') }}
                        </p>
                        @if ($reservation->status == 0)
                            <button type="button" onclick="updateStatus('{{ $reservation->id }}', 1)"
                                class="w-fit px-4 text-sm mt-1 bg-success text-white py-2 rounded font-semibold transition">Accept</button>
                            <button type="button" onclick="updateStatus('{{ $reservation->id }}', 2)"
                                class="w-fit px-4 text-sm mt-1 bg-danger text-white py-2 rounded font-semibold transition">Reject</button>
                        @elseif ($reservation->status == 1)
                            <button type="button" disabled
                                class="w-fit px-4 text-sm mt-1 bg-success-700 text-white py-2 rounded font-semibold transition">Accepted</button>
                        @else
                            <button type="button" disabled
                                class="w-fit px-4 text-sm mt-1 bg-danger-700 text-white py-2 rounded font-semibold transition">Rejected</button>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- JAVASCRIPT BARU UNTUK SEMUA FILTER --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const searchButton = document.getElementById('search-button');
            const dateFilter = document.getElementById('date-filter');
            const statusFilter = document.getElementById('reservation-filter');
            const reservationCards = document.querySelectorAll('.reservation-card');

            function applyFilters() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedDate = dateFilter.value;
                const selectedStatus = statusFilter.value;

                reservationCards.forEach(card => {
                    const cardText = card.textContent.toLowerCase();
                    const cardDate = card.getAttribute('data-date');
                    const cardStatus = card.getAttribute('data-status');

                    const searchMatch = searchTerm === '' || cardText.includes(searchTerm);
                    const dateMatch = selectedDate === '' || cardDate === selectedDate;
                    const statusMatch = selectedStatus === 'all' || cardStatus === selectedStatus;

                    if (searchMatch && dateMatch && statusMatch) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            // Tambahkan event listener ke setiap elemen filter
            searchButton.addEventListener('click', applyFilters);
            searchInput.addEventListener('keyup', function(event) {
                if (event.key === 'Enter') {
                    applyFilters();
                }
            });
            dateFilter.addEventListener('change', applyFilters);
            statusFilter.addEventListener('change', applyFilters);
        });

        // Fungsi updateStatus yang sudah ada
        function updateStatus(id, status) {
            // ... (kode fungsi updateStatus tidak berubah)
        }
    </script>
@endsection
