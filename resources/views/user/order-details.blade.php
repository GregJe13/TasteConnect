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
    <section class="w-screen min-h-screen flex items-center justify-center bg-gray-100 py-24">
        <div class="w-full max-w-2xl bg-white p-8 shadow-lg rounded-md">
            <h2 class="text-2xl font-bold text-center mb-6">Order Details</h2>
            <div class="flex justify-between w-full">
                <p class="text-lg font-bold">
                    {{ \Carbon\Carbon::parse($order->orderDate)->format('l, d F Y') }}</p>
                <p class="text-lg font-bold">
                    {{ \Carbon\Carbon::parse($order->orderDate)->format('H:i') }}</p>
            </div>
            @if ($order->status == 0)
                <p class="font-semibold text-lg text-yellow-700">Your order is being processed.</p>
            @elseif ($order->status == 1)
                <p class="font-semibold text-lg text-blue-700">Your order is on the way.</p>
            @elseif ($order->status == 2 || $order->status == 4)
                <p class="font-semibold text-lg text-green-700">This order has been completed.</p>
                @if ($order->status == 2)
                    <div class="mt-3">
                        <p class="font-semibold text-lg text-[var(--primary)]">Rate your order</p>
                        <div class="flex" id="star-container">
                            <i class="fa-regular fa-star text-2xl text-yellow-500" data-index="1"></i>
                            <i class="fa-regular fa-star text-2xl text-yellow-500" data-index="2"></i>
                            <i class="fa-regular fa-star text-2xl text-yellow-500" data-index="3"></i>
                            <i class="fa-regular fa-star text-2xl text-yellow-500" data-index="4"></i>
                            <i class="fa-regular fa-star text-2xl text-yellow-500" data-index="5"></i>
                        </div>
                        <textarea name="comment" id="" cols="32" rows="5"
                            class="border-2 border-[var(--primary)] rounded focus:outline-none p-2 mt-2"
                            placeholder="Insert your comment here..."></textarea>
                    </div>
                    <button type="button" onclick="submitFeedback('{{ $order->id }}')"
                        class="w-fit px-4 text-sm mt-1 bg-[var(--primary)] text-white py-2 rounded font-semibold transition">
                        Submit Feedback
                    </button>
                @endif
            @else
                <p class="font-semibold text-lg text-red-700">Your order has been canceled.</p>
            @endif
            <hr class="mt-4 border-[var(--primary)] border-2">
            <p class="text-lg font-bold mt-4">Total: Rp{{ number_format($order->totalAmount) }}</p>
            <div class="w-full flex flex-col gap-y-4 cart-item-container">
                @foreach ($details as $detail)
                    <div class="shadow-xl rounded-lg flex items-center p-4 gap-x-4 w-full" id="{{ 'cart-' . $detail->id }}">
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



    <script>
        const stars = document.querySelectorAll('#star-container i');

        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                // Reset all stars to their default state
                stars.forEach((s) => {
                    s.classList.remove('fa-solid');
                    s.classList.add('fa-regular');
                });

                // Set clicked star and all previous stars to solid and yellow
                for (let i = 0; i <= index; i++) {
                    stars[i].classList.remove('fa-regular');
                    stars[i].classList.add('fa-solid');
                }
            });
        });

        function submitFeedback(order_id) {
            const stars = document.querySelectorAll('#star-container i.fa-solid').length;
            const comment = document.querySelector('textarea').value;

            if (stars == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please rate your order first!',
                });
                return;
            }

            fetch(`{{ route('feedback.store') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        'order_id': order_id,
                        'rating': stars,
                        'comment': comment,
                    })
                })
                .then(response => response.json())
                .then(response => {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
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
                }).catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred while submitting your feedback.',
                    });
                });
        }
    </script>
@endsection
