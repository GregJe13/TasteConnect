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
        <div class="w-full max-w-2xl bg-white p-8 shadow-lg rounded-md">
            <h2 class="text-2xl font-bold text-center mb-6">Order Details</h2>
                <p class="text-lg font-bold ml-2">Total: Rp{{ number_format($order->totalAmount) }}</p>
                <div class="w-full flex flex-col gap-y-4 cart-item-container">
                    @foreach ($details as $detail)
                        <div class="shadow-xl rounded-lg flex p-4 gap-x-4 w-full" id="{{ 'cart-' . $detail->id }}">
                            <img src="{{ asset('assets/' . $detail->menu->image) }}" class="max-w-[110px] rounded">
                            <div class="w-full">
                                <p class="font-semibold text-lg">{{ $detail->menu->name }}</p>
                                <p class="font-medium">{{ $detail->quantity }} x
                                    Rp{{ number_format($detail->menu->price) }}
                                </p>
                                <p class="font-medium">Rp{{ number_format($detail->price) }}</p>
                                <div class="flex justify-between items-center mt-2 w-full">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
        </div>
    </section>



    <script></script>
@endsection
