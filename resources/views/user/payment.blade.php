@extends('user.layout')

@section('content')
    <section class="w-screen py-32 px-16">
        <div
            class="max-w-4xl mx-auto p-6 bg-white shadow-lg shadow-[var(--primary)] rounded-lg mt-10 border-0 border-[var(--contrast3)]">
            <button type="button" onclick="window.location.href = '{{ route('index') }}'"
                class="w-fit px-4 text-sm mb-4 bg-[var(--primary)] text-white py-2 rounded font-semibold transition">
                Back
            </button>
            <h1 class="text-2xl font-bold text-[var(--contrast)] mb-6">Delivery Address</h1>
            <!-- List of Payment Methods -->
            <div class="space-y-4">
                <div
                    class="p-4 bg-gray-100 rounded-lg border-2 hover:border-[var(--primary)] border-[var(--primary)] transition hover:cursor-pointer">
                    <div class="">
                        <input type="text" name="address" id="address" placeholder="Where shall we deliver?"
                            class="w-full border border-gray-300 p-3 wfu rounded focus:outline-none focus:ring focus:ring-blue-300">
                    </div>
                </div>
                <h1 class="text-2xl font-bold text-[var(--contrast)] mb-6">Select Your Payment Method</h1>

                <!-- Bank Transfer -->
                <div
                    class="p-4 bg-gray-100 rounded-lg border hover:border-[var(--primary)] transition hover:cursor-pointer">
                    <label class="flex items-center hover:cursor-pointer">
                        <input type="radio" name="method" value="Bank Transfer" class="mr-4">
                        <div class="">
                            <h2 class="text-lg font-semibold">Bank Transfer</h2>
                            <p class=" text-gray-600">Available for BCA, Mandiri, BRI, BNI</p>
                            <p class=" text-gray-600">VA Number: <b>1920912490124712</b></p>
                        </div>
                    </label>
                </div>

                <!-- E-Wallets -->
                <div
                    class="p-4 bg-gray-100 rounded-lg border hover:border-[var(--primary)] transition hover:cursor-pointer">
                    <label class="flex items-center hover:cursor-pointer">
                        <input type="radio" name="method" value="GoPay" class="mr-4">
                        <div class="">
                            <h2 class="text-lg font-semibold">GoPay</h2>
                        </div>
                    </label>
                </div>

                <div
                    class="p-4 bg-gray-100 rounded-lg border hover:border-[var(--primary)] transition hover:cursor-pointer">
                    <label class="flex items-center hover:cursor-pointer">
                        <input type="radio" name="method" value="OVO" class="mr-4">
                        <div class="">
                            <h2 class="text-lg font-semibold">OVO</h2>
                        </div>
                    </label>
                </div>

                <div
                    class="p-4 bg-gray-100 rounded-lg border hover:border-[var(--primary)] transition hover:cursor-pointer">
                    <label class="flex items-center hover:cursor-pointer">
                        <input type="radio" name="method" value="ShopeePay" class="mr-4">
                        <div class="">
                            <h2 class="text-lg font-semibold">ShopeePay</h2>
                        </div>
                    </label>
                </div>

                <!-- Cash on Delivery -->
                <div
                    class="p-4 bg-gray-100 rounded-lg border hover:border-[var(--primary)] transition hover:cursor-pointer">
                    <label class="flex items-center hover:cursor-pointer">
                        <input type="radio" name="method" value="Cash on Delivery" class="mr-4">
                        <div class="">
                            <h2 class="text-lg font-semibold">Cash on Delivery</h2>
                            <p class="text-sm text-gray-600">Pay directly to the courier upon receiving the foods.</p>
                        </div>
                    </label>
                </div>

                <!-- Credit/Debit Card -->
                <div
                    class="p-4 bg-gray-100 rounded-lg border hover:border-[var(--primary)] transition hover:cursor-pointer">
                    <label class="flex items-center hover:cursor-pointer">
                        <input type="radio" name="method" value="Credit/Debit Card" class="mr-4">
                        <div class="">
                            <h2 class="text-lg font-semibold">Credit/Debit Card</h2>
                            <p class="text-sm text-gray-600">Visa, MasterCard, etc.</p>
                        </div>
                    </label>
                </div>

                <div
                    class="p-4 bg-gray-100 rounded-lg border hover:border-[var(--primary)] transition hover:cursor-pointer">
                    <label class="flex items-center hover:cursor-pointer">
                        <input type="radio" name="method" value="LinkAja" class="mr-4">
                        <div class="">
                            <h2 class="text-lg font-semibold">LinkAja</h2>
                        </div>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="button" id="submit"
                        class="w-full bg-[var(--primary)] text-white py-3 rounded-lg font-semibold transition">
                        Confirm Payment
                    </button>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const submit = document.getElementById('submit');
            const methods = document.querySelectorAll('input[name="method"]');

            submit.addEventListener('click', function() {
                Swal.fire({
                    title: "Payment Confirmation",
                    text: "Are you sure to proceed with this payment method?",
                    icon: 'question',
                    showDenyButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        let selectedMethod = null;

                        methods.forEach(method => {
                            if (method.checked) {
                                selectedMethod = method.value;
                            }
                        });

                        if (selectedMethod) {
                            fetch(`{{ route('payment.store') }}`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    },
                                    body: JSON.stringify({
                                        method: selectedMethod,
                                        address: document.getElementById('address')
                                            .value,
                                    }),
                                })
                                .then(response => response.json())
                                .then(response => {
                                    if (response.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Payment Success!',
                                            text: 'Order created successfully!',
                                        }).then(() => {
                                            window.location.href =
                                                '{{ route('index') }}';
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: response.message,
                                        });
                                    }
                                })
                                .catch(() => {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Unable to process the request.',
                                    });
                                });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Please select a payment method!',
                            });
                        }
                    } else {
                        return;
                    }
                });
            });
        });
    </script>
@endsection
