<?php

session_start();
include ('../config/connection.php');

//memastikan bahwa student yang login
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: ../logreg/login.php");
    exit;
}

$id_student = $_SESSION['user_id'];

//ngambil data aspirasi punya siswa yg login
$query = mysqli_query($conn, "SELECT * FROM aspirations WHERE id_student = '$id_student' ORDER BY date_submitted DESC");


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
  </head>
  <body>
    <h2>WELCOME, STUDENT!</h2>
    <a href="../logreg/logout.php">Logout</a><br />
    <a href="../students/buat-aspirasi.php">Buat Aspirasi Baru</a><br />

    <table>
      <tr>
        <th>No</th>
        <th>Title</th>
        <th>Content</th>
        <th>Status</th>
        <th>Response</th>
        <th>Date</th>
        <th>Action</th>
      </tr>

      <?php
      if (mysqli_num_rows($query) > 0) {
        $no = 1;
        while ($row = mysqli_fetch_assoc($query)) {
        echo "<tr>
                <td>{$no}</td>
                <td>{$row['title']}</td>
                <td>{$row['content']}</td>
                <td>{$row['status']}</td>
                <td>" . ($row['response'] ?: '-') . " </td>
                <td>{$row['date_submitted']}</td>
                <td><a href='hapus_aspirasi.php?id={$row['id_aspiration']}'>Delete</a></td>
             </tr>";
             $no++;
        }
      } else {
        echo "<tr><td colspan='7'> No aspiration submitted yet.</td></tr>";
      }
      ?>
    </table>

  </body>
</html>
