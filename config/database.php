<?php
class Database {
    public static function connect() {
        return new PDO('mysql:host=localhost;dbname=crud_mvc', 'root', 'hafiz1180');
    }
}
