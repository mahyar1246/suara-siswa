
<?php
session_start();
include('../config/connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $role = mysqli_real_escape_string($conn, $_POST['role']);
  $otorization = isset($_POST['otorization']) ? mysqli_real_escape_string($conn, $_POST['otorization']) : '';

  if ($role == 'student') {
    // Login student
    $query = mysqli_query($conn, "SELECT * FROM students WHERE email='$email'");
    if (mysqli_num_rows($query) > 0) {
      $student = mysqli_fetch_assoc($query);
      if (password_verify($password, $student['password'])) {
        $_SESSION['user_id'] = $student['id_student'];
        $_SESSION['role'] = 'student';
        header("Location: ../students/dashboard.php");
        exit;
      } else {
        echo "<script>alert('Password salah!');</script>";
      }
    } else {
      echo "<script>alert('Email tidak ditemukan sebagai student!');</script>";
    }

  } elseif ($role == 'admin') {
    // Login admin
    $query = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email'");
    if (mysqli_num_rows($query) > 0) {
      $admin = mysqli_fetch_assoc($query);

      // Verifikasi password dulu
      if (password_verify($password, $admin['password'])) {

        // Lalu cek kode otorisasi
        if ($otorization === "SEKOLAHMAJU") {
          $_SESSION['user_id'] = $admin['id_admin'];
          $_SESSION['role'] = 'admin';
          header("Location: ../admin/dashboard.php");
          exit;
        } else {
          echo "<script>alert('Kode otorisasi salah! Hubungi administrator utama.');</script>";
        }

      } else {
        echo "<script>alert('Password salah!');</script>";
      }
    } else {
      echo "<script>alert('Email tidak ditemukan sebagai admin!');</script>";
    }

  } else {
    echo "<script>alert('Pilih role terlebih dahulu!');</script>";
  }
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
  </head>
  <body>
    <form action="" method="post">
      <h2>Login</h2>
      <label for="">Email</label>
      <input type="email" name="email" placeholder="email" required /><br />
      <label for="">Passrord</label>
      <input type="password" name="password" placeholder="password" required /><br />
      <label class="label">Role: </label>
        <input type="radio" name="role" value="admin" />admin
        <input type="radio" name="role" value="student" />student<br />
        <label for="">Otorization</label>
      <input type="password" name="otorization" placeholder="opsional"/><br />
      <button type="submit">Login</button>
    </form>
  </body>
</html>
