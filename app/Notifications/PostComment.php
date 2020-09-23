<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostComment extends Notification
{
    use Queueable;
    // user to notify about
    public $user;
    // notify about this post and comment.
    public $post;
    public $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user,$post,$comment)
    {
      $this->user=$user;
      $this->post=$post;
      $this->comment=$comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
          'username'=> $this->user->username,
          'post_content'=> $this->post->content,
          'comment'=> $this->comment,
          'user_image'=> $this->user->image,
          'post_image'=> $this->post->image,
          'link'=> 'posts/'. $this->post->id
        ];
    }
}
