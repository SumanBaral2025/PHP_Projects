<?php
  // connecet to the database:---
  $servername="localhost";
  $username="root";
  $password="";
  $database="crud";

  $conn= mysqli_connect($servername,$username,$password,$database);
  if(!$conn){
    echo "<script>alert(\'We unable to Connect database'\)<script\>";}

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //  1. DELETE check comes first
        if (isset($_POST['deleteSno'])) {
          $sno = $_POST['deleteSno'];

          $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
          $result = mysqli_query($conn, $sql);
          if ($result) {
              echo "<script>alert('🗑️ Note deleted successfully!');</script>";
          } else {
              echo "<script>alert('❌ Delete failed!');</script>";
          }
      }
  
      //  2. UPDATE
      elseif(isset($_POST['sno'])) {
          $sno = $_POST['sno'];
          $title = $_POST["title"];
          $description = $_POST["description"];
  
          $sql = "UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `sno` = $sno";
          $result = mysqli_query($conn, $sql);
          if($result){
              echo "<script>alert('✅ Your Note has been Updated successfully!');</script>";
          } else {
              echo "<script>alert('❌ Update failed.');</script>";
          }
      }
  
      //  3. INSERT
      elseif(isset($_POST['title']) && isset($_POST['description'])) {
          $title = $_POST["title"];
          $description = $_POST["description"];
  
          $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
          $result = mysqli_query($conn, $sql);
          if($result){
              echo "<script>alert('✅ Your Note has been submitted successfully!');</script>";
          } else {
              echo "<script>alert('❌ Insert failed.');</script>";
          }
      }
  }
  
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD APP</title>
  <link rel="stylesheet" href="style.css?v=2">
  <link rel="stylesheet" href="//cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">

</head>

<body>

  <nav class="navbar">
    <div class="navbar-left">
      <img src="/crud/logo.svg" alt="PHP Logo" class="php-logo" />
      <span class="brand-name">Suman CRUD App</span>
    </div>
    <ul class="navbar-links">
      <li><a href="#">Home</a></li>
      <li><a href="#">About</a></li>
      <li><a href="#">Contact Us</a></li>
    </ul>
    <div class="navbar-search">
      <input type="text" placeholder="Search..." />
    </div>
  </nav>

  <div class="note-form-container">
    <form class="note-form" action="" method="post">
      <h2>Add a New Note</h2>
      <input type="text" id="titel" name="title" placeholder="Note Title" required />

      <textarea id="description" name="description" placeholder="Note Description" rows="5" required></textarea>
      <button type="submit">Add Note</button>
    </form>
  </div>

  <div class="table-container">
    <table class="custom-table" id="myTable">
      <thead>
        <tr>
          <th>S.No</th>
          <th>Title</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          $sql = "SELECT * FROM `notes`";
          $result = mysqli_query($conn, $sql);
          $sno = 0;
          while($row = mysqli_fetch_assoc($result)){
            $sno++;
            echo "<tr>
                    <td >$sno</td>
                    <td >{$row['title']}</td>
                    <td >{$row['description']}</td>
                    <td >
                      <button class='btn edit' id='{$row['sno']}'>Edit</button>
                      <button class='btn delete' id='d{$row['sno']}'>Delete</button>
                    </td>
                  </tr>";
          } 
        ?>
      </tbody>
    </table>
  </div>

  <!-- Edit Modal -->
  <div id="editModal" class="modal">
    <div class="modal-content">
      <span class="close-btn" id="closeModal">&times;</span>
      <h2>Edit Note</h2>
      <form id="editForm" method="POST">
        <input type="hidden" id="editSno" name="sno">
        <input type="text" id="editTitle" name="title" placeholder="Note Title" required>
        <textarea id="editDescription" name="description" rows="5" placeholder="Note Description" required></textarea>
        <button type="submit">Update Note</button>
      </form>
    </div>
  </div>
  <!-- Hidden Delete Form -->
  <form id="deleteForm" method="POST" style="display: none;">
    <input type="hidden" name="deleteSno" id="deleteSno">
  </form>

  <script>
            // Open modal when edit button is clicked
            document.querySelectorAll(".edit").forEach(button => {
              button.addEventListener("click", () => {
                const row = button.closest("tr");
                const sno = button.id;
                const title = row.children[1].innerText;
                const description = row.children[2].innerText;

                // Fill modal form fields
                document.getElementById("editSno").value = sno;
                document.getElementById("editTitle").value = title;
                document.getElementById("editDescription").value = description;

                // Show modal
                document.getElementById("editModal").style.display = "block";
              });
            });

            // Close modal
            document.getElementById("closeModal").onclick = () => {
              document.getElementById("editModal").style.display = "none";
            };

            // Close modal if clicked outside
            window.onclick = event => {
              if (event.target == document.getElementById("editModal")) {
                document.getElementById("editModal").style.display = "none";
              }
            };
  </script>

  <script>
            // Delete button logic
            document.querySelectorAll(".delete").forEach(button => {
              button.addEventListener("click", () => {
                const sno = button.id.substring(1); // remove 'd' prefix from id (e.g., d3 -> 3)
                if (confirm("⚠️ Are you sure you want to delete this note?")) {
                  document.getElementById("deleteSno").value = sno;
                  document.getElementById("deleteForm").submit();
                }
              });
            });
  </script>


  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
  <script>
          let table = new DataTable('#myTable');
  </script>

</body>

</html>
