<?php
include ('../config/connection.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $role = mysqli_real_escape_string($conn, $_POST['role']); // ambil dari radio button

  // Hash password biar aman
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  if ($role == 'admin') {
    // Cek apakah email sudah ada di tabel admins
    $check = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
      echo "Email sudah terdaftar sebagai admin!";
    } else {
      // Simpan ke tabel admins
      $query = "INSERT INTO admins (name, email, password, role)
                VALUES ('$name', '$email', '$hashed_password', 'admin')";
      if (mysqli_query($conn, $query)) {
        echo "Registrasi admin berhasil! <a href='login.php'>Login</a>";
      } else {
        echo "Error: " . mysqli_error($conn);
      }
    }
  } elseif ($role == 'student') {
    // Cek apakah email sudah ada di tabel students
    $check = mysqli_query($conn, "SELECT * FROM students WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
      echo "Email sudah terdaftar sebagai student!";
    } else {
      // Simpan ke tabel students
      $query = "INSERT INTO students (name, email, password)
                VALUES ('$name', '$email', '$hashed_password')";
      if (mysqli_query($conn, $query)) {
        echo "Registrasi student berhasil! <a href='login.php'>Login</a>";
      } else {
        echo "Error: " . mysqli_error($conn);
      }
    }
  } else {
    echo "Pilih role terlebih dahulu!";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
  </head>
  <body>
    <form action="" method="post">
      <h2>Registrasi</h2>
      <label for="">Name</label>
      <input type="text" name="name" required /><br />

      <label for="">Email</label>
      <input type="email" name="email" required /><br />

      <label for="">Password</label>
      <input type="password" name="password" required /><br />

      <label class="label">Role:</label>
      <input type="radio" name="role" value="admin" /> Admin
      <input type="radio" name="role" value="student" /> Student <br />

      <button type="submit">Kirim</button>
    </form>
  </body>
</html>
