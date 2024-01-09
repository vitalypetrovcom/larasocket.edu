<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcastNow { // Событие, для отслеживания новых записей в БД (возвращать по каналу 'messages' новые сообщения). Прикрепляем к нему (implements) класс ShouldBroadcastNow (это нужно для отслеживания новых записей - работа с events для вебсокетов)
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $body; // Это те данные, которые мы будем возвращать клиенту
    public $created_at;

    /**
     * Create a new event instance.
     */
    public function __construct($body, $created_at)
    {
        // Помещаем полученные данные от сервера в свойства body и created_at
        $this->body = $body;
        $this->created_at = $created_at;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [ // Создаем публичный (общедоступный) канал 'messages' и событие будет прикреплено к этому каналу
            new Channel('messages'),
        ];
    }

    public function broadcastWith () { // Данный метод нужен для того, чтобы возвращать какие-либо данные в виде json

        return [
            "body" => $this->body,
            "created_at" => $this->created_at
        ];

    }
}
