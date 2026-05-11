<?php

namespace App\repositories;

use PDO;

class TaskRepository {

    private PDO $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findAll() {
        $stmt = $this->db->query("SELECT * FROM tasks");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createTask($title, $assignedTo, $householdId) {
        $stmt = $this->db->prepare("
            INSERT INTO tasks (title, status, assigned_to, household_id)
            VALUES (:title, 'pending', :assigned_to, :household_id)
        ");

        $stmt->execute([
            "title" => $title,
            "assigned_to" => $assignedTo,
            "household_id" => $householdId
        ]);

        return [
            "task_id" => $this->db->lastInsertId(),
            "title" => $title,
            "status" => "pending"
        ];
    }
}