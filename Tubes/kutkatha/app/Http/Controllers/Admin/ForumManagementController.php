<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForumPost;
use App\Models\ForumComment;
use App\Models\ForumTopic;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ForumManagementController extends Controller
{
    public function index()
    {
        $topics = ForumTopic::withCount('posts')->latest()->get();
        $recentPosts = ForumPost::with(['user', 'topic'])
            ->latest()
            ->paginate(15);

        $totalTopics = ForumTopic::count();
        $totalPosts = ForumPost::count();
        $reportedPosts = 0; // Placeholder - implement reporting feature later
        $activeUsers = \App\Models\User::whereHas('forumTopics')->orWhereHas('forumPosts')->count();

        return view('admin.forum.index', compact('topics', 'recentPosts', 'totalTopics', 'totalPosts', 'reportedPosts', 'activeUsers'));
    }

    public function posts(Request $request)
    {
        $query = ForumPost::with(['user', 'topic']);

        $posts = $query->latest()->paginate(20);

        return view('admin.forum.posts', compact('posts'));
    }

    public function deletePost(ForumPost $post)
    {
        $post->delete();

        return back()->with('success', 'Post dihapus.');
    }

    public function deleteComment(ForumComment $comment)
    {
        $comment->delete();

        return back()->with('success', 'Komentar dihapus.');
    }

    public function createTopic()
    {
        $categories = ['Kecemasan', 'Depresi', 'Stres', 'Hubungan', 'Karir', 'Keluarga', 'Tips & Motivasi', 'Lainnya'];
        return view('admin.forum.create-topic', compact('categories'));
    }

    public function storeTopic(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
        ]);

        ForumTopic::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'category' => $request->category,
            'description' => $request->description,
            'is_pinned' => $request->boolean('is_pinned'),
        ]);

        return redirect()->route('admin.forum.index')
            ->with('success', 'Topik berhasil dibuat.');
    }
}
