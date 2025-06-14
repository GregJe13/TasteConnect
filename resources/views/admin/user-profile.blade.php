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
        @endif @if (session()->has('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                })
            </script>
        @endif
        <section class="w-screen min-h-screen flex items-center justify-center bg-gray-100 py-24">
            <div class="w-full max-w-4xl bg-white p-8 shadow-lg rounded-md">
                <h2 class="text-2xl font-bold text-center mb-6">Users Profile</h2>
                <div class="grid grid-cols-3 overflow-scroll max-h-[400px] gap-x-8 gap-y-6">
                    @foreach ($users as $user)
                        <div class="shadow-xl rounded-xl w-full px-4 py-3 h-fit">
                            <p class="text-black font-medium"><i class="fa-solid mr-2 fa-user"></i>{{ $user->name }}</p>
                            <p class="text-black font-medium"><i class="fa-solid mr-2 fa-envelope"></i>{{ $user->email }}</p>
                            <p class="text-black font-medium"><i class="fa-solid mr-2 fa-phone"></i>{{ $user->phoneNum }}</p>
                            <p class="text-black font-medium"><i
                                    class="fa-solid mr-2 fa-circle-dollar-to-slot"></i>{{ $user->loyaltyPoint }}</p>
                            <p class="text-black font-medium"><i
                                    class="fa-solid mr-2 fa-map-location-dot"></i>{{ $user->address }}</p>
                            <div class="flex gap-x-2">
                                <button type="button"
                                    onclick="window.location.href = '{{ route('admin.profile.edit', $user->id) }}'"
                                    class="w-3/4 px-4 text-sm mt-2 bg-warning text-white py-1 rounded h-[30px] font-semibold transition">
                                    <i class="fa-solid fa-pen text-white"></i>
                                </button>
                                <button type="button" onclick="deleteProfile('{{ $user->id }}')"
                                    class="w-1/4 px-4 text-sm mt-2 bg-danger text-white py-1 rounded h-[30px] font-semibold transition">
                                    <i class="fa-solid fa-trash text-white"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
        </section>

        <script>
            function deleteProfile(id) {
                Swal.fire({
                    title: 'Delete Profile?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`{{ route('admin.customer.delete', '') }}/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                }
                            }).then(res => res.json())
                            .then(res => {
                                if (res.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: res.message,
                                    }).then(() => {
                                        location.reload()
                                    })
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: res.message,
                                    })
                                }
                            }).catch(err => {
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
