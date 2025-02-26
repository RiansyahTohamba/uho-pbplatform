Berikut ini adalah skema database dan cara melakukan **seeding** data untuk studi kasus **CRUD pemain bola** menggunakan **PHP Native + MySQL** dengan pendekatan **OOP dan MVC**.

---

## 🎲 **1. Skema Database**
### **Nama Database:** `football`

### **Tabel:** `players`

```sql
CREATE DATABASE football;

USE football;

CREATE TABLE players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    position VARCHAR(50) NOT NULL,
    team VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

---

## 🌱 **2. Seeding Data**
### **Cara Seed Data Menggunakan SQL**
```sql
INSERT INTO players (name, position, team) VALUES
('Lionel Messi', 'Forward', 'Inter Miami'),
('Cristiano Ronaldo', 'Forward', 'Al-Nassr'),
('Kevin De Bruyne', 'Midfielder', 'Manchester City'),
('Virgil van Dijk', 'Defender', 'Liverpool'),
('Manuel Neuer', 'Goalkeeper', 'Bayern Munich');
```

---

## 🚀 **3. Seed Data Menggunakan PHP (`seeder.php`)**
### **Membuat File Seeder**
```php
<?php
require_once __DIR__ . "/config/Database.php";

class Seeder {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function seedPlayers() {
        $players = [
            ['Lionel Messi', 'Forward', 'Inter Miami'],
            ['Cristiano Ronaldo', 'Forward', 'Al-Nassr'],
            ['Kevin De Bruyne', 'Midfielder', 'Manchester City'],
            ['Virgil van Dijk', 'Defender', 'Liverpool'],
            ['Manuel Neuer', 'Goalkeeper', 'Bayern Munich']
        ];

        $query = "INSERT INTO players (name, position, team) VALUES (:name, :position, :team)";

        foreach ($players as $player) {
            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                'name' => $player[0],
                'position' => $player[1],
                'team' => $player[2]
            ]);
        }

        echo "Seeding completed!";
    }
}

$seeder = new Seeder();
$seeder->seedPlayers();
```

### **Cara Menjalankan Seeder**
1. Simpan file seeder sebagai `seeder.php` di **root project**.
2. Jalankan di terminal:
```sh
php seeder.php
```

---

## 📊 **Hasil Data Tabel `players`**
```sql
SELECT * FROM players;
```

| id | name             | position  | team           | created_at        | updated_at        |
|----|------------------|-----------|----------------|-------------------|-------------------|
| 1  | Lionel Messi     | Forward   | Inter Miami    | 2025-02-18 10:00:00 | 2025-02-18 10:00:00 |
| 2  | Cristiano Ronaldo| Forward   | Al-Nassr       | 2025-02-18 10:00:00 | 2025-02-18 10:00:00 |
| 3  | Kevin De Bruyne  | Midfielder| Manchester City| 2025-02-18 10:00:00 | 2025-02-18 10:00:00 |
| 4  | Virgil van Dijk  | Defender  | Liverpool      | 2025-02-18 10:00:00 | 2025-02-18 10:00:00 |
| 5  | Manuel Neuer     | Goalkeeper| Bayern Munich  | 2025-02-18 10:00:00 | 2025-02-18 10:00:00 |

---

Dengan skema dan seeding di atas, database **`football`** siap digunakan untuk **CRUD pemain bola** di proyek **PHP MVC**! 🚀😊