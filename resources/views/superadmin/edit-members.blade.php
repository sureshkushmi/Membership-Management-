<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Members') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h1 class="text-2xl font-semibold">New Members</h1>

                @if(session('success'))
                    <p class="text-green-600">{{ session('success') }}</p>
                @endif

                <div class="overflow-x-auto">
                    <table class="table-auto w-full mt-4 border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2 text-left">ID</th>
                                <th class="border px-4 py-2 text-left">Name</th>
                                <th class="border px-4 py-2 text-left">Email</th>
                                <th class="border px-4 py-2 text-left">Email Verified</th>
                                <th class="border px-4 py-2 text-left">Role</th>
                                <th class="border px-4 py-2 text-left">Status</th>
                                <th class="border px-4 py-2 text-left">Expiry Date</th>
                                <th class="border px-4 py-2 text-left">Company</th>
                                <th class="border px-4 py-2 text-left">Phone</th>
                                <th class="border px-4 py-2 text-left">Address</th>
                                <th class="border px-4 py-2 text-left">Document</th>
                                <th class="border px-4 py-2 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                <tr class="border-b">
                                   <td class="border px-4 py-2">{{ $member->id }}</td>
    <td class="border px-4 py-2">{{ $member->name }}</td>
    <td class="border px-4 py-2">{{ $member->email }}</td>
    <td class="border px-4 py-2">
        @if($member->email_verified_at)
            {{ $member->email_verified_at->format('d-m-Y') }}
        @else
            Not Verified
        @endif
    </td>
                                    <td class="border px-4 py-2">{{ $member->role }}</td>
                                    <td class="border px-4 py-2">
                                        @if($member->status == 'active')
                                            Active
                                        @else
                                            Inactive
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">
                                        @if($member->expiry_date)
                                           {{ \Carbon\Carbon::parse($member->expiry_date)->format('d-m-Y') }}

                                        @else
                                            Not Available
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">{{ $member->company_name }}</td>
                                    <td class="border px-4 py-2">{{ $member->phone }}</td>
                                    <td class="border px-4 py-2">{{ $member->address }}</td>
                                    <td class="border px-4 py-2">
                                        @if($member->document)
                                            <a href="{{ asset('storage/'.$member->document) }}" target="_blank">View Document</a>
                                        @else
                                            No Document
                                        @endif
                                    </td>
                                 @auth
    @if(auth()->user()->role === 'superadmin' && $member->role === 'member')
        <td class="border px-4 py-2">
            <button onclick="openCancelModal({{ $member->id }})" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                Cancel Member
            </button>
        </td>
    @endif
@endauth


                                </tr>
                           
                        </tbody>
                    </table>
                </div>
                <!-- Cancel Modal -->
               <div id="cancelModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 pt-10 rounded-lg shadow-lg max-w-md w-full relative">
        <button onclick="closeCancelModal()" class="absolute top-2 right-2 text-gray-600 hover:text-black text-xl leading-none">&times;</button>
        <h2 class="text-lg font-semibold mb-4 text-center">Cancel Membership</h2>
        <form id="cancelForm" method="POST">
            @csrf
            <input type="hidden" name="member_id" id="cancelMemberId">
            <label for="reason" class="block mb-2 font-medium">Reason:</label>
            <textarea name="reason" id="cancelReason" class="w-full border rounded p-2" required></textarea>
            <div class="mt-4 text-right">
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Confirm Cancel
                </button>
            </div>
        </form>
    </div>
</div>


            </div>
        </div>
    </div>
</x-app-layout>
<script>
    function openCancelModal(memberId) {
        document.getElementById('cancelMemberId').value = memberId;
        document.getElementById('cancelForm').action = `/members/cancel/${memberId}`;
        document.getElementById('cancelModal').classList.remove('hidden');
        document.getElementById('cancelModal').classList.add('flex');
    }

    function closeCancelModal() {
        document.getElementById('cancelModal').classList.remove('flex');
        document.getElementById('cancelModal').classList.add('hidden');
        document.getElementById('cancelReason').value = '';
    }
</script>

