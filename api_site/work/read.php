<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../config/database.php';
include_once '../objects/work.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// инициализируем объект 
$work = new Work($db);
 
// запрашиваем товары 
$stmt = $work->read();
$num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей 
if ($num>0) {

    // массив работ 
    $works_arr=array();
    $works_arr["records"]=array();

    // получаем содержимое нашей таблицы 
    // fetch() быстрее, чем fetchAll() 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        // извлекаем строку 
        extract($row);

        $work_item=array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "link" => $link,
            "img_link" => $img_link,
            "create" => $create
        );

        array_push($works_arr["records"], $work_item);
    }

    // устанавливаем код ответа - 200 OK 
    http_response_code(200);

    // выводим данные о товаре в формате JSON 
    echo json_encode($works_arr, JSON_UNESCAPED_UNICODE);
}

else {

  // установим код ответа - 404 Не найдено 
  http_response_code(404);

  // сообщаем пользователю, что товары не найдены 
  echo json_encode(array("message" => "Работы не найдены."), JSON_UNESCAPED_UNICODE);
}