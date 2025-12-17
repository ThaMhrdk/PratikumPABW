<?php

namespace App\Http\Controllers;

use App\Models\ForumTopic;
use App\Models\ForumPost;
use App\Models\ForumComment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ForumController extends Controller
{
    public function index(Request $request)
    {
        $categories = ForumTopic::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category');

        $query = ForumTopic::with('user')
            ->withCount('posts');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $pinnedTopics = (clone $query)->where('is_pinned', true)->get();

        $topics = (clone $query)->where('is_pinned', false)
            ->latest()
            ->paginate(15);

        $totalTopics = ForumTopic::count();
        $totalPosts = ForumPost::count();
        $activeMembers = User::whereHas('forumTopics')->orWhereHas('forumPosts')->count();

        $topContributors = User::withCount(['forumTopics', 'forumPosts'])
            ->orderByRaw('forum_topics_count + forum_posts_count DESC')
            ->take(5)
            ->get();

        return view('forum.index', compact('categories', 'topics', 'pinnedTopics', 'totalTopics', 'totalPosts', 'activeMembers', 'topContributors'));
    }

    public function create()
    {
        $categories = ['Kecemasan', 'Depresi', 'Stres', 'Hubungan', 'Karir', 'Keluarga', 'Tips & Motivasi', 'Lainnya'];
        return view('forum.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string|min:20',
            'is_anonymous' => 'boolean',
        ]);

        $topic = ForumTopic::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'category' => $request->category,
            'description' => $request->description,
            'is_anonymous' => $request->boolean('is_anonymous'),
        ]);

        return redirect()->route('forum.topic', $topic)
            ->with('success', 'Topik berhasil dibuat.');
    }

    public function topic(ForumTopic $topic)
    {
        $topic->increment('views_count');
        $topic->load('user');

        $posts = ForumPost::with(['user', 'comments.user'])
            ->where('topic_id', $topic->id)
            ->latest()
            ->paginate(15);

        $relatedTopics = ForumTopic::where('category', $topic->category)
            ->where('id', '!=', $topic->id)
            ->take(5)
            ->get();

        return view('forum.topic', compact('topic', 'posts', 'relatedTopics'));
    }

    public function showPost(ForumPost $post)
    {
        $post->load(['topic', 'user']);

        return view('forum.post', compact('post'));
    }

    public function createPost(ForumTopic $topic)
    {
        return view('forum.create-post', compact('topic'));
    }

    public function storePost(Request $request, ForumTopic $topic)
    {
        $request->validate([
            'content' => 'required|string|min:10',
            'is_anonymous' => 'boolean',
        ]);

        ForumPost::create([
            'topic_id' => $topic->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'is_anonymous' => $request->boolean('is_anonymous'),
        ]);

        return redirect()->route('forum.topic', $topic)
            ->with('success', 'Balasan berhasil ditambahkan.');
    }

    public function storeComment(Request $request, ForumPost $post)
    {
        $request->validate([
            'content' => 'required|string|min:3',
            'is_anonymous' => 'boolean',
            'parent_id' => 'nullable|exists:forum_comments,id',
        ]);

        $isPsikologAnswer = Auth::user()->isPsikolog();

        ForumComment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'parent_id' => $request->parent_id,
            'content' => $request->content,
            'is_anonymous' => $request->boolean('is_anonymous'),
            'is_psikolog_answer' => $isPsikologAnswer,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}
