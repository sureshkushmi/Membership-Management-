<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pending Members') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h1 class="text-2xl font-semibold">Pending Members</h1>

                @if(session('success'))
                    <p class="text-green-600">{{ session('success') }}</p>
                @endif

                <div class="overflow-x-auto">
                    <table class="table-auto w-full mt-4 border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2 text-left">Name</th>
                                <th class="border px-4 py-2 text-left">Email</th>
                                <th class="border px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingMembers as $member)
                                <tr class="border-b">
                                    <td class="border px-4 py-2">{{ $member->name }}</td>
                                    <td class="border px-4 py-2">{{ $member->email }}</td>
                                    <td class="border px-4 py-2">
                                        <!-- View Button -->
                                        <button type="button"
                                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none"
                                            data-bs-toggle="modal"
                                            data-bs-target="#memberModal{{ $member->id }}">
                                            View
                                        </button>

                                        <!-- Approve Form -->
                                        <form method="POST" action="{{ route('superadmin.approve-member', $member->id) }}" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none">
                                                Approve
                                            </button>
                                        </form>

                                        <!-- Reject Form -->
                                        <form method="POST" action="{{ route('superadmin.reject-member', $member->id) }}" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none" onclick="return confirm('Are you sure?')">
                                                Reject
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="memberModal{{ $member->id }}" tabindex="-1" aria-labelledby="memberModalLabel{{ $member->id }}" aria-hidden="true">
                                  <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="memberModalLabel{{ $member->id }}">Member Details - {{ $member->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
    <ul class="list-group mb-4">
        <li class="list-group-item"><strong>Name:</strong> {{ $member->name }}</li>
        <li class="list-group-item"><strong>Email:</strong> {{ $member->email }}</li>
        <li class="list-group-item"><strong>Phone:</strong> {{ $member->phone ?? 'N/A' }}</li>
        <li class="list-group-item"><strong>Address:</strong> {{ $member->address ?? 'N/A' }}</li>
        <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($member->status) }}</li>
        <li class="list-group-item"><strong>Role:</strong> {{ ucfirst($member->role) }}</li>
        <li class="list-group-item"><strong>Registered At:</strong> {{ $member->created_at->format('F j, Y h:i A') }}</li>
    </ul>

                                                {{-- Uploaded Documents Section --}}
                                                
                                            @php
                                                $docs = [];

                                                if (!empty($member->document)) {
                                                    $json = json_decode($member->document, true);
                                                    $docs = is_array($json) ? $json : explode(',', $member->document);
                                                    $docs = array_filter(array_map('trim', $docs)); // remove empty strings
                                                }
                                            @endphp

                                            @if(count($docs))
                                                <ul class="list-unstyled">
                                                    @foreach($docs as $doc)
                                                        @php $ext = pathinfo($doc, PATHINFO_EXTENSION); @endphp

                                                        <li class="mb-2">
                                                            @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']))
                                                                <img src="{{ asset('storage/documents/' . $doc) }}" alt="Document" class="img-thumbnail w-50 mb-1">
                                                            @else
                                                                <a href="{{ asset('storage/documents/' . $doc) }}" target="_blank" class="text-primary">
                                                                    {{ $doc }}
                                                                </a>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p class="text-muted">No documents uploaded.</p>
                                            @endif


                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
