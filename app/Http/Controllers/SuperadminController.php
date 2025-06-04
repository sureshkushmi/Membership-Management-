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
    $user = User::findOrFail($id);
    $user->status = 'rejected';
    $user->save();

    // Send rejection email
    Mail::to($user->email)->send(new UserRejectedMail($user));

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

    
}
