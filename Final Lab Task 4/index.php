<?php
$conn = mysqli_connect("localhost", "root", "", "student_management");

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

if (isset($_POST['add'])) {

    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $reg   = mysqli_real_escape_string($conn, $_POST['registration_no']);
    $dept  = mysqli_real_escape_string($conn, $_POST['department']);

    if ($name && $email && $reg && $dept) {
        mysqli_query($conn, "INSERT INTO students (name, email, registration_no, department)
        VALUES ('$name', '$email', '$reg', '$dept')");
    }
}

if (isset($_GET['delete'])) {

    $id = (int) $_GET['delete']; // ensure number

    if ($id > 0) {
        mysqli_query($conn, "DELETE FROM students WHERE id=$id");
    }
}

if (isset($_POST['update'])) {

    $id    = (int) $_POST['id'];
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $reg   = mysqli_real_escape_string($conn, $_POST['registration_no']);
    $dept  = mysqli_real_escape_string($conn, $_POST['department']);

    if ($id > 0) {
        mysqli_query($conn, "UPDATE students SET
            name='$name',
            email='$email',
            registration_no='$reg',
            department='$dept'
            WHERE id=$id");
    }
}

$result = mysqli_query($conn, "SELECT * FROM students");

$editData = null;

if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];

    if ($id > 0) {
        $res = mysqli_query($conn, "SELECT * FROM students WHERE id=$id");
        $editData = mysqli_fetch_assoc($res);
    }
}
?>


<h2>Student Form</h2>

<form method="POST">

<input type="hidden" name="id" value="<?php echo $editData['id'] ?? ''; ?>">

Name:
<input type="text" name="name" value="<?php echo $editData['name'] ?? ''; ?>">
<br><br>

Email:
<input type="text" name="email" value="<?php echo $editData['email'] ?? ''; ?>">
<br><br>

Registration No:
<input type="text" name="registration_no" value="<?php echo $editData['registration_no'] ?? ''; ?>">
<br><br>

Department:
<input type="text" name="department" value="<?php echo $editData['department'] ?? ''; ?>">
<br><br>

<?php if ($editData) { ?>
    <button type="submit" name="update">Update</button>
<?php } else { ?>
    <button type="submit" name="add">Add</button>
<?php } ?>

</form>

<hr>


<h2>Student Table</h2>

<table border="1" cellpadding="5">
<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Reg No</th>
    <th>Department</th>
    <th>Action</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>

<tr>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['registration_no']; ?></td>
    <td><?php echo $row['department']; ?></td>

    <td>
    <a href="index.php?edit=<?php echo $row['id']; ?>">Update</a> |
    <a href="index.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this student?')">Delete</a>
</td>
</tr>

<?php } ?>

</table>