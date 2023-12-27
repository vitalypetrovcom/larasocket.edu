<?php

namespace App\Http\Controllers;

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

        return response ()->json ([
            "status" => true,
            "message" => $message
        ], 201);

    }

}
