<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex justify-between items-center">
            <span>{{ __('Blacklisted Workers') }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-full">
                    <h1 class="text-2xl font-semibold mb-4">Blacklisted Workers</h1>

                    <a href="{{ route('blacklisted.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        {{ __('Add New') }}
                    </a>

                    @if(session('success'))
                        <p class="text-green-600 font-semibold mb-4">{{ session('success') }}</p>
                    @endif

                    <div class="overflow-x-auto mt-4">
                        <table class="table-auto w-full border-collapse border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100 text-left">
                                    <th class="border px-4 py-2">Name</th>
                                    <th class="border px-4 py-2">Email</th>
                                    <th class="border px-4 py-2">Phone</th>
                                    <th class="border px-4 py-2">Reason</th>
                                    <th class="border px-4 py-2">Proof</th>
                                    <th class="border px-4 py-2">Reported By</th>
                                    <th class="border px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($workers as $worker)
                                    <tr class="border-b">
                                        <td class="border px-4 py-2">{{ $worker->name }}</td>
                                        <td class="border px-4 py-2">{{ $worker->email }}</td>
                                        <td class="border px-4 py-2">{{ $worker->phone }}</td>
                                        <td class="border px-4 py-2">{{ $worker->reason }}</td>
                                        <td class="border px-4 py-2">
                                            @if($worker->proof)
                                                <button onclick="openModal('{{ asset('storage/' . $worker->proof) }}')" class="text-blue-500 hover:underline">
                                                    View Proof
                                                </button>
                                            @else
                                                <span class="text-gray-500">No Proof</span>
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2">{{ $worker->reporter->name ?? 'Unknown' }}</td>
                                        <td class="border px-4 py-2 space-x-2">
                                            @if($worker->approved)
                                                <span class="text-green-500 font-semibold">Approved</span>
                                            @else
                                                <form method="POST" action="{{ route('blacklisted.approve', $worker->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" onclick="return confirm('Approve this worker?')" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                                        Approve
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('blacklisted.reject', $worker->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" onclick="return confirm('Reject this worker?')" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                                        Reject
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-gray-500">No blacklisted workers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $workers->links() }}
                    </div>
                </div>

                <!-- Modal -->
                <div id="proofModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 items-center justify-center">
                    <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full p-4 relative">
                        <button onclick="closeModal()" class="absolute top-2 right-2 text-2xl font-bold text-gray-600 hover:text-black">&times;</button>
                        <h2 class="text-xl font-semibold mb-4">Proof Image</h2>
                        <img id="modalImage" src="" alt="Proof" class="w-full h-auto rounded border">
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function openModal(imageUrl) {
            const modal = document.getElementById('proofModal');
            const img = document.getElementById('modalImage');
            img.src = imageUrl;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('proofModal');
            const img = document.getElementById('modalImage');
            img.src = '';
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        // Optional: Close modal when clicking outside the image area
        document.getElementById('proofModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
</x-app-layout>
