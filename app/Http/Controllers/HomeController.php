<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function notfound()
    {
        return view('404');
    }

    /**
     * Show Notification detail.
     *
     * @param  int  $id //notification id
     * @return \Illuminate\Http\Response //link to content (i.e post, comment, new follower)
     */
    public function showNt($id)
    {
      $notification = auth()->user()->notifications()->where('id', $id)->first();
      if ($notification) {
          $notification->markAsRead();
          return redirect($notification->data['link']);
      }
    }
}
