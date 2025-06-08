<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\UserRejectedMail;
use App\Mail\WelcomeMemberMail;
use Illuminate\Support\Facades\Mail;

class SuperadminController extends Controller
{
    
    public function index()
    {
        $members = User::where('status', 'active')->get();
        return view('superadmin.members', compact('members'));
    }
     public function members()
    {
        $members = User::where('status', 'active')->get();
        return view('superadmin.members', compact('members'));
    }
    public function pendingMembers()
    {
        $pendingMembers = User::where('role', 'member')
                                ->where('status', 'pending')
                                ->get();

        return view('superadmin.pending-members', compact('pendingMembers'));
    }

   public function approveMember($id)
{
    $user = User::findOrFail($id);
    $user->status = 'approved';
    $user->save();

    // Send welcome email
    Mail::to($user->email)->send(new WelcomeMemberMail($user));

    return redirect()->back()->with('success', 'Member approved and welcome email sent!');
}


  public function rejectMember($id)
{
$request->validate([
    'reason' => 'required|string',
]);

$user = User::findOrFail($id);
$user->status = 'rejected';
$user->save();

Reason::create([
    'user_id' => $user->id,
    'type' => 'rejected',
    'reason' => $request->reason,
]);

// Send rejection email with reason
Mail::to($user->email)->send(new UserRejectedMail($user, $request->reason));

    return redirect()->back()->with('success', 'Member rejected and email sent.');
}
 public function cancel(Request $request, $id)
{
    $request->validate([
        'reason' => 'required|string|max:1000',
    ]);

    $member = User::where('status', 'active')->findOrFail($id);
    $member->status = 'cancelled';
    $member->save();

    // Optionally log cancellation reason
    DB::table('member_cancellations')->insert([
        'user_id' => $member->id,
        'reason' => $request->reason,
        'cancelled_by' => auth()->id(),
        'created_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Member cancelled successfully.');
}

  public function edit($id)
    {
        $member = User::findOrFail($id);
        return view('superadmin.edit-members', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'member_type' => 'nullable|string',
            'expiry_date' => 'nullable|date',
        ]);

        $member = User::findOrFail($id);
        $member->update($request->only(['name', 'phone', 'address', 'member_type', 'expiry_date']));

        return redirect()->route('superadmin.pending-members')->with('success', 'Member info updated.');
    }
    
}
