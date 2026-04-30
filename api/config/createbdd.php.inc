<?php 

try {
    $pdo = new PDO("mysql:host=localhost", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS gestion_coloc");
    
    $db = new PDO("mysql:host=localhost;dbname=gestion_coloc;charset=utf8mb4", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // ========================
        // USERS
        // ========================
        if ($db->exec('CREATE TABLE users(
            user_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
            user_name VARCHAR(100) NOT NULL,
            user_email VARCHAR(100) NOT NULL UNIQUE,
            user_password VARCHAR(255) NOT NULL
        )') !== false) {

            // ========================
            // HOUSEHOLDS (colocations)
            // ========================
            if ($db->exec('CREATE TABLE households(
                household_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
                household_name VARCHAR(100) NOT NULL
            )') !== false) {

                // ========================
                // USER ↔ HOUSEHOLD
                // ========================
                if ($db->exec('CREATE TABLE user_household(
                    user_id INT(11) NOT NULL,
                    household_id INT(11) NOT NULL,
                    FOREIGN KEY (user_id) REFERENCES users(user_id),
                    FOREIGN KEY (household_id) REFERENCES households(household_id)
                )') !== false) {

                    // ========================
                    // TASKS
                    // ========================
                    if ($db->exec('CREATE TABLE tasks(
                        task_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
                        title VARCHAR(100) NOT NULL,
                        status VARCHAR(20) DEFAULT "pending",
                        due_date DATETIME NULL,
                        assigned_to INT(11),
                        household_id INT(11),
                        FOREIGN KEY (assigned_to) REFERENCES users(user_id),
                        FOREIGN KEY (household_id) REFERENCES households(household_id)
                    )') !== false) {

                        // ========================
                        // EXPENSES
                        // ========================
                        if ($db->exec('CREATE TABLE expenses(
                            expense_id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
                            title VARCHAR(100) NOT NULL,
                            amount FLOAT NOT NULL,
                            date DATETIME NOT NULL,
                            paid_by INT(11),
                            household_id INT(11),
                            FOREIGN KEY (paid_by) REFERENCES users(user_id),
                            FOREIGN KEY (household_id) REFERENCES households(household_id)
                        )') !== false) {

                            // ========================
                            // EXPENSE SPLIT
                            // ========================
                            if ($db->exec('CREATE TABLE expense_split(
                                expense_id INT(11) NOT NULL,
                                user_id INT(11) NOT NULL,
                                amount_due FLOAT NOT NULL,
                                FOREIGN KEY (expense_id) REFERENCES expenses(expense_id),
                                FOREIGN KEY (user_id) REFERENCES users(user_id)
                            )') !== false) {

                                echo "Installation BDD Colocation réussie";

                            } else {
                                echo "Erreur création expense_split";
                            }

                        } else {
                            echo "Erreur création expenses";
                        }

                    } else {
                        echo "Erreur création tasks";
                    }

                } else {
                    echo "Erreur création user_household";
                }

            } else {
                echo "Erreur création households";
            }

        } else {
            echo "Erreur création users";
        }

    }catch(PDOException $error) {
    die($error->getMessage());
}

// ========================
// INSERT USERS
// ========================
$db->exec("INSERT INTO users (user_name, user_email, user_password) VALUES
('Alice', 'alice@mail.com', 'password123'),
('Bob', 'bob@mail.com', 'password123'),
('Charlie', 'charlie@mail.com', 'password123')
");

// ========================
// INSERT HOUSEHOLD
// ========================
$db->exec("INSERT INTO households (household_name) VALUES
('Coloc Toulouse')
");

// ========================
// LIAISON USERS ↔ HOUSEHOLD
// ========================
$db->exec("INSERT INTO user_household (user_id, household_id) VALUES
(1,1),
(2,1),
(3,1)
");

// ========================
// INSERT TASKS
// ========================
$db->exec("INSERT INTO tasks (title, status, assigned_to, household_id) VALUES
('Faire la vaisselle', 'pending', 1, 1),
('Sortir les poubelles', 'pending', 2, 1)
");

// ========================
// INSERT EXPENSES
// ========================
$db->exec("INSERT INTO expenses (title, amount, date, paid_by, household_id) VALUES
('Courses alimentaires', 60.0, NOW(), 1, 1)
");

// ========================
// SPLIT DEPENSE
// ========================
$db->exec("INSERT INTO expense_split (expense_id, user_id, amount_due) VALUES
(1,1,20),
(1,2,20),
(1,3,20)
");

?>
