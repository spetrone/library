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
            <h5><?php if ($page_type == 2) echo "Edit Book";
                      else echo "Add Book"?></h5>
            <form enctype="multipart/form-data" method="POST" 
                  action=<?php 
                            if ($page_type == 2) echo "./?action=edit_book";
                            else echo "./?action=add_book"; ?>>
                <div>
                    <label>Title:</label>
                    <input type="hidden" name="book_id" value = <?php
                     echo htmlspecialchars($book->getBookID()) ?>>
                    <input type="text" name="book_title" value="<?php 
                     echo htmlspecialchars($book->getTitle())?>">
                </div>

                <div>
                    <label>Author:</label>
                    <select name="author_selector" id="author_selector">
                        <!-- add all authors from db to drop down list -->
                        <?php foreach ($author_list as $author_li) : ?>
                        <option value=<?php echo htmlspecialchars($author_li['authorID']);
                            if ($page_type == 2) { //set to author if edit page
                                if($author_li['authorID'] == $book->getAuthorID()) {
                                    echo " selected";
                                }
                            }
                        ?>><?php echo htmlspecialchars($author_li['firstName'] . " " .
                            $author_li["lastName"]); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label>Publish Year:</label>
                    <input type="text" name="publish_year" value="<?php 
                    echo htmlspecialchars($book->getPublishYear())?>">
                </div>

                <div>
                    <label>ISBN10:</label>
                    <input type="text" name="isbn10" value="<?php 
                    echo htmlspecialchars($book->getIsbn10())?>">
                </div>

                <div>
                    <label>ISBN13:</label>
                    <input type="text" name="isbn13" value="<?php echo 
                    htmlspecialchars($book->getIsbn13())?>">
                </div>

                <div>
                    <input type="file" name="fileToUpload" id="fileToUpload">
                </div>

                <div>
                    <label>Current file:</label>
                    <a href="<?php echo 
                    htmlspecialchars($book->getFilepath())?>">
                </div>

                <div>
                    <input type="submit" name="save_edits" value="Save Edits">
                </div>
            </form>
        </div>
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