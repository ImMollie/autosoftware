<?php

namespace App\Http\Controllers;

use DateTime;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MessageController extends Controller
{
    public function index()
    {     
        return Inertia::render('Dashboard',[
            'messages' => $this->loadMessages(),
        ]);
    }
    private $storage = '/message.json'; 
    public function create(Request $request) : JsonResponse
    {        
        $data = json_decode($request->getContent(), true);
        if(!isset($data['content']))
        {
            return new JsonResponse(['error' => 'Nie ma wiadomości'], 204);
        }
        $uuid = Str::uuid()->toString();
        $message = [
            'UUID' => $uuid,
            'content' => $data['content'],
            'date' => new DateTime(),
        ];        
        $this->saveToFile($message);
        return new JsonResponse(['uuid' => $uuid], 201);
    }

    public function get(): JsonResponse
    {
        return new JsonResponse($this->loadMessages());
    }

    public function read(string $uuid) :JsonResponse
    {        
        $messages = $this->loadMessages();
        foreach ($messages as $message) {
            if($message['UUID'] === $uuid){
                echo $message['UUID'];
                return new JsonResponse($message);
                break;
            }
        }
        return new JsonResponse(['error' => 'Nie ma wiadomości'], 404);     
    }

    private function saveToFile(array $message): void
    {
        $messages = $this->loadMessages();
        $messages[] = $message;
        file_put_contents(storage_path().$this->storage, json_encode($messages)); 
    }
    
    private function loadMessages(): array 
    {
        if(!file_exists(storage_path().$this->storage))
        {
            return [];
        }
        $file = file_get_contents(storage_path().$this->storage);
        return json_decode($file, true) ? : [];

    }

    public function listMessages(Request $request): JsonResponse
    {
        $sort = $request->query->get('sort', 'date');
        $order = $request->query->get('order', 'asc');
        $messages = $this->loadMessages();
        if($sort === 'date'){
            usort($messages, function ($a, $b) use ($order) {
                if($order === 'asc'){
                    return $a['date']['date'] <=> $b['date']['date'];
                }else 
                {
                    return $b['date']['date'] <=> $a['date']['date'];
                }
            });
        } elseif($sort === 'UUID'){
            usort($messages, function ($a, $b) use ($order) {
                if($order === 'asc'){
                    return $a['UUID'] <=> $b['UUID'];
                }else 
                {
                    return $b['UUID'] <=> $a['UUID'];
                }
            });
        }
        return new JsonResponse($messages);        
    }
}
