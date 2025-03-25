<!-- ### 5. **Routing (`routes/web.php`)** -->
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
