<?php

namespace App\Modules\Articles\Events;

use App\Model\Article;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ArticleCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Article
     */
    private $article;

    /**
     * Create a new event instance.
     *
     * @param Article $article
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
