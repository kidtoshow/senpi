<?php

namespace App\Http\Controllers;

use App\AdColumn;
use App\BulletinBoard;
use App\Carousel;
use App\Post;
use App\QACategory;
use App\QACategoryRelation;
use Illuminate\Http\Request;
use App\User;
use App\Skill;
use App\UserSkillRelation;
use App\Invite;
use App\CollectUser;
use App\PostCategory;
use App\University;
use Auth;
use Illuminate\Support\Str;

class FrontPageController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'vip')->where('expired', '>=', now())->withCount('likedUser')->withCount('collectedUser')->inRandomOrder()->get();
        $Data = [
            'Skills' => new Skill,
            'UserSkillRelation' => new UserSkillRelation,
            'Users' => $users,
            'University' => University::withCount('vip')->orderBy('vip_count', 'desc')->limit(15)->get(),
            'PostCategory' => new PostCategory,
            'QaCategory' => QACategory::with(['QACategoryRelation' => function($q){$q->orderByDesc('created_at');}])->get(),
            'Post' => Post::whereIn('uid', $users->pluck('id'))->inRandomOrder()->first(),
            'Carousel' => Carousel::where('is_active', true)->first(),
            'Ad' => AdColumn::first(),
        ];

        return view('welcome')->with('Data', $Data);
    }

    public function random()
    {
        $users = User::where('role', 'vip')->where('expired', ">=", now())->pluck('id');
        $posts = Post::whereIn('uid', $users)->with('category.postCategory')->inRandomOrder()->limit(5)->get();
        $posts->transform(function($item){
            return [
                'topic' => '小學堂',
                'id' => $item->id,
                'body' => Str::limit(strip_tags($item->body)),
                'title' => $item->title,
                'image_path' => (str_starts_with('/', $item->image_path)) ? str_replace(' ', '%20', url('uploads'.$item->image_path)) : str_replace(' ', '%20', url('uploads/'.$item->image_path)),
                "category" => $item->category->transform(function($item){ return $item->postCategory->name; }),
                'url' => url('article/'.$item->id)
            ];
        });
        $bullet = BulletinBoard::inRandomOrder()->limit(1)->get();
        if($bullet->isNotEmpty())
        {
            $bullet->transform(function($item){
               return [
                   'topic' => 'SENPAI公告',
                   'id' => $item->id,
                   'body' => Str::limit(strip_tags($item->message)),
                   'title' => '最新公告',
                   'image_path' => url('uploads/images/color_ezl.png'),
                   "category" => '',
                   'url' => route('bulletinboard')
               ];
            });
        }
        $posts->push($bullet->first());
        return response()->json($posts);
    }
}
