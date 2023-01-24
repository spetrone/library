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

INSERT INTO readers VALUES 
(NULL, 'Alison', 'Diaz', 'alison@email.com',  'sesame'), 
(NULL, 'Jason', 'Lee', 'jason@email.com', 'sesame');



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
    isbn10 varchar(13),
    isbn13 varchar(17),
    pubishYear smallint,
    PRIMARY KEY (bookID),
    FOREIGN KEY (authorID) REFERENCES authors(authorID)
);

INSERT INTO books VALUES 
(NULL, 1, "1984", NULL, NULL, 1949),
(NULL, 1, "Animal Farm", NULL, NULL, 1945),
(NULL, 2, "The Adventures of Tom Sawyer", NULL, NULL, 1876);


CREATE TABLE selections (
    readerID int NOT NULL,
    bookID int NOT NULL,
    PRIMARY KEY (readerID, bookID),
    FOREIGN KEY (bookID) REFERENCES books(bookID),
    FOREIGN KEY (readerID) REFERENCES readers(readerID)
);

INSERT INTO selections VALUES 
(1,1),
(2,1);


CREATE TABLE administrators (
  username    VARCHAR(40)    NOT NULL     UNIQUE,
  password    VARCHAR(40)    NOT NULL,
  PRIMARY KEY (username)
);

INSERT INTO administrators VALUES
('admin', 'sesame'),
('joel', 'sesame');


-- Create a user named ts_user
GRANT SELECT, INSERT, UPDATE, DELETE
ON *
TO lib_user@localhost
IDENTIFIED BY 'pa55word';