@extends('admin.layout')

@section('content')
    <section class="w-screen min-h-screen flex items-center justify-center bg-gray-100 py-24">
        <div class="w-full max-w-lg bg-white p-8 shadow-lg rounded-md">
            <h2 class="text-3xl font-bold text-center mb-6">Add New Menu</h2>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Menu Name</label>
                    <input type="text" id="name" name="name"
                        class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring focus:ring-blue-300"
                        placeholder="e.g., Spaghetti Carbonara" required value="{{ old('name') }}">
                </div>
                <div class="mb-4">
                    <label for="stock" class="block text-gray-700 font-medium mb-2">Stock Quantity</label>
                    <input type="number" id="stock" name="stock"
                        class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring focus:ring-blue-300"
                        placeholder="e.g., 50" required value="{{ old('stock') }}">
                </div>
                <div class="mb-4">
                    <label for="price" class="block text-gray-700 font-medium mb-2">Price</label>
                    <input type="number" id="price" name="price"
                        class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring focus:ring-blue-300"
                        placeholder="e.g., 85000" required value="{{ old('price') }}">
                </div>
                <div class="mb-6">
                    <label for="image" class="block text-gray-700 font-medium mb-2">Menu Image</label>
                    <input type="file" id="image" name="image"
                        class="w-full text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                        required>
                    <p class="mt-1 text-sm text-gray-500">PNG, JPG, GIF, or SVG (MAX. 2MB).</p>
                </div>
                <div class="flex gap-x-4">
                    <a href="{{ route('admin.menu.index') }}"
                        class="w-full text-center bg-gray-500 text-white py-3 rounded hover:bg-gray-600 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="w-full bg-[var(--primary)] text-white py-3 rounded hover:bg-blue-700 transition">
                        Add Menu
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
