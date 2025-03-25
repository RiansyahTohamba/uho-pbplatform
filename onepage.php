<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "testdb";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// CREATE
if (isset($_POST['create'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $sql = "INSERT INTO users (nama, email) VALUES ('$nama', '$email')";
    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil ditambahkan";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// READ
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>Nama</th><th>Email</th><th>Aksi</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["nama"] . "</td><td>" . $row["email"] . "</td><td><a href='?edit=" . $row["id"] . "'>Edit</a> | <a href='?delete=" . $row["id"] . "'>Hapus</a></td></tr>";
    }
    echo "</table>";
} else {
    echo "Tidak ada data";
}

// UPDATE
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $sql = "UPDATE users SET nama='$nama', email='$email' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil diupdate";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil dihapus";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Form CREATE
echo "<form method='post' action=''>";
echo "Nama: <input type='text' name='nama'><br>";
echo "Email: <input type='email' name='email'><br>";
echo "<input type='submit' name='create' value='Tambah'>";
echo "</form>";

// Form UPDATE (jika ada parameter edit)
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    echo "<form method='post' action=''>";
    echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
    echo "Nama: <input type='text' name='nama' value='" . $row['nama'] . "'><br>";
    echo "Email: <input type='email' name='email' value='" . $row['email'] . "'><br>";
    echo "<input type='submit' name='update' value='Update'>";
    echo "</form>";
}

$conn->close();
?>