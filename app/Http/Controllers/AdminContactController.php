<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class AdminContactController extends Controller
{
    /**
     * Display a listing of contact messages
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(10);
        $unreadCount = ContactMessage::unread()->count();
        
        return view('admin.contact-messages.index', compact('messages', 'unreadCount'));
    }

    /**
     * Display the specified contact message
     *
     * @param ContactMessage $contactMessage
     * @return \Illuminate\View\View
     */
    public function show(ContactMessage $contactMessage)
    {
        // Mark as read if unread
        if ($contactMessage->status === 'unread') {
            $contactMessage->markAsRead();
        }
        
        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    /**
     * Mark message as read
     *
     * @param ContactMessage $contactMessage
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(ContactMessage $contactMessage)
    {
        $contactMessage->markAsRead();
        
        return response()->json([
            'success' => true,
            'message' => 'Message marked as read'
        ]);
    }

    /**
     * Mark message as replied
     *
     * @param ContactMessage $contactMessage
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsReplied(ContactMessage $contactMessage)
    {
        $contactMessage->markAsReplied();
        
        return response()->json([
            'success' => true,
            'message' => 'Message marked as replied'
        ]);
    }

    /**
     * Remove the specified contact message
     *
     * @param ContactMessage $contactMessage
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        
        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Message deleted successfully');
    }
}
