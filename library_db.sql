-- Create the tech_support database
DROP DATABASE IF EXISTS library_db;
CREATE DATABASE library_db;
USE library_db;

CREATE TABLE readers (
    readerID int NOT NULL AUTO_INCREMENT,
    firstName varchar(50) NOT NULL,
    lastName varchar(50) NOT NULL,
    email varchar(50) NOT NULL UNIQUE,
    password varchar(255) NOT NULL,
    PRIMARY KEY (readerID)
);

-- password is hashed "remember"
INSERT INTO readers VALUES 
(NULL, 'Alison', 'Diaz', 'alison@email.com',  '$2y$10$XcvLG5OOBxiHszCoErABW.90u/SChekrutCFxHlIFfpJMgeCcRiei'), 
(NULL, 'Jason', 'Lee', 'jason@email.com', '$2y$10$XcvLG5OOBxiHszCoErABW.90u/SChekrutCFxHlIFfpJMgeCcRiei');



CREATE TABLE authors (
    authorID int NOT NULL AUTO_INCREMENT,
    firstName varchar(50) NOT NULL,
    lastName varchar(50) NOT NULL,
    PRIMARY KEY (authorID)
);

INSERT INTO authors VALUES 
(NULL,'George', 'Orwell'),
(NULL,'Mark', 'Twain');

CREATE TABLE books (
    bookID int NOT NULL AUTO_INCREMENT,
    authorID int NOT NULL,
    title varchar(100) NOT NULL,
    publishYear smallint,
    filePath varchar(260),
    PRIMARY KEY (bookID),
    FOREIGN KEY (authorID) REFERENCES authors(authorID)
);

INSERT INTO books VALUES 
(NULL, 1, "1984", 1949, NULL),
(NULL, 1, "Animal Farm", 1945, NULL),
(NULL, 2, "The Adventures of Tom Sawyer", 1876, NULL);


CREATE TABLE selections (
    readerID int NOT NULL,
    bookID int NOT NULL,
    PRIMARY KEY (readerID, bookID),
    FOREIGN KEY (bookID) REFERENCES books(bookID)
    ON DELETE CASCADE,
    FOREIGN KEY (readerID) REFERENCES readers(readerID)
    ON DELETE CASCADE
);

INSERT INTO selections VALUES 
(1,1),
(2,1);


CREATE TABLE administrators (
  username    VARCHAR(40)    NOT NULL     UNIQUE,
  password    VARCHAR(255)    NOT NULL,
  PRIMARY KEY (username)
);

-- password is hashed "remember"
INSERT INTO administrators VALUES
('admin', '$2y$10$XcvLG5OOBxiHszCoErABW.90u/SChekrutCFxHlIFfpJMgeCcRiei'),
('joel', '$2y$10$XcvLG5OOBxiHszCoErABW.90u/SChekrutCFxHlIFfpJMgeCcRiei');


-- Create a user named ts_user
GRANT SELECT, INSERT, UPDATE, DELETE
ON *
TO lib_user@localhost
IDENTIFIED BY 'pa55word';