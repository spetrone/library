<?php 

class Book {
        // Properties
    private $book_id = "";
    private $title = "";
    private $author_id = "";

    private $full_name = "";

    private $first_name = "";

    private $last_name = "";

    private $isbn10 = "";

    private $isbn13 = "";

    private $filepath = "";

    private $publishyear = "";



    //getters and setters
    function getBookID() {
        return $this->book_id;
    }

    function setBookID($new_id) {
        $this->book_id = $new_id;
    }

    //getters and setters
    function getTitle() {
        return $this->title;
    }

    function setTitle($new_title) {
        $this->title = $new_title;
    }

    function getAuthorID() {
        return $this->author_id;
    }

    function setAuthorID($new_id) {
        $this->author_id = $new_id;
    }

    function getFirstName() {
        return $this->first_name;
    }

    function setFirstName($new_name) {
        $this->first_name = $new_name;
        $this->full_name = $this->first_name . " " . $this->last_name;
    }

    function getLastName() {
        return $this->last_name;
    }

    function setLastName($new_name) {
        $this->last_name = $new_name;
        $this->full_name = $this->first_name . " " . $this->last_name;
    }

    function getFullName() {
        return $this->full_name;
    }


    function getIsbn10() {
        return $this->isbn10;
    }

    function setIsbn10($new_isbn) {
        $this->isbn10 = $new_isbn;
    }

    function getIsbn13() {
        return $this->isbn13;
    }

    function setIsbn13($new_isbn) {
        $this->isbn13 = $new_isbn;
    }

    function getFilepath() {
        return $this->filepath;
    }

    function setFilepath($new_path) {
        $this->filepath = $new_path;
    }

    function getPublishYear() {
        return $this->publishyear;
    }

    function setPublishYear($new_year) {
        $this->publishyear = $new_year;
    }

    
}
?>