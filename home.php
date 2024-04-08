<?php 
session_start();
include('includes/header.php'); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <?php
                if (isset($_SESSION['status']) && $_SESSION != '') {
                    echo $_SESSION['status'];
                ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>HEY!</strong> <?php  echo $_SESSION['status'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                    unset($_SESSION['status']);
                }
                ?>
            <div class="card">
                <div class="card-header">
                    <h4>Edit Or Delete Information </h4>
                </div>
                <div class="card-body">

                    <table class="table table-success table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">NAME</th>
                                <th scope="col">PHONE NUMBER</th>
                                <th scope="col">EMAIL</th>
                                <th scope="col">IMAGE</th>
                                <th scope="col">EDIT</th>
                                <th scope="col">DELETE</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            $connection = mysqli_connect("localhost", "root", "", "crud");

                            $fetch_image = "SELECT * FROM students";
                            $fetch_image_run = mysqli_query($connection, $fetch_image);

                            if (mysqli_num_rows($fetch_image_run) > 0) {
                                foreach ($fetch_image_run as $row) {
                                    
                            ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['phone']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td>
                                            <img src="<?php echo "uploads/".$row['image']; ?>" width="75" height="75" alt="image">
                                        </td>
                                        <td>
                                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-success">Edit</a>
                                        </td>
                                        <td>
                                            <form action="code.php" method="post">
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <input type="hidden" name="image" value="<?php echo $row['image']; ?>">
                                                <button type="submit" name="delete_info" class="btn btn-danger">Delete</button>

                                            </form>
                                            
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr colspan="5">NO RECORD FOUND</tr>
                            <?php

                            }

                            ?>


                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>