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
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $data['email']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Простая проверка (в реальных проектах лучше использовать password_verify)
    if ($user && $user['password'] === $data['password']) {
        unset($user['password']); // Удаляем пароль из ответа для безопасности
        echo json_encode([
            "success" => true,
            "user" => $user
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Неверный email или пароль"]);
    }

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Ошибка базы данных"]);
}