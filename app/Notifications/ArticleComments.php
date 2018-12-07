<?php

namespace App\Notifications;

use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ArticleComments extends Notification
{
    use Queueable;

    public $comment;

    /**
     * Create a new notification instance.
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $article = $this->comment->article;
        $link    = '/users/' . $this->comment->user->id . '/articles/' . $article->id . '/content';

        // 存入数据库里的数据
        return [
            'comment_id'    => $this->comment->id,
            'comment_body'  => $this->comment->body,
            'user_id'       => $this->comment->user->id,
            'user_name'     => $this->comment->user->name,
            'user_avatar'   => $this->comment->user->avatar,
            'article_link'  => $link,
            'article_id'    => $article->id,
            'article_title' => $article->title,
        ];
    }
}
