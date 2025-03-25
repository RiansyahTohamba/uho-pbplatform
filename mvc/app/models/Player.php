<!-- ### 2. **Model (`app/models/Player.php`)** -->
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
