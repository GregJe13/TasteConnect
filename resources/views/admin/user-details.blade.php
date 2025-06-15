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
    <section class="w-screen min-h-screen flex items-center justify-center bg-gray-100 pt-24 pb-12 px-6">
        <div class="w-full max-w-md bg-white p-8 shadow-lg rounded-md">
            <input type="hidden" id="id" value="{{ $customer->id }}">
            <h2 class="text-2xl font-bold text-center mb-6">{{ $customer->name }}'s Profile</h2>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-1">Email<i
                        class="fa-solid fa-pencil ml-2 hover:cursor-pointer text-neutral-500" id="label-email"></i></label>
                <input type="email" id="email" name="email" value="{{ $customer->email }}" disabled
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300">
            </div>
            <div class="mb-6">
                <label for="name" class="block text-gray-700 font-medium mb-1">Name<i
                        class="fa-solid fa-pencil ml-2 hover:cursor-pointer text-neutral-500" id="label-name"></i></label>
                <input type="text" id="name" name="name" value="{{ $customer->name }}" disabled
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300">
            </div>
            <div class="mb-6">
                <label for="phone" class="block text-gray-700 font-medium mb-1">Phone Number<i
                        class="fa-solid fa-pencil ml-2 hover:cursor-pointer text-neutral-500" id="label-phone"></i></label>
                <input type="text" id="phone" name="phone" value="{{ $customer->phoneNum }}" disabled
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300">
            </div>
            <div class="mb-6">
                <label for="point" class="block text-gray-700 font-medium mb-1">Loyalty Point<i
                        class="fa-solid fa-pencil ml-2 hover:cursor-pointer text-neutral-500" id="label-point"></i></label>
                <input type="text" id="point" name="point" value="{{ $customer->loyaltyPoint }}" disabled
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300">
            </div>
            <div class="mb-6">
                <label for="address" class="block text-gray-700 font-medium mb-1">Address<i
                        class="fa-solid fa-pencil ml-2 hover:cursor-pointer text-neutral-500"
                        id="label-address"></i></label>
                <textarea type="text" id="address" name="address" disabled
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300">
                    {{ $customer->address }}
                </textarea>
            </div>
            <button id="save" class="w-full bg-[var(--primary)] text-white py-3 rounded hover:bg-blue-700 transition">
                Update
            </button>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#save').on('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: "Saving...",
                    allowOutSideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                const id = $('#id').val();

                fetch(`{{ route('admin.customer.update', '') }}/${id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        body: JSON.stringify({
                            email: $('#email').val(),
                            phoneNum: $('#phone').val(),
                            name: $('#name').val(),
                            address: $('#address').val(),
                            loyaltyPoint: $('#point').val(),
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

            $("#label-name").on('click', function() {
                $("#name").prop("disabled", false);
                $("#name").focus();
            });

            $("#label-email").on('click', function() {
                $("#email").prop("disabled", false);
                $("#email").focus();
            });
            $("#label-phone").on('click', function() {
                $("#phone").prop("disabled", false);
                $("#phone").focus();
            });
            $("#label-address").on('click', function() {
                $("#address").prop("disabled", false);
                $("#address").focus();
            });
            $("#label-point").on('click', function() {
                $("#point").prop("disabled", false);
                $("#point").focus();
            });
        });
    </script>
@endsection
