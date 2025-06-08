<!-- resources/views/superadmin/partials/member-modal.blade.php -->

<div class="modal fade" id="memberModal{{ $member->id }}" tabindex="-1" aria-labelledby="memberModalLabel{{ $member->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="memberModalLabel{{ $member->id }}">Member Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body space-y-2">
        <p><strong>ID:</strong> {{ $member->id }}</p>
        <p><strong>Name:</strong> {{ $member->name }}</p>
        <p><strong>Email:</strong> {{ $member->email }}</p>
        <p><strong>Phone:</strong> {{ $member->phone }}</p>
        <p><strong>Company:</strong> {{ $member->company_name }}</p>
        <p><strong>Address:</strong> {{ $member->address }}</p>
        <p><strong>Status:</strong> {{ ucfirst($member->status) }}</p>
        <p><strong>Email Verified:</strong> {{ $member->email_verified_at ? $member->email_verified_at->format('d-m-Y') : 'No' }}</p>
        <p><strong>Expiry Date:</strong> {{ $member->expiry_date ? \Carbon\Carbon::parse($member->expiry_date)->format('d-m-Y') : 'N/A' }}</p>
        <p><strong>Role:</strong> {{ $member->role }}</p>
        <p><strong>Document:</strong>
            @if($member->document)
                <a href="{{ asset('storage/' . $member->document) }}" target="_blank" class="text-blue-600 underline">View Document</a>
            @else
                No Document
            @endif
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
