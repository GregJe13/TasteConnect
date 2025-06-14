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
        <div class="w-full max-w-md bg-white p-8 shadow-lg rounded-md">
            <input type="hidden" id="id" value="{{ $program->id }}">
            <h2 class="text-2xl font-bold text-center mb-6">Loyalty Program Details</h2>
            <div class="mb-6">
                <label for="name" class="block text-gray-700 font-medium mb-1">Name</label>
                <input type="text" id="name" name="name" value="{{ $program->name }}"
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300">
            </div>
            <div class="mb-6">
                <label for="point" class="block text-gray-700 font-medium mb-1">Point</label>
                <input type="text" id="point" name="point" value="{{ $program->point }}"
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300">
            </div>
            <div class="mb-6">
                <label for="start_date" class="block text-gray-700 font-medium mb-1">Start Date</label>
                <input type="date" id="start_date" name="start_date" value="{{ $program->startDate }}"
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300">
            </div>
            <div class="mb-6">
                <label for="end_date" class="block text-gray-700 font-medium mb-1">Start Date</label>
                <input type="date" id="end_date" name="end_date" value="{{ $program->endDate }}"
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300">
            </div>
            <div class="mb-6">
                <label for="reward" class="block text-gray-700 font-medium mb-1">Reward</label>
                <textarea type="text" id="reward" name="reward"
                    class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring focus:ring-blue-300">
                    {{ $program->reward }}
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

                fetch(`{{ route('admin.loyalty.update', '') }}/${id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        body: JSON.stringify({
                            name: $('#name').val(),
                            point: $('#point').val(),
                            startDate: $('#start_date').val(),
                            endDate: $('#end_date').val(),
                            reward: $('#reward').val(),
                        })
                    }).then(response => response.json())
                    .then(response => {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                            }).then(() => {
                                location.href ="{{ route('admin.loyalty') }}";
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
        });
    </script>
@endsection
