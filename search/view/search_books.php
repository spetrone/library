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
            <table class="table" id="main_table">
                <tr>
                    <td>Book Title</td>
                    <td>Author</td>
                    <td>Year</td>
                    <td>PDF</td>
                    <td>Action</td>

                </tr>

                <?php foreach ($all_books as $book) : ?>
                <tr class="book_item">
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
                    <!-- possiblilty for readers to add book to list -->
                    <?php if (isset($_SESSION['reader'])) : ?>
                    <td>
                        <form  action="./?action=add_to_list" method="POST">
                            <input type="hidden" name="selected_book" 
                                value = <?php echo htmlspecialchars($book["bookID"])?>>
                            <input type="submit" name="addlist_button" value="add to list">
                        </form>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>

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
    console.log(action_url);

    var request = $.ajax({
        type: 'POST',
        url: action_url,
        data: sdata,
        dataType: "text",
        
    });


  // Callback handler that will be called on success
  request.done(function(resultData) {
    console.log(resultData);
    var result_list = JSON.parse(resultData);
    var result_table = document.createElement("div");

    //remove old content, then add each row
    $('#main_table tr').slice(1).remove();
   
    result_list.forEach(function(bookObj) {
        var tabrow = document.createElement("tr");
        console.log(bookObj);

        //extract title, author name, publish year and file path
            var tabdata = document.createElement("td");
            var node = document.createTextNode(bookObj['title']);
            tabdata.appendChild(node);
            tabrow.appendChild(tabdata);

            var tabdata = document.createElement("td");
            var node = document.createTextNode(bookObj['firstName'].concat(" ", bookObj['lastName'] ) );
            tabdata.appendChild(node);
            tabrow.appendChild(tabdata);

            var tabdata = document.createElement("td");
            var node = document.createTextNode(bookObj['publishYear'] );
            tabdata.appendChild(node);
            tabrow.appendChild(tabdata);

            var tabdata = document.createElement("td");
            //only set if it is set in object
            if(bookObj["filePath"] != null && bookObj["filePath"] != "" ) {
                var tablink = document.createElement("a");
                tablink.setAttribute("href", bookObj["filePath"]);
                var node = document.createTextNode("PDF");
                tablink.appendChild(node);
                tabdata.appendChild(tablink);
            }
            tabrow.appendChild(tabdata);

            //set add/delete buttons if admin, add to list button if reader
            tabdata = document.createElement("td");

            if ( Number(<?php if (isset($_SESSION['admin'])) echo 1;
                      else echo 0; ?>)) 
            {

                var formel = document.createElement("form");
                formel.setAttribute("action", "./?action=show_edit_book");
                formel.setAttribute("method", "POST");
                formel.setAttribute("style", "display:inline-block;");
                var hidden = document.createElement("input");
                hidden.setAttribute("type", "hidden");
                hidden.setAttribute("name", "selected_book");
                hidden.setAttribute("value", bookObj["bookID"]);
                var submit = document.createElement("input");
                submit.setAttribute("type", "submit");
                submit.setAttribute("name", "edit_button");
                submit.setAttribute("value", "edit");
                formel.appendChild(hidden);
                formel.appendChild(submit);

                tabdata.appendChild(formel);

                var formel = document.createElement("form");
                formel.setAttribute("action", "../admin/manage_books/?action=delete_book");
                formel.setAttribute("method", "POST");
                formel.setAttribute("style", "display:inline-block;");
                var hidden = document.createElement("input");
                hidden.setAttribute("type", "hidden");
                hidden.setAttribute("name", "selected_book");
                hidden.setAttribute("value", bookObj["bookID"]);
                var submit = document.createElement("input");
                submit.setAttribute("type", "submit");
                submit.setAttribute("name", "delete_button");
                submit.setAttribute("value", "delete");
                formel.appendChild(hidden);
                formel.appendChild(submit);

                tabdata.appendChild(formel);
            }

            if ( Number(<?php if (isset($_SESSION['reader'])) echo 1;
                      else echo 0; ?>)) 
            {
                var formel = document.createElement("form");
                formel.setAttribute("action", "./?action=add_to_list");
                formel.setAttribute("method", "POST");
                var hidden = document.createElement("input");
                hidden.setAttribute("type", "hidden");
                hidden.setAttribute("name", "selected_book");
                hidden.setAttribute("value", bookObj["bookID"]);
                var submit = document.createElement("input");
                submit.setAttribute("type", "submit");
                submit.setAttribute("name", "addlist_button");
                submit.setAttribute("value", "add to list");
                formel.appendChild(hidden);
                formel.appendChild(submit);

                tabdata.appendChild(formel);
            }

            tabrow.appendChild(tabdata);


        $( "#main_table").append(tabrow);
    })

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