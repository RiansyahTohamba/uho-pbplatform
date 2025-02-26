Pada studi kasus **CRUD pemain bola** dengan pendekatan **MVC** dan **PHP Native**, fitur **session** bisa digunakan untuk beberapa keperluan, seperti:  

1. **Autentikasi Pengguna** (Login/Logout).  
2. **Menampilkan Pesan Notifikasi** (Flash Message) setelah operasi CRUD (misal: *Data berhasil ditambahkan!*).  
3. **Menyimpan Data Sementara** seperti filter pencarian atau status tertentu.

---

## 💡 **Studi Kasus: Implementasi Session untuk Login dan Flash Message**

### 📂 **Struktur Folder**
```
/php-mvc
│── /app
│   │── /controllers
│   │   ├── AuthController.php
│   │   ├── PlayerController.php
│   │── /models
│   │   ├── User.php
│   │── /views
│   │   ├── auth
│   │   │   ├── login.php
│   │   ├── players
│   │   │   ├── index.php
│── /config
│   │── Database.php
│── /public
│   │── index.php
│── /routes
│   │── web.php
│── /middlewares
│   │── AuthMiddleware.php
│── .htaccess
```

---

## 🎲 **1. Skema Database User (`users` Table)**

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL, -- Disimpan dalam bentuk hash (bcrypt)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, password) VALUES
('admin', PASSWORD('admin123'));
```

---

## 🔐 **2. Konfigurasi Session (`public/index.php`)**

```php
<?php
session_start(); // Memulai sesi PHP

require_once __DIR__ . "/../routes/web.php";
```

---

## 🧑‍💻 **3. Model User (`app/models/User.php`)**

```php
<?php
require_once __DIR__ . "/../../config/Database.php";

class User {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function login($username, $password) {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true;
        }
        return false;
    }

    public function logout() {
        session_destroy();
        header("Location: /login");
        exit();
    }
}
```

---

## 📂 **4. Controller untuk Login (`app/controllers/AuthController.php`)**

```php
<?php
require_once __DIR__ . "/../models/User.php";

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if ($this->userModel->login($username, $password)) {
                $_SESSION['flash_message'] = "Login berhasil! Selamat datang, $username.";
                header("Location: /players");
                exit();
            } else {
                $_SESSION['flash_message'] = "Username atau password salah!";
            }
        }
        require __DIR__ . "/../views/auth/login.php";
    }

    public function logout() {
        $this->userModel->logout();
    }
}
```

---

## 🚧 **5. Middleware untuk Autentikasi (`middlewares/AuthMiddleware.php`)**

```php
<?php
class AuthMiddleware {
    public static function isAuthenticated() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash_message'] = "Silakan login terlebih dahulu.";
            header("Location: /login");
            exit();
        }
    }
}
```

---

## 📢 **6. Menampilkan Flash Message di View (`app/views/players/index.php`)**

```php
<?php
if (isset($_SESSION['flash_message'])) {
    echo "<p style='color: green;'>" . $_SESSION['flash_message'] . "</p>";
    unset($_SESSION['flash_message']);
}
?>

<h1>Data Pemain Bola</h1>
<p>Halo, <?= $_SESSION['username'] ?>! <a href="/logout">Logout</a></p>

<?php foreach ($players as $player) : ?>
    <p><?= $player['name'] ?> - <?= $player['position'] ?> - <?= $player['team'] ?></p>
<?php endforeach; ?>

<a href="/players/create">Tambah Pemain</a>
```

---

## 🧾 **7. View untuk Form Login (`app/views/auth/login.php`)**

```php
<h2>Login</h2>

<?php
if (isset($_SESSION['flash_message'])) {
    echo "<p style='color: red;'>" . $_SESSION['flash_message'] . "</p>";
    unset($_SESSION['flash_message']);
}
?>

<form method="POST" action="/login">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
```

---

## 🚦 **8. Routing untuk Login dan Middleware (`routes/web.php`)**

```php
<?php
require_once __DIR__ . "/../app/controllers/AuthController.php";
require_once __DIR__ . "/../app/controllers/PlayerController.php";
require_once __DIR__ . "/../middlewares/AuthMiddleware.php";

$authController = new AuthController();
$playerController = new PlayerController();

if ($_SERVER["REQUEST_URI"] == "/login") {
    $authController->login();
} elseif ($_SERVER["REQUEST_URI"] == "/logout") {
    $authController->logout();
} else {
    AuthMiddleware::isAuthenticated(); // Middleware untuk proteksi halaman

    if ($_SERVER["REQUEST_URI"] == "/players") {
        $playerController->index();
    } elseif ($_SERVER["REQUEST_URI"] == "/players/create") {
        $playerController->create();
    }
}
```

---

## 🚀 **9. Testing Alur Login & Flash Message**

1. **Akses `/login`** untuk masuk sebagai admin.
2. Masukkan **username dan password** yang sudah di-*seed*.
3. Jika berhasil, diarahkan ke **/players** dengan **flash message sukses**.
4. Cobalah logout, dan coba akses **/players** tanpa login, akan diarahkan kembali ke **/login**.

---

Dengan implementasi ini, sistem memiliki keamanan dasar dan pengalaman pengguna yang lebih baik dengan **flash message** yang informatif! 😊