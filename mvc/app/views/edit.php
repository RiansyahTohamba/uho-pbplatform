<!-- #### `edit.php` -->
<form method="POST">
    <input type="text" name="name" value="<?= $player['name'] ?>" required>
    <input type="text" name="position" value="<?= $player['position'] ?>" required>
    <input type="text" name="team" value="<?= $player['team'] ?>" required>
    <button type="submit">Update</button>
</form>