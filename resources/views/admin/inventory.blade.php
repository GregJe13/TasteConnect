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
            <h2 class="text-3xl font-bold text-center mb-6">Manage Inventory</h2>
            <button data-twe-target="#createModal" data-twe-toggle="modal"
                class="w-fit mb-4 px-4 text-sm bg-[var(--primary)] text-white py-3 rounded hover:bg-blue-700 transition">
                Add New Item
            </button>
            <div class="w-full grid grid-cols-3 gap-4 cart-item-container">
                @foreach ($inventories as $inventory)
                    <div class="shadow-xl rounded-lg flex p-4 gap-x-4 w-full" id="{{ 'cart-' . $inventory->id }}">
                        <div class="w-full">
                            <p class="font-semibold text-lg">{{ $inventory->name }}</p>
                            <p class="font-medium"><i class="fa-solid fa-layer-group mr-2"></i>{{ $inventory->stock }}</p>
                            <div class="flex justify-between items-center mt-2 w-full">
                            </div>
                            <div class="flex gap-x-2">
                                <button type="button" data-twe-target="#editModal" data-twe-toggle="modal"
                                    id="{{ $inventory->id }}" data-name="{{ $inventory->name }}"
                                    data-stock="{{ $inventory->stock }}" data-price="{{ $inventory->price }}"
                                    class="edit-button w-fit px-4 text-sm mt-1 bg-warning text-white py-2 rounded font-semibold transition">
                                    Edit
                                </button>
                                <button type="button" onclick="deleteData('{{ $inventory->id }}')"
                                    class="w-fit px-4 text-sm mt-1 bg-danger text-white py-2 rounded font-semibold transition">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
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
                <div class="grid grid-cols-2 gap-4 p-4">
                    <div class="w-full">
                        <p>Name</p>
                        <input type="text" id="create-name" class="w-full border border-black p-2 h-[35px]">
                    </div>
                    <div class="w-full">
                        <p>Stock</p>
                        <input type="number" id="create-stock" class="w-full border border-black p-2 h-[35px]">
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
                    <button type="button" id="store"
                        class="ms-1 inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out"
                        data-twe-ripple-init data-twe-ripple-color="teal">
                        Add Item
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
                class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none dark:bg-surface-dark">
                <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 p-4">
                    <!-- Modal title -->
                    <h5 class="text-xl font-medium leading-normal text-surface" id="exampleModalCenterTitle">
                        Edit Item Data
                    </h5>
                    <!-- Close button -->
                    <button type="button"
                        class="box-content rounded-none border-none text-neutral-500 hover:text-neutral-800 hover:no-underline focus:text-neutral-800 focus:opacity-100 focus:shadow-none focus:outline-none dark:text-neutral-400 dark:hover:text-neutral-300 dark:focus:text-neutral-300"
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
                    <div class="w-full">
                        <p>Name</p>
                        <input type="text" id="edit-name" class="w-full border border-black p-2 h-[35px]">
                    </div>
                    <div class="w-full">
                        <p>Stock</p>
                        <input type="number" id="edit-stock" class="w-full border border-black p-2 h-[35px]">
                    </div>
                </div>

                <!-- Modal footer -->
                <div
                    class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 p-4">
                    <button type="button"
                        class="inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:bg-primary-accent-200 focus:bg-primary-accent-200 focus:outline-none focus:ring-0 active:bg-primary-accent-200"
                        data-twe-modal-dismiss data-twe-ripple-init data-twe-ripple-color="teal">
                        Close
                    </button>
                    <button type="button" id="submit-edit"
                        class="ms-1 inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2"
                        data-twe-ripple-init data-twe-ripple-color="teal">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.id;
                const name = this.getAttribute('data-name');
                const stock = this.getAttribute('data-stock');


                document.getElementById('edit-id').value = id;
                document.getElementById('edit-name').value = name;
                document.getElementById('edit-stock').value = stock;

            });
        });

        function deleteData(id) {
            Swal.fire({
                title: "Delete Data",
                text: "Are you sure you want to delete this item?",
                icon: 'question',
                showDenyButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{ route('admin.inventory.destroy', '') }}/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            }
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
            })
        }
        $("#submit-edit").on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Edit inventory Data",
                text: "Are you sure you want to save the changes?",
                icon: 'question',
                showDenyButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    const id = document.getElementById('edit-id').value;
                    fetch(`{{ route('admin.inventory.update', '') }}/${id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            },
                            body: JSON.stringify({
                                'name': document.getElementById('edit-name').value,
                                'stock': document.getElementById('edit-stock')
                                    .value,
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
        $("#store").on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Edit inventory Data",
                text: "Are you sure you want to save the changes?",
                icon: 'question',
                showDenyButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    const id = document.getElementById('edit-id').value;
                    fetch(`{{ route('admin.inventory.store') }}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            },
                            body: JSON.stringify({
                                'name': document.getElementById('create-name')
                                    .value,
                                'stock': document.getElementById('create-stock')
                                    .value,
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
        })
    </script>
@endsection
