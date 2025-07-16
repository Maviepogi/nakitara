<?php
namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $items = Item::with(['user', 'category'])
            ->where('status', 'active')
            ->latest()
            ->paginate(10);

        $categories = Category::all();

        return view('dashboard', compact('items', 'categories'));
    }

    public function filter(Request $request)
    {
        $query = Item::with(['user', 'category'])->where('status', 'active');

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        $items = $query->latest()->paginate(10);
        $categories = Category::all();

        return view('dashboard', compact('items', 'categories'));
    }
}