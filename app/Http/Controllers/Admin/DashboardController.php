<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Testimonial;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'orders' => Order::count(),
            'ordersPending' => Order::where('status', 'pending')->count(),
            'revenue' => Order::where('status', '!=', 'cancelled')->sum('total'),
        ];

        $recentOrders = Order::orderBy('created_at', 'desc')->take(5)->get();
        $featuredProducts = Product::where('is_featured', true)->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'featuredProducts'));
    }
}