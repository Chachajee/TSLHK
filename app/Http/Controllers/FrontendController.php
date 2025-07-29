<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Http\Requests\StoreContactMessageRequest;

class FrontendController extends Controller
{
    /**
     * Display the portfolio details page
     *
     * @return \Illuminate\View\View
     */
    public function portfolioDetails()
    {
        return view('frontend.portfolio-details');
    }

    /**
     * Display the service details page
     *
     * @return \Illuminate\View\View
     */
    public function serviceDetails()
    {
        return view('frontend.service-details');
    }

    /**
     * Store a new contact message
     *
     * @param StoreContactMessageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeContactMessage(StoreContactMessageRequest $request)
    {
        try {
            $contactMessage = ContactMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => 'unread'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thank you for your message! We will get back to you soon.',
                'data' => $contactMessage
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, there was an error sending your message. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 