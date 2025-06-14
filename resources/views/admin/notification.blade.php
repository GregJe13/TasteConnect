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
        <div class="w-full max-w-3xl bg-white p-8 shadow-lg rounded-md">
            <h2 class="text-2xl font-bold text-center mb-6">Send Personalized Promotion</h2>

            <div class="flex gap-x-8 w-full">
                <div
                    class="w-full border-2 border-[var(--primary)] rounded-lg p-4 gap-y-4 flex flex-col max-h-[380px] overflow-y-scroll">
                    <h1 class="font-semibold text-2xl text-center">Customer List</h1>
                    @foreach ($customers as $i => $customer)
                        <div class="shadow-md rounded-xl w-full px-4 py-3 h-fit">
                            <p class="font-medium"><i class="fa-solid fa-user mr-2"></i>{{ $customer->name }}
                            </p>
                            <p class="font-medium"><i class="fa-solid fa-envelope mr-2"></i>{{ $customer->email }}
                            </p>
                            <div class="flex items-center gap-x-2">
                                <input id="{{ 'customerCheck' . $i }}" type="checkbox" name="customer_check[]"
                                    value="{{ $customer->id }}" class="w-[15px] h-[15px] hover:cursor-pointer">
                                <label for="{{ 'customerCheck' . $i }}" class=" hover:cursor-pointer">Select</label>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div
                    class="w-full border-2 border-[var(--primary)] rounded-lg p-4 gap-y-4 flex flex-col max-h-[380px] overflow-y-scroll">
                    <h1 class="font-semibold text-2xl text-center">Promotion List</h1>
                    @foreach ($promotions as $i => $promotion)
                        <div class="shadow-md rounded-xl w-full px-4 py-3 h-fit">
                            <p class="font-medium"><i class="fa-solid fa-user mr-2"></i>{{ $promotion->title }}
                            </p>
                            <p class="font-medium"><i
                                    class="fa-solid fa-money-bill mr-2"></i>{{ number_format($promotion->discountAmount) }}
                            </p>
                            <div class="flex items-center gap-x-2">
                                <input id="{{ 'promotionCheck' . $i }}" type="radio" name="promotion_check"
                                    value="{{ $promotion->id }}" class="w-[15px] h-[15px] hover:cursor-pointer">
                                <label for="{{ 'promotionCheck' . $i }}" class=" hover:cursor-pointer">Select</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <button type="button" id="sendPromotion"
                class="w-full px-4 text-sm mt-4 bg-[var(--primary)] text-white py-3 rounded font-semibold transition">
                Send Personalized Promotion
            </button>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $("#sendPromotion").on('click', function() {
                Swal.fire({
                    title: 'Send Notification?',
                    text: "This action cannot be undone. Do you want to proceed?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, send it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let customers = [];
                        let customerCheck = document.getElementsByName('customer_check[]');
                        for (let i = 0; i < customerCheck.length; i++) {
                            if (customerCheck[i].checked) {
                                customers.push(customerCheck[i].value);
                            }
                        }
                        if (customers.length === 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Please select at least one customer and one promotion',
                            });
                        } else {

                            fetch(`{{ route('admin.notification.store') }}`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        customers: customers,
                                        promotion_id: document.querySelector(
                                                'input[name="promotion_check"]:checked')
                                            ?.value,
                                    })
                                }).then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success',
                                            text: data.message,
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: data.message,
                                        });
                                    }
                                }).catch(error => {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Something went wrong',
                                    });
                                });
                        }
                    }
                });
            });

        });
    </script>
@endsection
