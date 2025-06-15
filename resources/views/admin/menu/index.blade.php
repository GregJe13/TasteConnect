@extends('admin.layout')

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
    <section class="w-screen min-h-screen flex items-center justify-center bg-gray-100 py-24">
        <div class="w-full max-w-4xl bg-white p-8 shadow-lg rounded-md">
            <h2 class="text-3xl font-bold text-center mb-6">Manage Menus</h2>
            <a href="{{ route('admin.menu.create') }}"
                class="inline-block mb-4 px-4 text-sm bg-[var(--primary)] text-white py-3 rounded hover:bg-blue-700 transition">
                Add New Menu
            </a>
            <div class="grid grid-cols-3 overflow-y-auto max-h-[400px] gap-x-8 gap-y-6 p-4">
                @forelse ($menus as $menu)
                    <div class="shadow-xl rounded-xl w-full px-4 py-3 h-fit">
                        <img src="{{ asset('assets/' . $menu->image) }}" alt="{{ $menu->name }}"
                            class="w-full h-40 object-cover rounded mb-2">
                        <p class="text-black font-bold">{{ $menu->name }}</p>
                        <p class="text-black">Rp{{ number_format($menu->price, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-600">Stock: {{ $menu->stock }}</p>

                        <div class="mt-2 flex gap-x-2">
                            <a href="{{ route('admin.menu.edit', $menu->id) }}"
                                class="flex-1 text-center inline-block bg-amber-500 text-white px-4 py-2 rounded text-sm hover:bg-amber-600 transition">
                                Edit
                            </a>
                            <button type="button"
                                onclick="deleteMenu('{{ route('admin.menu.destroy', $menu->id) }}', '{{ $menu->name }}')"
                                class="flex-1 text-center inline-block bg-red-600 text-white px-4 py-2 rounded text-sm hover:bg-red-700 transition">
                                Delete
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="col-span-3 text-center text-gray-500">No menus found.</p>
                @endforelse
            </div>
        </div>
    </section>

    <script>
        function deleteMenu(deleteUrl, name) {
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete "${name}". You won't be able to revert this!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Gunakan URL yang sudah jadi dari parameter
                    fetch(deleteUrl, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    'Deleted!',
                                    'The menu has been deleted.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    data.message ||
                                    'An error occurred while deleting the menu.', // Menampilkan pesan error dari server
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            // Menangani error jaringan atau parsing JSON
                            Swal.fire('Error!', 'Could not connect to the server.', 'error');
                        });
                }
            })
        }
    </script>
@endsection
