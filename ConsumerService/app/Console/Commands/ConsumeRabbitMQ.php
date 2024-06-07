<?php

namespace App\Console\Commands;

use App\Services\RabbitMQService;
use Illuminate\Console\Command;

class ConsumeRabbitMQ extends Command
{
    protected $signature = 'rabbitmq:consume';
    protected $description = 'Consume messages from RabbitMQ';

    protected $rabbitMQService;

    public function __construct(RabbitMQService $rabbitMQService)
    {
        parent::__construct();
        $this->rabbitMQService = $rabbitMQService;
    }

    public function handle()
    {
        $callback = function ($msg) {
            $data = json_decode($msg->body, true);
            $inventory = [
                
            ];
            echo ' [x] Product added to inventory ', $msg->body, "\n";
        };

        $this->rabbitMQService->consumeQueue('consumer_queue', $callback);
    }
}
