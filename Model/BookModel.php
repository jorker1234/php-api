<?php
    require_once PROJECT_ROOT_PATH . "/Model/Database.php";

    class BookModel extends Database
    {
        public function list($limit)
        {
            return $this->select("SELECT * FROM books ORDER BY id ASC LIMIT ?", "i", array($limit));
        }

        public function get($id)
        {
            return $this->select("SELECT * FROM books WHERE id = ?", "i", array($id));
        }

        public function add($book){
            return $this->execute("INSERT INTO books (name, description, price, authorName, authorEmail, status, type, bestselling, topmonthly, topyearly) 
                                    VALUES(?,?,?,?,?,?,?,?,?,?)", 
                                    "ssdsssiiii", array($book->name, $book->description, $book->price, $book->authorName, 
                                    $book->authorEmail, $book->status, $book->type, $book->bestselling, $book->topmonthly, $book->topyearly)) ;
        }

        public function edit($book){
            return $this->execute("UPDATE books SET name=?, description=?, price=?, authorName=?, authorEmail=?, status=?, type=?, bestselling=?, 
                                    topmonthly=?, topyearly=? WHERE id=?", 
                                    "ssdsssiiiii", array($book->name, $book->description, $book->price, $book->authorName, 
                                    $book->authorEmail, $book->status, $book->type, $book->bestselling, $book->topmonthly, $book->topyearly, $book->id)) ;
        }

        public function delete($id){
            return $this->execute("DELETE FROM books WHERE id = ?", "i", array($id)) ;
        }
    }
?>