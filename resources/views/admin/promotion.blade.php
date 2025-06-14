@extends('admin.layout')

<style>
    body {
        overflow: hidden;
    }
</style>
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
            <h2 class="text-3xl font-bold text-center mb-6">Promotions</h2>
            <button data-twe-target="#createModal" data-twe-toggle="modal"
                class="w-fit mb-4 px-4 text-sm bg-[var(--primary)] text-white py-3 rounded hover:bg-blue-700 transition">
                Create Promotions
            </button>
            <div class="grid grid-cols-2 overflow-scroll max-h-[400px] gap-x-8 gap-y-6 p-4">
                @foreach ($promotions as $promotion)
                    <div class="shadow-xl rounded-xl w-full px-4 py-3 h-full">
                        <p class="text-black"><span class="font-bold">Name:</span> {{ $promotion->title }}</p>
                        <p class="text-black"><span class="font-bold">Discount:</span>
                            Rp{{ number_format($promotion->discountAmount) }}</p>
                        <p class="text-black"><span class="font-bold">Start Date:</span>
                            {{ \Carbon\Carbon::parse($promotion->startDate)->format('d-m-Y') }}</p>
                        <p class="text-black"><span class="font-bold">End Date:</span>
                            {{ \Carbon\Carbon::parse($promotion->endDate)->format('d-m-Y') }}</p>
                        <div class="flex gap-x-2">
                            <button type="button" id="{{ $promotion->id }}" data-twe-toggle="modal"
                                data-twe-target="#editModal" data-title="{{ $promotion->title }}"
                                data-discount="{{ $promotion->discountAmount }}" data-start="{{ $promotion->startDate }}"
                                data-end="{{ $promotion->endDate }}"
                                class="edit-button w-3/4 px-4 text-sm mt-2 bg-warning text-white py-1 rounded h-[30px] font-semibold transition">
                                <i class="fa-solid fa-pen text-white"></i>
                            </button>
                            <button type="button" onclick="deletePromotion('{{ $promotion->id }}')"
                                class="w-1/4 px-4 text-sm mt-2 bg-danger text-white py-1 rounded h-[30px] font-semibold transition">
                                <i class="fa-solid fa-trash text-white"></i>
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
                        Create Promotion
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
                <div class="grid grid-cols-2 gap-4 p-4">
                    <div class="w-full col-span-2">
                        <p>Title</p>
                        <input type="text" id="create-name" class="w-full border border-black p-2 h-[35px]">
                    </div>
                    <div class="w-full">
                        <p>Discount Amount</p>
                        <input type="number" id="create-discount" class="w-full border border-black p-2 h-[35px]">
                    </div>
                    <div class="w-full">
                        <p>Start Date</p>
                        <input type="date" id="create-start" class="w-full border border-black p-2 h-[35px]">
                    </div>
                    <div class="w-full">
                        <p>End Date</p>
                        <input type="date" id="create-end" class="w-full border border-black p-2 h-[35px]">
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
                    <button type="button" id="store"
                        class="ms-1 inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out"
                        data-twe-ripple-init data-twe-ripple-color="light">
                        Create Promotion
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div data-twe-modal-init
        class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
        id="editModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true" role="dialog">
        <div data-twe-modal-dialog-ref
            class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
            <div
                class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none">
                <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 p-4">
                    <!-- Modal title -->
                    <h5 class="text-xl font-bold leading-normal text-surface" id="exampleModalCenterTitle">
                        Edit Promotion
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
                <div class="grid grid-cols-2 gap-4 p-4">
                    <input type="hidden" id="edit-id">
                    <div class="w-full col-span-2">
                        <p>Title</p>
                        <input type="text" id="edit-title" class="w-full border border-black p-2 h-[35px]">
                    </div>
                    <div class="w-full">
                        <p>Discount Amount</p>
                        <input type="number" id="edit-discount" class="w-full border border-black p-2 h-[35px]">
                    </div>
                    <div class="w-full">
                        <p>Start Date</p>
                        <input type="date" id="edit-start" class="w-full border border-black p-2 h-[35px]">
                    </div>
                    <div class="w-full">
                        <p>End Date</p>
                        <input type="date" id="edit-end" class="w-full border border-black p-2 h-[35px]">
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
                    <button type="button" id="submit-edit"
                        class="ms-1 inline-block rounded bg-[var(--primary)] px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out"
                        data-twe-ripple-init data-twe-ripple-color="light">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function deletePromotion(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showDenyButton: true,
                confirmButtonColor: '#3085d6',
                denyButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{ route('admin.promotion.delete', '') }}/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                'Content-Type': 'application/json',
                            },
                        }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'The program has been deleted.',
                                }).then(() => {
                                    location.reload();
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: data.message || 'Something went wrong!',
                                });
                            }
                        }).catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: error.message || 'Something went wrong!',
                            })
                        })
                }
            })
        }

        $("#store").on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Create Promotion",
                text: "Are you sure to create this promotion?",
                icon: 'question',
                showDenyButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    const name = document.getElementById('create-name').value;
                    const discount = document.getElementById('create-discount').value;
                    const start = document.getElementById('create-start').value;
                    const end = document.getElementById('create-end').value;
                    fetch(`{{ route('admin.promotion.store') }}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            },
                            body: JSON.stringify({
                                'title': name,
                                'discountAmount': discount,
                                'startDate': start,
                                'endDate': end,
                            })
                        }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: data.message,
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: data.error,
                                });
                            }
                        });
                }
            });
        });

        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.id;
                const title = this.getAttribute('data-title');
                const discount = this.getAttribute('data-discount');
                const start = this.getAttribute('data-start');
                const end = this.getAttribute('data-end');


                document.getElementById('edit-id').value = id;
                document.getElementById('edit-title').value = title;
                document.getElementById('edit-discount').value = discount;
                document.getElementById('edit-start').value = start;
                document.getElementById('edit-end').value = end;

            });
        });

        $("#submit-edit").on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Edit Promotion Data",
                text: "Are you sure you want to save the changes?",
                icon: 'question',
                showDenyButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    const id = document.getElementById('edit-id').value;
                    fetch(`{{ route('admin.promotion.update', '') }}/${id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            },
                            body: JSON.stringify({
                                "title": document.getElementById('edit-title').value,
                                "discountAmount": document.getElementById('edit-discount')
                                    .value,
                                "startDate": document.getElementById('edit-start').value,
                                "endDate": document.getElementById('edit-end').value,
                            })
                        }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: data.message,
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: data.message,
                                });
                            }
                        }).catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: error.message || 'Something went wrong!',
                            });
                        });
                }
            });
        });
    </script>
@endsection
