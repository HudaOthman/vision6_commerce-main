<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Notifications\TestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;

class SiteController extends Controller
{
    public function index()
    {
        return view('site.index');
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $products = $category->products()->paginate(8);

        return view('site.category', compact('category', 'products'));
    }

    public function product($slug)
    {
        $product = Product::where('slug', $slug)->first();

        return view('site.product', compact('product'));
    }

    public function send_notification()
    {
        $user = User::find(3);

        $user->notify(new TestNotification());

        return 'Done';
    }

    public function notification()
    {
        $user = User::find(3);

        return view('site.notifications', compact('user'));
    }

    public function read_notification($id)
    {
        $user = User::find(3)->notifications->find($id)->markAsRead();

        return redirect()->back();
    }

    public function posts_api()
    {
        // $posts = Http::get('https://jsonplaceholder.typicode.com/posts')->json();

        // dd($posts);
        $posts = [];

        return view('site.posts_api', compact('posts'));
    }
}
