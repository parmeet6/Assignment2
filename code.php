<?php
session_start();

$connection = mysqli_connect("localhost", "root", "", "crud");

if (isset($_POST['save_info'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $image = $_FILES['image']['name'];

    if (file_exists("uploads/" . $_FILES['image']['name'])) {
        $filenmae = $_FILES['image']['name'];
        $_SESSION['status'] = $filenmae . " Image already exists.";
        header('location: index.php');
    } else {
        $insert = "INSERT INTO students(name,phone,email,image) VALUES ('$name','$phone','$email','$image')";
        $insert_run = mysqli_query($connection, $insert);

        if ($insert_run) {
            move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $_FILES['image']['name']);
            $_SESSION['status'] = "Record Saved Successfully!";
            header('Location: home.php');
        } else {
            $_SESSION['status'] = "Record not Saved Successfully!";
            header('Location: index.php');
        }
    }
}

if (isset($_POST['update_info'])) {
    $user_id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['image_old'];

    if ($new_image != '') {
        $update_filename = $new_image;
    } else {
        $update_filename = $old_image;
    }

    if (file_exists("uploads/" . $_FILES['image']['name'])) {
        $filenmae = $_FILES['image']['name'];
        $_SESSION['status'] = $filenmae . " Image already exists.";
        header("location: index.php");
    } else {
        $update_info = "UPDATE students SET name='$name', phone='$phone', email='$email', image='$update_filename' WHERE id='$user_id' ";
        $update_info_run = mysqli_query($connection, $update_info);


        if ($update_info_run) {
            if ($_FILES['image']['name'] != '') {
                move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $_FILES['image']['name']);
                unlink('uploads/' . $old_image);
            }
            $_SESSION['status'] = "User Information Updated Successfully!";
            header("location: home.php");
        } else {
            $_SESSION['status'] = "User Information Updated failed!";
            header("location: edit.php");
        }
    }
}

if(isset($_POST['delete_info']))
{
    $id =$_POST['id'];
    $image = $_POST['image'];

    $delete_info = "DELETE FROM students WHERE id='$id' ";
    $delete_info_RUN = mysqli_query($connection, $delete_info);

    if ($delete_info_RUN) 
    {
        unlink( 'uploads/'.$image );
        $_SESSION['status']="Information Deleted Successfully!";
        header( "Location: home.php" );
    }
    else
    {
        $_SESSION['status']="Information Not Deleted Successfully!";
        header( "Location: home.php" );
    }
}

