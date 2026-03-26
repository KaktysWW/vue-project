<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$host = 'MySQL-8.4';
$db   = 'ave_shop';
$user = 'root';
$pass = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM products WHERE 1=1";
    $params = [];

    // Цена
    if (!empty($_GET['min_price'])) { $sql .= " AND price >= :min"; $params['min'] = $_GET['min_price']; }
    if (!empty($_GET['max_price'])) { $sql .= " AND price <= :max"; $params['max'] = $_GET['max_price']; }

    // Бренды
    if (!empty($_GET['brands'])) {
        $brands = explode(',', $_GET['brands']);
        $brandParts = [];
        foreach($brands as $i => $b) {
            $key = ":b".$i;
            $brandParts[] = "name LIKE ".$key;
            $params[$key] = "%".trim($b)."%";
        }
        $sql .= " AND (".implode(" OR ", $brandParts).")";
    }

    // Модели (Новое!)
    if (!empty($_GET['models'])) {
        $models = explode(',', $_GET['models']);
        $inQuery = implode(',', array_fill(0, count($models), '?'));
        $sql .= " AND model_series IN ($inQuery)";
        foreach($models as $m) { $params[] = trim($m); }
    }

    // Память RAM
    if (!empty($_GET['ram'])) {
        $ram = explode(',', $_GET['ram']);
        $sql .= " AND ram_size IN (".implode(',', array_map('intval', $ram)).")";
    }

    // Память Storage
    if (!empty($_GET['storage'])) {
        $storage = explode(',', $_GET['storage']);
        $sql .= " AND storage_size IN (".implode(',', array_map('intval', $storage)).")";
    }

    $sql .= " ORDER BY id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}