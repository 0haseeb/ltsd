<?php
namespace App\Providers;

use App\User;
use App\Tag;
use Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('incs/side', function ($view) {
            $results = DB::select(DB::raw("
            SELECT `tag_id`, COUNT(*) AS `cnt`
            FROM `post_tag`
            GROUP BY `tag_id`
            ORDER BY `cnt` DESC,  `created_at` DESC
            LIMIT 10"));
            //  print_r($results);
            $tag = [];
            foreach ($results as $result) {
                $temp=[$result->tag_id];
                $tag = array_merge($tag, $temp);
            }
            $ids_ordered = implode(',', $tag);
            $trendingtags=Tag::whereIn('id', $tag)->orderByRaw("FIELD(id, $ids_ordered)")->take(10)->get();
            $authuser= auth()->user();
            // get ids of users Auth user is following
            $following_ids= $authuser->followings()->pluck('follow_id')->toArray();
            if (!$following_ids==null) {
                //find auths user's followings by lists of ids;
                $users=User::wherein('id', $following_ids)->get();
                $followingsfollowing_ids=[];
                $followingstag_ids=[];
                foreach ($users as $user) {
                    // get ids of topices each user is following.
                    $followingstag_ids = array_merge($followingstag_ids, $user->followtag()->pluck('tag_id')->toArray());
                    // get ids of users Auth user's following's following
                    $followingsfollowing_ids = array_merge($followingsfollowing_ids, $user->followings()->pluck('follow_id')->toArray());
                    // remove auth user from array
                    if (($key = array_search($authuser->id, $followingsfollowing_ids)) !== false) {
                        unset($followingsfollowing_ids[$key]);
                    }
                }
                //  print_r($followingsfollowing_ids);
                // remove ids of users Auth users is already following
                $suggestedusers_ids = array_diff($followingsfollowing_ids, $following_ids);
                $suggestedtags_ids = array_diff($followingstag_ids, $authuser->followtag()->pluck('tag_id')->toArray());

                // if (($key = array_search($authuser->id, $suggestedusers_ids)) !== false) {
                //     unset($suggestedusers_ids[$key]);
                // }
                // find auths user's followings' following by id;
                $suggestedusers=User::whereIn('id', $suggestedusers_ids)->take(3)->get();
                $suggestedtags=Tag::whereIn('id', $suggestedtags_ids)->take(5)->get();
            } else {
                //
                $suggestedusers= [];
                $suggestedtags= [];
            }
            //  $view->with(compact('userss','topices'));
            $view->with(compact('suggestedusers', 'suggestedtags', 'trendingtags', 'results'));
        });
          View::composer('layouts/app', function ($view) {
            if (Auth::check()) {
            $notifcount= auth()->user()->unreadNotifications()->count();
            $view->with(compact('notifcount'));
          }
          });
    }
}
