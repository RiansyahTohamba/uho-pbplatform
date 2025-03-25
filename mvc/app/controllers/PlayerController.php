<!-- ### 3. **Controller (`app/controllers/PlayerController.php`)** -->
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
