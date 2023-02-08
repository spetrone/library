<?php 
include ('view/header.php');

redirect_no_session();

?>
<!-- include jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<div>
    <!-- Search form for querying books by author or title -->
    <div class="row">
        <div class="col">
            <form id="search_form" action="./?action=query_books" method="POST">

                <label for="cars">Query Type:</label>
                <select name="type_selector" id="type_selector">
                <option value="lastname">Author lastname</option>
                <option value="title">title</option>
                </select>

                <label>Enter Query:</label>
                <input name="query" type=text>
                <input type="submit" name="search_button" value="search">

            </form>
            <p id="msg"></p>
        </div>
    </div>
   
    <div class="row">

        
        <div class="col">
            <h5>Books </h5>
            <div>
            <form  action="./?action=add_book" method="POST">
                <input type="submit" name="add_button" value="Add Book">
            </form>
            </div>
            <!-- list all books returned from request to server
                on initial page load, this is all books in the db-->
            <table class="table">
                <tr>
                    <td>Book Title</td>
                    <td>Author</td>
                    <td>Year</td>
                    <td>PDF</td>
                    <?php if (isset($_SESSION['admin'])) : ?>
                        <td>Action</td>
                    <?php endif; ?>
                </tr>

                <div id="table_contents">
                <?php foreach ($all_books as $book) : ?>
                <tr>
                    <td><?php echo $book["title"]?></td>
                    <td><?php echo htmlspecialchars($book["firstName"]) . " " . htmlspecialchars($book["lastName"])?></td>
                    <td><?php echo htmlspecialchars($book["publishYear"])?></td>

                    <!-- show pdf link if there is one for the book -->
                    <?php if($book["filePath"] != "") : ?>
                        <td><a href=<?php echo htmlspecialchars($book["filePath"]); ?>>PDF</a></td>
                    <?php else : ?>
                        <td><!-- no pdf, leave empty --></td>
                    <?php endif; ?>

                    <!-- Column for editing and deleting books - admin only -->
                    <?php if (isset($_SESSION['admin'])) : ?>
                    <td>
                        <form style="display:inline-block;" action="./?action=show_edit_book" method="POST">
                            <input type="hidden" name="selected_book" 
                                value = <?php echo htmlspecialchars($book["bookID"])?>>
                            <input type="submit" name="edit_button" value="edit">
                        </form>
                        <form style="display:inline-block;" action="../admin/manage_books/?action=delete_book" method="POST">
                            <input type="hidden" name="selected_book" 
                                value = <?php echo htmlspecialchars($book["bookID"])?>>
                            <input type="submit" name="delete_button" value="delete">
                        </form>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>

                </div>
            </table>
        </div>

    </div>


</div>

<script>
// Attach a submit handler to the form
$( "#search_form" ).submit(function( event ) {

    var $form = $( this )

    // Get all the forms elements
    var sdata = $(this).serialize();
 
    // Stop form from submitting normally
    event.preventDefault();

    var action_url = $form.attr( "action" );

    var request = $.ajax({
        type: 'POST',
        url: action_url,
        data: sdata,
        dataType: "text",
        //   success: function(resultData) {
            
        //      var result_list = JSON.parse(resultData);
        //      alert("here");
        //      alert(result_list);
        //      }
    });


  // Callback handler that will be called on success
  request.done(function(resultData) {
        
    result_list = JSON.parse(resultData);
    alert(result_list[0]["title"]);
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });
 
});

 
</script>

<?php include 'view/footer.php'; ?>