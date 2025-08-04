<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $articles = Event::where('is_active', true)->orderByDesc('created_at')->paginate(12);

        return view('page.event.index', [
            'article_items' => $articles,
        ]);
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)->where('is_active', true)->first();

        if (!$event) {
            abort(404);
        }

        $recentPosts = Event::where('id', '!=', $event->id)->where('is_active', true)->orderByDesc('created_at')->take(5)->get();

        return view('page.event.show', compact('event', 'recentPosts'));
    }
}
