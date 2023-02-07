<?php 
include ('view/header.php');

redirect_no_session();
redirect_not_admin(); //for admins only

if (!isset($page_type)) {
    $page_type = 1;} //default to add page (type 1)
//page_type 2 is editing


?>

<div>
    <!-- Search form for querying books by author or title -->
    <div class="row">
        <div class="col">
            <h5>Edit Book</h5>
    </div>
    <div class="row">
        <div class="col">
            <p><?php echo $success_message ?></p>
            <p><?php echo $upload_msg ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <a href="./?action=load_books">Back to Search</a>
        </div>
    </div>

</div>

<?php include 'view/footer.php'; ?>