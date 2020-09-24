<?php
class Work {

    // подключение к базе данных и таблице 'products' 
    private $conn;
    private $table_name = "works";

    // свойства объекта 
    public $id;
    public $name;
    public $description;
    public $link;
    public $img_link;
    public $create;

    // конструктор для соединения с базой данных 
    public function __construct($db){
        $this->conn = $db;
    }

    // метод read() - получение товаров 
    function read(){

      // выбираем все записи 
      $query = "SELECT * FROM " . $this->table_name . " ORDER BY `created` DESC";
        
    
      // подготовка запроса 
      $stmt = $this->conn->prepare($query);

      // выполняем запрос 
      $stmt->execute();
      return $stmt;
    }

    // метод create - создание товаров 
    function create(){

      // запрос для вставки (создания) записей 
      $query = "INSERT INTO
                  " . $this->table_name . "
              SET
                  name = :name, link = :link, description = :description, img_link = :img_link, created = :create";

      // подготовка запроса 
      $stmt = $this->conn->prepare($query);
      // очистка 
      $this->name=htmlspecialchars(strip_tags($this->name));
      $this->link=htmlspecialchars(strip_tags($this->link));
      $this->description=htmlspecialchars(strip_tags($this->description));
      $this->img_link=htmlspecialchars(strip_tags($this->img_link));
      $this->create=htmlspecialchars(strip_tags($this->create));
 
      // привязка значений 
      $stmt->bindParam(":name", $this->name);
      $stmt->bindParam(":link", $this->link);
      $stmt->bindParam(":description", $this->description);
      $stmt->bindParam(":img_link", $this->img_link);
      $stmt->bindParam(":create", $this->create);

      // выполняем запрос 
      if ($stmt->execute()) {
          return true;
      }
      
      return false;
    }


    // используется при заполнении формы обновления товара 
    function readOne() {

        // запрос для чтения одной записи (товара) 
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . "
                     
                WHERE
                    p.id = ?
                LIMIT
                    0,1";

        // подготовка запроса 
        $stmt = $this->conn->prepare( $query );

        // привязываем id товара, который будет обновлен 
        $stmt->bindParam(1, $this->id);

        // выполняем запрос 
        $stmt->execute();

        // получаем извлеченную строку 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // установим значения свойств объекта 
        $this->name = $row['name'];
        $this->link = $row['link'];
        $this->description = $row['description'];
        $this->img_link = $row['img_link'];
        $this->create = $row['create'];
    }


    // метод update() - обновление товара 
    function update(){

        // запрос для обновления записи (товара) 
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    name = :name,
                    link = :link,
                    description = :description,
                    img_link = :img_link
                WHERE
                    id = :id";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->link=htmlspecialchars(strip_tags($this->link));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->img_link=htmlspecialchars(strip_tags($this->img_link));
        $this->id=htmlspecialchars(strip_tags($this->id));

        // привязываем значения 
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':link', $this->link);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':img_link', $this->img_link);
        $stmt->bindParam(':id', $this->id);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // метод delete - удаление товара 
    function delete(){

        // запрос для удаления записи (товара) 
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $this->id=htmlspecialchars(strip_tags($this->id));

        // привязываем id записи для удаления 
        $stmt->bindParam(1, $this->id);

        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // метод search - поиск товаров 
    function search($keywords){

        // выборка по всем записям 
        $query = "SELECT
                   *
                FROM
                    " . $this->table_name . " 
                   
                WHERE
                    name LIKE ? OR description LIKE ?
                ORDER BY
                    create DESC";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // очистка 
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        // привязка 
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);

        // выполняем запрос 
        $stmt->execute();

        return $stmt;
    }
}
?>