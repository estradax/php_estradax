<?php
$host = '127.0.0.1';
$user = 'root';
$pass = '12345678';
$db   = 'testdb';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("error: " . mysqli_connect_error());
}

$q = $_GET['q'] ?? '';
$q = mysqli_real_escape_string($conn, $q);

$sql = "
  SELECT
    hobi,
    COUNT(DISTINCT person_id) AS jumlah_orang
  FROM hobi";

$sql .= "
  WHERE hobi LIKE '%$q%'
";

$sql .= "
  GROUP BY hobi
  ORDER BY jumlah_orang DESC
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Soal 2</title>
    <style>
        table { border-collapse: collapse; width: 50%; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <form action="soal2.php" method="get" style="margin-bottom: 1rem;">
      <div>
        <label>Search by hobi</label>
        <input type="text" name="q" value="<?= $q ?>" />
      </div>
      <button>Search</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>Hobi</th>
                <th>Jumlah Orang</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['hobi']) ?></td>
                    <td><?= $row['jumlah_orang'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

<?php
mysqli_close($conn);
?>

