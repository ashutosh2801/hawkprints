<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterSubscriberController extends Controller
{
    public function index()
    {
        $subscribers = NewsletterSubscriber::orderBy('created_at', 'desc')->get();

        $totalActive = NewsletterSubscriber::where('is_active', true)->count();
        $totalInactive = NewsletterSubscriber::where('is_active', false)->count();
        $totalToday = NewsletterSubscriber::whereDate('created_at', today())->count();

        return view('admin.newsletter.index', compact('subscribers', 'totalActive', 'totalInactive', 'totalToday'));
    }

    public function toggle(NewsletterSubscriber $subscriber)
    {
        $subscriber->update([
            'is_active' => !$subscriber->is_active,
            'unsubscribed_at' => $subscriber->is_active ? now() : null,
        ]);

        return back()->with('success', $subscriber->is_active ? 'Subscriber activated.' : 'Subscriber deactivated.');
    }

    public function destroy(NewsletterSubscriber $subscriber)
    {
        $subscriber->delete();
        return back()->with('success', 'Subscriber removed.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:newsletter_subscribers,id',
        ]);

        NewsletterSubscriber::whereIn('id', $request->ids)->delete();

        return back()->with('success', count($request->ids) . ' subscriber(s) removed.');
    }

    public function export()
    {
        $subscribers = NewsletterSubscriber::where('is_active', true)->pluck('email');

        $csv = "email\n" . $subscribers->implode("\n");

        return response($csv, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="newsletter_subscribers.csv"');
    }
}
