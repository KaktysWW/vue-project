<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

$host = 'MySQL-8.4';
$db   = 'ave_shop';
$user = 'root';
$pass = '';

$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['email']) || empty($data['password'])) {
    echo json_encode(["success" => false, "message" => "Заполните все поля"]);
    exit;
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    
    // Проверяем, не занят ли email
    $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$data['email']]);
    if ($check->fetch()) {
        echo json_encode(["success" => false, "message" => "Этот email уже занят"]);
        exit;
    }

    // Сохраняем пользователя
    $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    if ($stmt->execute([$data['email'], $data['password']])) {
        $userId = $pdo->lastInsertId();
        echo json_encode([
            "success" => true,
            "user" => ["id" => $userId, "email" => $data['email']]
        ]);
    }

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Ошибка базы данных"]);
}