<?php

namespace App\services;

use App\repositories\TaskRepository;

class TaskService {

    private TaskRepository $taskRepository;

    public function __construct($db) {
        $this->taskRepository = new TaskRepository($db);
    }

    public function getTasks() {
        return $this->taskRepository->findAll();
    }

    public function createTask($title, $assignedTo, $householdId) {
        return $this->taskRepository->createTask(
            $title,
            $assignedTo,
            $householdId
        );
    }
}