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
(NULL, 'John', 'Doe', 'jdoe@email.com',  '$2y$10$XcvLG5OOBxiHszCoErABW.90u/SChekrutCFxHlIFfpJMgeCcRiei'),
(NULL, 'Amy', 'Spence', 'aspence@email.com',  '$2y$10$XcvLG5OOBxiHszCoErABW.90u/SChekrutCFxHlIFfpJMgeCcRiei'),
(NULL, 'Teko', 'Massiccio', 'teko@tekoface.com',  '$2y$10$XcvLG5OOBxiHszCoErABW.90u/SChekrutCFxHlIFfpJMgeCcRiei'),
(NULL, 'Nemaiah', 'Menaccia', 'nmen@email.com',  '$2y$10$XcvLG5OOBxiHszCoErABW.90u/SChekrutCFxHlIFfpJMgeCcRiei'),
(NULL, 'Bryce', 'Shaw', 'BShaw@email.com',  '$2y$10$XcvLG5OOBxiHszCoErABW.90u/SChekrutCFxHlIFfpJMgeCcRiei'),
(NULL, 'Carl', 'Evans', 'carl@email.com', '$2y$10$XcvLG5OOBxiHszCoErABW.90u/SChekrutCFxHlIFfpJMgeCcRiei');



CREATE TABLE authors (
    authorID int NOT NULL AUTO_INCREMENT,
    firstName varchar(50) NOT NULL,
    lastName varchar(50) NOT NULL,
    PRIMARY KEY (authorID)
);

INSERT INTO authors VALUES 
(NULL,'George', 'Orwell'),
(NULL,'Mark', 'Twain'),
(NULL,'JK', 'Rowling'),
(NULL,'J.R.R.', 'Tolkien'),
(NULL,'Ernest', 'Hemingway'),
(NULL,'Jane', 'Austen');

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
(NULL, 1, "1984", 1949, "/library/book_files/1.pdf"),
(NULL, 1, "Animal Farm", 1945, "/library/book_files/2.pdf"),
(NULL, 2, "The Adventures of Tom Sawyer", 1876, "/library/book_files/3.pdf"),
(NULL, 2, "The Prince and the Pauper", 1881, "/library/book_files/4.pdf"),
(NULL, 2, "The Adventures of Huckleberry Finn", 1884, "/library/book_files/5.pdf"),
(NULL, 3, "Harry Potter and the Philosopher's Stone", 1997, "/library/book_files/6.pdf"),
(NULL, 3, "Harry Potter and the Chamber of Secrets", 1898, "/library/book_files/7.pdf"),
(NULL, 4, "The Hobbit", 1937, "/library/book_files/8.pdf"),
(NULL, 4, "The Fellowship of the Ring", 1954, "/library/book_files/9.pdf"),
(NULL, 4, "The Two Towers", 1954, "/library/book_files/10.pdf"),
(NULL, 4, "The Return of the King", 1955, "/library/book_files/11.pdf"),
(NULL, 5, "The Old Man and the Sea", 1952, NULL),
(NULL, 5, "The Sun Also Rises", 1926, "/library/book_files/13.pdf"),
(NULL, 5, "A Moveable Feast", 1964, "/library/book_files/14.pdf"),
(NULL, 6, "Pride and Prejudice", 1813, "/library/book_files/15.pdf"),
(NULL, 6, "Sense and Sensibility", 1811, "/library/book_files/16.pdf");



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
(1,2),
(1,4),
(1,5),
(1,7),
(2,1),
(2,2),
(2,5),
(3,8),
(3,9),
(4,3),
(5,1),
(5,3),
(5,5),
(5,7),
(5,8),
(5,11),
(7,10),
(7,11),
(7,12);


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