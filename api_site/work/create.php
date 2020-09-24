<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// получаем соединение с базой данных 
include_once '../config/database.php';

// создание объекта товара 
include_once '../objects/work.php';

$database = new Database();
$db = $database->getConnection();

$work = new work($db);
 
// получаем отправленные данные 
$data = $_POST;
$files = $_FILES;


// $data2 = Array(
//     'title' => '123',
//     'description' => '123',
//     'link' => '123',
//     'create' => '2020-09-24'
// );

// print_r($data2);
// $object = (object)$data2;

// echo $object->title;

// echo $data2['title'];


// убеждаемся, что данные не пусты 
 
if (
    !empty($data['title']) &&
    !empty($data['link']) &&
    !empty($files['img_link']) 
) {
    $data = (Object)$data;
    $files = (Object)$files;

    // устанавливаем значения свойств товара 
    $work->name = $data->title;
    $work->link = $data->link;
    $work->description = $data->description;
    $work->create = $data->create;
    

    $uploaddir = '/var/www/pro10111/data/www/sasha-izvekov.ru/root/uploads/';
    $uploaddir_short = "/uploads/";
    $uploaddir_short = quotemeta($uploaddir_short);
    $uploadfile = $uploaddir . basename($_FILES['img_link']['name']);
 
    if (!move_uploaded_file($_FILES['img_link']['tmp_name'], $uploadfile)) {
        echo json_encode(array("message" => "Проблема с загрузкой картинки"), JSON_UNESCAPED_UNICODE);
        die();
    }

    $work->img_link = $uploaddir_short . basename($_FILES['img_link']['name']);

    // создание Раюоты \ добавление в БД 
    if($work->create()){

        // установим код ответа - 201 создано 
        http_response_code(201);

        // сообщим пользователю 
        echo json_encode(array("message" => "Работа успешно добавлена."), JSON_UNESCAPED_UNICODE);
    }

    // если не удается создать товар, сообщим пользователю 
    else {

        // установим код ответа - 503 сервис недоступен 
        http_response_code(503);

        // сообщим пользователю 
        echo json_encode(array("message" => "При добавлении произошла ошибка."), JSON_UNESCAPED_UNICODE);
    }
}

// сообщим пользователю что данные неполные 
else {

    // установим код ответа - 400 неверный запрос 
    http_response_code(400);

    // сообщим пользователю 
    echo json_encode(array("message" => "Невозможно добавить работу. Данные неполные."), JSON_UNESCAPED_UNICODE);
}
?>