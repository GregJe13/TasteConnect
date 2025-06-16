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
                    <div class="shadow-xl rounded-xl w-full px-4 py-3 h-fit" id="menu-card-{{ $menu->id }}">
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
                            <button type="button" onclick="deleteMenu('{{ $menu->id }}')"
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
        function deleteMenu(id) {
            Swal.fire({
                title: "Anda yakin?",
                text: "Item menu ini akan dihapus secara permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tentukan URL dan CSRF token
                    const url = `{{ url('admin/menu/destroy') }}/${id}`;
                    const csrfToken = '{{ csrf_token() }}';

                    // Kirim request DELETE menggunakan fetch
                    fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Hapus elemen kartu menu dari halaman
                                const menuCard = document.getElementById(`menu-card-${id}`);
                                if (menuCard) {
                                    menuCard.remove();
                                }

                                // Tampilkan pesan sukses
                                Swal.fire(
                                    'Berhasil Dihapus!',
                                    data.message,
                                    'success'
                                );
                            } else {
                                // Tampilkan pesan error jika gagal
                                Swal.fire(
                                    'Gagal!',
                                    data.message || 'Terjadi kesalahan.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error!',
                                'Terjadi kesalahan saat menghubungi server.',
                                'error'
                            );
                        });
                }
            });
        }
    </script>
@endsection
