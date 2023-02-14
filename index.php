<?php include 'view/header.php';
require_once('util/main.php'); ?>


<div class="h-100 d-flex align-self-centre align-items-center justify-content-center"
style="height:250px;">
  <div class = "border border-3" style="background:#e0ecff;height:150px;">
  <div class="container-fluid align-self-centre">
  <div> 
    <a href="admin?action=view_login"
    class="btn btn-primary" role="button" style="color: #FFFFFF;text-decoration: none; margin:10px;">Admin Portal</a>
  </div>
  <div>
      <a href="reader?action=view_login"
      class="btn btn-primary" role="button" style="color: #FFFFFF;text-decoration: none; margin:10px;">Reader Login</a>
  </div>


  </div>
  </div>
</div>




<?php include 'view/footer.php'; ?>