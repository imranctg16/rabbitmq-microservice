<?php

namespace App\Http\Controllers;

use App\Services\RabbitMQService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $rabbitMQService;
    public function __construct(RabbitMQService $rabbitMQService)
    {
        $this->rabbitMQService = $rabbitMQService;
    }

    public function store(Request $request)
    {
        // a production is just being created, now add this to ther inventory in consumer service
        $inventory = [
            'id' => 1,
            'title' => 'Product 1',
            'count' => 1,
            'created_at' => Carbon::now()->format('Y-m-d')
        ];
        $this->rabbitMQService->sendToQueue('consumer_queue', json_encode($inventory));
        return response()->json($inventory, 201);
    }
}
