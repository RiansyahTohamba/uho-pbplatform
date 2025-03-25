<!-- ### 4. **Views (`app/views/players/`)**
#### `index.php` -->
<?php foreach ($players as $player) : ?>
    <p><?= $player['name'] ?> - <?= $player['position'] ?> - <?= $player['team'] ?> 
       <a href="/players/edit?id=<?= $player['id'] ?>">Edit</a>
       <a href="/players/delete?id=<?= $player['id'] ?>" onclick="return confirm('Delete this player?')">Delete</a>
    </p>
<?php endforeach; ?>
<a href="/players/create">Add Player</a>