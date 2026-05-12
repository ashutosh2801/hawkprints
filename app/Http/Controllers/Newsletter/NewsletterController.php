<?php

namespace App\Http\Controllers\Newsletter;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $result = NewsletterSubscriber::subscribe($request->email);

        if ($result['success']) {
            $subscriber = NewsletterSubscriber::where('email', $request->email)->first();
            if ($subscriber && $subscriber->wasRecentlyCreated) {
                AdminNotification::createNotification('newsletter', [
                    'email' => $request->email,
                ]);
            }
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($result, $result['success'] ? 200 : 400);
        }

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function unsubscribe(string $token)
    {
        $result = NewsletterSubscriber::unsubscribeByToken($token);

        return view('front.newsletter-unsubscribe', compact('result'));
    }
}
