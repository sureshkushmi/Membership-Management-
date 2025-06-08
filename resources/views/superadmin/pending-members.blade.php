<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pending Members</h2>
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
                                        <!-- View Modal Trigger -->
                                        <button type="button"
                                            class="px-2 py-1 bg-blue-600 text-white rounded"
                                            data-bs-toggle="modal"
                                            data-bs-target="#memberModal{{ $member->id }}">
                                            View
                                        </button>

                                        <!-- Edit -->
                                        <a href="{{ route('superadmin.edit-member', $member->id) }}"
                                            class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                            Edit
                                        </a>

                                        <!-- Approve Form with Member Type -->
                                        <form method="POST" action="{{ route('superadmin.approve-member', $member->id) }}" class="inline">
                                            @csrf
                                            <select name="member_type" class="border rounded px-2 py-1 text-sm">
                                                <option value="general">General</option>
                                                <option value="lifetime">Lifetime</option>
                                                <option value="manartha">Manartha</option>
                                            </select>
                                            <button type="submit" class="px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                                Approve
                                            </button>
                                        </form>

                                        <!-- Reject Modal Trigger -->
                                        <button type="button"
                                            class="px-2 py-1 bg-red-600 text-white rounded"
                                            data-bs-toggle="modal"
                                            data-bs-target="#rejectModal{{ $member->id }}">
                                            Reject
                                        </button>
                                    </td>
                                </tr>

                                <!-- Member Details Modal -->
                                @include('superadmin.partials.member-modal', ['member' => $member])

                                <!-- Reject Modal -->
                                <div class="modal fade" id="rejectModal{{ $member->id }}" tabindex="-1" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <form method="POST" action="{{ route('superadmin.reject-member', $member->id) }}">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Reason for Rejection</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <textarea name="reason" class="form-control" required rows="4" placeholder="Write reason here..."></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger">Submit</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
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
<!-- In your <head> -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Before </body> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

