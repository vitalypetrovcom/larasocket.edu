<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller { // Контроллер для работы с сообщениями


    public function index ( ) { // Метод для отображения всех сообщений

        return response ()->json (Message::all ());

    }

    public function store (Request $request) { // Метод для добавления новых сообщений

        $message = Message::create([
            "body" => $request->body
        ]);

        event (new NewMessage($message->body, $message->created_at)); // Создаем событие для рассылки новых сообщений всем, кто подключен к вебсокетам

        return response ()->json ([
            "status" => true,
            "message" => $message
        ], 201);

    }

}
