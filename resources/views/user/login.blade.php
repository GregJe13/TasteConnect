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
    @if (session()->has('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
            })
        </script>
    @endif
    <section class="w-screen h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white p-8 shadow-lg rounded-md">
            <h2 class="text-2xl font-bold text-center mb-6">Login</h2>
            <form action="{{ route('auth') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="text" id="email" name="email"
                        class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring focus:ring-blue-300"
                        placeholder="Enter your email" required>
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                    <input type="password" id="password" name="password"
                        class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring focus:ring-blue-300"
                        placeholder="Enter your password" required>
                </div>
                <button type="submit"
                    class="w-full bg-[var(--primary)] text-white py-3 rounded hover:bg-blue-700 transition">
                    Login
                </button>
                <p class="text-sm font-light text-gray-500 dark:text-gray-400 mt-3">
                      Don’t have an account yet? <a href="{{ route('register') }}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign up</a>
                  </p>
            </form>
        </div>
    </section>
@endsection
