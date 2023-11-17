<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $nottitle = $_POST['nottitle'];
    $classid = $_POST['classid'];
    $notmsg = $_POST['notmsg'];
    $eid = $_GET['editid'];
    $sql = "update tblnotice set NoticeTitle=:nottitle,ClassId=:classid, NoticeMsg=:notmsg where ID=:eid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':nottitle', $nottitle, PDO::PARAM_STR);
    $query->bindParam(':classid', $classid, PDO::PARAM_STR);
    $query->bindParam(':notmsg', $notmsg, PDO::PARAM_STR);
    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
    $query->execute();
    echo '<script>alert("Noticia ha sido actualizada correctamente")</script>';
  }

?>

  <!-- partial:partials/_navbar.html -->
  <?php include_once('includes/header.php'); ?>
  <!-- partial -->
  <div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_sidebar.html -->
    <?php include_once('includes/sidebar.php'); ?>
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="page-header">
          <h3 class="page-title">Actualizar Noticia </h3>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page"> Actualizar Noticia</li>
            </ol>
          </nav>
        </div>
        <div class="row">

          <div class="col-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title" style="text-align: center;">Actualizar Noticia</h4>

                <form class="forms-sample" method="post" enctype="multipart/form-data">
                  <?php
                  $eid = $_GET['editid'];
                  $sql = "SELECT tblclass.ID,tblclass.ClassName,tblclass.Section,tblnotice.NoticeTitle,tblnotice.CreationDate,tblnotice.ClassId,tblnotice.NoticeMsg,tblnotice.ID as nid from tblnotice join tblclass on tblclass.ID=tblnotice.ClassId where tblnotice.ID=:eid";
                  $query = $dbh->prepare($sql);
                  $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                  $query->execute();
                  $results = $query->fetchAll(PDO::FETCH_OBJ);
                  $cnt = 1;
                  if ($query->rowCount() > 0) {
                    foreach ($results as $row) {               ?>
                      <div class="form-group">
                        <label for="exampleInputName1">Título Noticia</label>
                        <input type="text" name="nottitle" value="<?php echo htmlentities($row->NoticeTitle); ?>" class="form-control" required='true'>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail3">Noticia para</label>
                        <select name="classid" class="form-control">
                          <option value="<?php echo htmlentities($row->ClassId); ?>"><?php echo htmlentities($row->ClassName); ?><?php echo htmlentities($row->Section); ?></option>
                          <?php

                          $sql2 = "SELECT * from    tblclass ";
                          $query2 = $dbh->prepare($sql2);
                          $query2->execute();
                          $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                          foreach ($result2 as $row1) {
                          ?>
                            <option value="<?php echo htmlentities($row1->ID); ?>"><?php echo htmlentities($row1->ClassName); ?> <?php echo htmlentities($row1->Section); ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Mensaje</label>
                        <textarea name="notmsg" value="" class="form-control" required='true'><?php echo htmlentities($row->NoticeMsg); ?></textarea>
                      </div>
                  <?php $cnt = $cnt + 1;
                    }
                  } ?>
                  <button type="submit" class="btn btn-primary mr-2" name="submit">Actualizar</button>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
      <!-- partial:partials/_footer.html -->
      <?php include_once('includes/footer.php'); ?>
      <!-- partial -->
    </div>
    <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
<?php }  ?>