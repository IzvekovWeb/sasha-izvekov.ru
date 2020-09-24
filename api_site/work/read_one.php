<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../config/database.php';
include_once '../objects/work.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$work = new work($db);

// установим свойство ID записи для чтения 
$work->id = isset($_GET['id']) ? $_GET['id'] : die();

// прочитаем детали товара для редактирования 
$work->readOne();

if ($work->name!=null) {

    // создание массива 
    $work_arr = array(
        "id" =>  $work->id,
        "name" => $work->name,
        "description" => $work->description,
        "link" => $work->link,
        "img_link" => $work->img_link,
        "create" => $work->create
    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($work_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Товар не существует."), JSON_UNESCAPED_UNICODE);
}
?>