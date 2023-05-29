<?php
namespace App\Controller;

use DateTime;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serialize\Encoder\JsonEncoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessageController extends AbstractController
{
    private $storage = '/storage/messages.json'; 
    public function create(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if(!isset($data['content']))
        {
            return new JsonResponse(['error' => 'Nie ma wiadomości'], 204);
        }
        $uuid = Uuid::v4();
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

        file_put_contents($this->getStorageFilePath(), json_encode($messages)); 
    }
    
    private function loadMessages(): array 
    {
        if(!file_exists($this->getStorageFilePath()))
        {
            return [];
        }

        $file = file_get_contents($this->getStorageFilePath());

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

    
    private function getStorageFilePath(): string
    {
        return $this->getParameter('kernel.project_dir').$this->storage;
    }
}