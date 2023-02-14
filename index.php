<?php include 'view/header.php';
require_once('util/main.php'); ?>


<div class="h-100 d-flex align-self-centre align-items-center justify-content-center"
style="height:250px;">
  <div class = "border border-3" style="background:#e0ecff;height:150px;">
  <div class="container-fluid align-self-centre">
  <div>
      <button type="button" class="btn btn-primary" style="margin:10px"><a href="admin?action=view_login"
      style="color: #FFFFFF;text-decoration: none;">Admin Portal</a></button>
  </div>
  <div>
      <button type="button" class="btn btn-primary" style="margin:10px"><a href="reader?action=view_login"
      style="color: #FFFFFF;text-decoration: none;">Reader Login</a></button>
  </div>


  </div>
  </div>
</div>




<?php include 'view/footer.php'; ?>