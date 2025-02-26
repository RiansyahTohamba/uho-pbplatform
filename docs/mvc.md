Berikut adalah contoh kode PHP Native dengan MySQL yang menggunakan pendekatan **OOP (Object-Oriented Programming)** dan **MVC (Model-View-Controller)** untuk CRUD pemain bola.  

Struktur folder proyek:  
```
/php-mvc
│── /app
│   │── /controllers
│   │   ├── PlayerController.php
│   │── /models
│   │   ├── Player.php
│   │── /views
│   │   ├── players
│   │   │   ├── index.php
│   │   │   ├── create.php
│   │   │   ├── edit.php
│── /config
│   │── Database.php
│── /public
│   │── index.php
│── /routes
│   │── web.php
│── .htaccess
```

### 1. **Konfigurasi Database (`config/Database.php`)**
```php
<?php
class Database {
    private $host = "localhost";
    private $db_name = "football";
    private $username = "root";
    private $password = "";
    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                                  $this->username, 
                                  $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>
```

### 2. **Model (`app/models/Player.php`)**
```php
<?php
require_once __DIR__ . "/../../config/Database.php";

class Player {
    private $conn;
    private $table = "players";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($name, $position, $team) {
        $query = "INSERT INTO " . $this->table . " (name, position, team) VALUES (:name, :position, :team)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['name' => $name, 'position' => $position, 'team' => $team]);
    }

    public function find($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $name, $position, $team) {
        $query = "UPDATE " . $this->table . " SET name = :name, position = :position, team = :team WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['id' => $id, 'name' => $name, 'position' => $position, 'team' => $team]);
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}
?>
```

### 3. **Controller (`app/controllers/PlayerController.php`)**
```php
<?php
require_once __DIR__ . "/../models/Player.php";

class PlayerController {
    private $playerModel;

    public function __construct() {
        $this->playerModel = new Player();
    }

    public function index() {
        $players = $this->playerModel->getAll();
        require __DIR__ . "/../views/players/index.php";
    }

    public function create() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->playerModel->create($_POST["name"], $_POST["position"], $_POST["team"]);
            header("Location: /players");
            exit();
        }
        require __DIR__ . "/../views/players/create.php";
    }

    public function edit($id) {
        $player = $this->playerModel->find($id);
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->playerModel->update($id, $_POST["name"], $_POST["position"], $_POST["team"]);
            header("Location: /players");
            exit();
        }
        require __DIR__ . "/../views/players/edit.php";
    }

    public function delete($id) {
        $this->playerModel->delete($id);
        header("Location: /players");
        exit();
    }
}
?>
```

### 4. **Views (`app/views/players/`)**
#### `index.php`
```php
<?php foreach ($players as $player) : ?>
    <p><?= $player['name'] ?> - <?= $player['position'] ?> - <?= $player['team'] ?> 
       <a href="/players/edit?id=<?= $player['id'] ?>">Edit</a>
       <a href="/players/delete?id=<?= $player['id'] ?>" onclick="return confirm('Delete this player?')">Delete</a>
    </p>
<?php endforeach; ?>
<a href="/players/create">Add Player</a>
```

#### `create.php`
```php
<form method="POST">
    <input type="text" name="name" placeholder="Name" required>
    <input type="text" name="position" placeholder="Position" required>
    <input type="text" name="team" placeholder="Team" required>
    <button type="submit">Save</button>
</form>
```

#### `edit.php`
```php
<form method="POST">
    <input type="text" name="name" value="<?= $player['name'] ?>" required>
    <input type="text" name="position" value="<?= $player['position'] ?>" required>
    <input type="text" name="team" value="<?= $player['team'] ?>" required>
    <button type="submit">Update</button>
</form>
```

### 5. **Routing (`routes/web.php`)**
```php
<?php
require_once __DIR__ . "/../app/controllers/PlayerController.php";

$controller = new PlayerController();

if ($_SERVER["REQUEST_URI"] == "/players") {
    $controller->index();
} elseif ($_SERVER["REQUEST_URI"] == "/players/create") {
    $controller->create();
} elseif (strpos($_SERVER["REQUEST_URI"], "/players/edit") !== false) {
    $controller->edit($_GET["id"]);
} elseif (strpos($_SERVER["REQUEST_URI"], "/players/delete") !== false) {
    $controller->delete($_GET["id"]);
}
?>
```

### 6. **Entry Point (`public/index.php`)**
```php
<?php
require_once __DIR__ . "/../routes/web.php";
?>
```

### 7. **.htaccess**
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ /public/index.php [QSA,L]
```

---

Dengan struktur ini, aplikasi CRUD pemain bola berbasis **PHP Native + MySQL dengan OOP dan MVC** sudah siap digunakan! 🚀