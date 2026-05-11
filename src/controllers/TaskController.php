<?php

namespace App\controllers;

use App\services\TaskService;

class TaskController {

    private TaskService $taskService;

    public function __construct($db) {
        $this->taskService = new TaskService($db);
    }

    public function index() {
        header('Content-Type: application/json');

        echo json_encode(
            $this->taskService->getTasks()
        );
    }

    public function create() {
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents("php://input"), true);

        try {
            if (
                empty($data['title']) ||
                empty($data['assigned_to']) ||
                empty($data['household_id'])
            ) {
                throw new \Exception("Données manquantes");
            }

            $task = $this->taskService->createTask(
                $data['title'],
                $data['assigned_to'],
                $data['household_id']
            );

            http_response_code(201);
            echo json_encode($task);

        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode([
                "error" => $e->getMessage()
            ]);
        }
    }
}