<?php
$inserted = false;
$update = false;
$delete = false;
//Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die ("Connection failed: " . $conn->connect_error);
}

if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  // echo $sno;
  $sql = "DELETE FROM `notes` WHERE `notes`.`sno` = $sno ";
  $result = mysqli_query($conn, $sql);
  if($result){
    $delete = true;
  }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if(isset($_POST['snoEdit'])) {
    //Update the record
    $sno = $_POST['snoEdit'];
    $title = $_POST['titleedit'];
    $desc = $_POST['descedit'];
    // echo $sno,$title,$desc;
    $sql = "UPDATE `notes` SET `title`='$title' , `desc`='$desc' WHERE `notes`.`sno`='$sno' ";
    $result = mysqli_query( $conn, $sql );
    if($result){
      $update = true;
    }
  }else{
    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $sql = "INSERT INTO `notes`(`title`, `desc`) VALUES ('$title','$desc')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $inserted = true;
    } else {
      echo "The Record was not successfully inserted because of this error --->" . mysqli_error($conn);
    }
  }
}

?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css">

  <title>NoteKeeper</title>
</head>

<body>

  <!-- edit Modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
  Edit Modal
</button> -->

<!-- edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/NoteKeeper/index.php" method="POST">
      <div class="modal-body">
        <input type="hidden" name="snoEdit" id="snoEdit" >
      <div class="form-group">
        <label for="title">Note Title</label>
        <input type="text" class="form-control" id="titleedit" name="titleedit" aria-describedby="emailHelp">
      </div>
      <div class="form-group">
        <label for="desc">Note Description</label>
        <textarea class="form-control" id="descedit" name="descedit" rows="5"></textarea>
      </div>
      <!-- <button type="submit" class="btn btn-primary">Update Note</button> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
    </form>
  </div>
</div>


  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">NoteKeeper</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact Us</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </nav>

  <?php

  if ($inserted) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Your note has been successfully added.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  }
  if ($update) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Your note has been successfully updated.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  }
  if ($delete) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Your note has been successfully deleted.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  }

  ?>

  <div class="container my-4">
    <h2>Add a Note</h2>
    <form action="/NoteKeeper/index.php" method="POST">
      <div class="form-group">
        <label for="title">Note Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
      </div>
      <div class="form-group">
        <label for="desc">Note Description</label>
        <textarea class="form-control" id="desc" name="desc" rows="5"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
  </div>

  <div class="container">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">Sno</th>
          <th scope="col">Title</th>
          <th scope="col">Desc</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM `notes`";
        $result = mysqli_query($conn, $sql);
        $sno = 0;
        while ($row = mysqli_fetch_array($result)) {
          $sno++;
          echo " <tr>
        <th scope='row' class='text-center' >".$sno."</th>
        <td>" . $row['title'] . "</td>
        <td>" . $row['desc'] . "</td>
        <td><a class='edit btn btn-sm btn-primary' id=".$row['sno']." >Edit</a> <a class='delete btn btn-sm btn-danger' id=d".$row['sno']." >Delete</a></td>
                </tr>";
        }
        ?>

      </tbody>
    </table>
  </div>
  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
    crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
    integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+"
    crossorigin="anonymous"></script>

  <script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
  <script>
    let table = new DataTable('#myTable');
  </script>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element)=>{
      element.addEventListener("click",(e)=>{
        console.log("edit",e.target.parentNode.parentNode);
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title,description);
        descedit.value = description;
        titleedit.value = title;
        snoEdit.value = e.target.id;
        console.log(e.target.id);
        $('#editModal').modal('toggle')
      })
    });
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element)=>{
      element.addEventListener("click",(e)=>{
        console.log("delete",e.target.parentNode.parentNode);
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        sno=e.target.id.substr(1,);
        console.log(sno);
        if(confirm("Are you sure,you want to delete this note ?")){
          console.log(sno);
          console.log("yes");
          window.location= `/NoteKeeper/index.php?delete=${sno}`;
          //TODO:create a form use post request to submit a form
        }else{
          console.log("no");
        }
      })
    });
  </script>
</body>

</html>