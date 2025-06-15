@extends('admin.layout')

@section('content')
    <section class="w-screen min-h-screen flex items-center justify-center bg-gray-100 py-24">
        <div class="w-full max-w-lg bg-white p-8 shadow-lg rounded-md">
            <h2 class="text-3xl font-bold text-center mb-6">Edit Menu: {{ $menu->name }}</h2>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Arahkan action ke route 'update' dan gunakan method PUT --}}
            <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') {{-- Penting untuk update --}}

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Menu Name</label>
                    {{-- Isi value dengan data yang ada --}}
                    <input type="text" id="name" name="name"
                        class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring focus:ring-blue-300"
                        required value="{{ old('name', $menu->name) }}">
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-gray-700 font-medium mb-2">Price</label>
                    <input type="number" id="price" name="price"
                        class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring focus:ring-blue-300"
                        required value="{{ old('price', $menu->price) }}">
                </div>

                <div class="mb-4">
                    <label for="stock" class="block text-gray-700 font-medium mb-2">Stock Quantity</label>
                    <input type="number" id="stock" name="stock"
                        class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring focus:ring-blue-300"
                        required value="{{ old('stock', $menu->stock) }}">
                </div>

                <div class="mb-6">
                    <label for="image" class="block text-gray-700 font-medium mb-2">New Menu Image (Optional)</label>
                    <div class="mb-2">
                        <p class="text-sm">Current Image:</p>
                        <img src="{{ asset('assets/' . $menu->image) }}" alt="{{ $menu->name }}"
                            class="w-32 h-32 object-cover rounded">
                    </div>
                    <input type="file" id="image" name="image"
                        class="w-full text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                    <p class="mt-1 text-sm text-gray-500">Leave blank to keep the current image.</p>
                </div>

                <div class="flex gap-x-4">
                    <a href="{{ route('admin.menu.index') }}"
                        class="w-full text-center bg-gray-500 text-white py-3 rounded hover:bg-gray-600 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="w-full bg-amber-500 text-white py-3 rounded hover:bg-amber-600 transition">
                        Update Menu
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
