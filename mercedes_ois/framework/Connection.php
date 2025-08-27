<?php
class Connection {
    public $host;
    public $user;
    public $pass;

    public function __construct($host = "localhost", $user = "root", $pass = "") {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
    }
}