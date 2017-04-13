<?php
//
// Chapter 12, pg. 316-317
//
require_once "DB.inc";
class User {
  public $userid;
  public $username;
  public $firstname;
  public $lastname;
  public $salutation;
  public $countryname;

  public function __construct($userid = false)
  {
    $dbh = new DB_Mysql_Test;
    $query = "SELECT * FROM users u, countries c
              WHERE userid = :1
              AND u.countrycode = c.countrycode";
    $data = $dbh->prepare($query)->execute($userid)->fetch_assoc();
    if(!$data) {
      throw new Exception("userid does nto exist");
    }
    $this->userid = $userid;
    $this->username = $data['username'];
    $this->firstname = $data['firstname'];
    $this->lastname = $data['lastname'];
    $this->salutation = $data['salutation'];
    $this->countryname = $data['name'];
  }

  public static function findByUsername($username)
  {
    $dbh = new DB_Mysql_Test;
    $query = "SELECT userID FROM users u WHERE uname = :1";
    list($userid) = $dbh->prepare($query)->execute($username)->fetch_row();
    if(!$userid) {
      throw new Exception("username does nto exist");
    }
    return new User($userid);
  }

  public function insert()
  {
    if($this->userid) {
      throw new Exception("User object has a userid, can't insert");
    }
    $dbh = new DB_Mysql_Test;
    $cc_query = "SELECT countrycode FROM countries WHERE name = :1";
    list($countrycode) = 
      $dbh->prepare($cc_query)->execute($this->countryname)->fetch_row();
    if(!$countrycode) {
      throw new Exception("Invalid country speicified");
    }
    $query = "INSERT INTO users
                (username, firstname, lastname, salutation, countrycode)
                VALUES(:1, :2, :3, :4, :5)";
    $dbh->prepare($query)->execute($this->username, $this->firstname,
                                   $this->lastname, $this->salutation,
                                   $countrycode);
    list($this->userid) =
      $dbh->prepare("select last_insert_id()")->execute()->fetch_row();
  }

  public function update(){
    if(!$this->userid) {
      throw new Exception("User needs userid to call update()");
    }
    $dbh = new DB_Mysql_Test;
    $cc_query = "SELECT countrycode FROM countries WHERE name = :1";
    list($countrycode) = 
      $dbh->prepare($cc_query)->execute($this->countryname)->fetch_row();
    if(!$countrycode) {
      throw new Exception("Invalid country speicified");
    }
    $query = "UPDATE users
              SET username = :1, firstname = :2, lastname = :3,
                  salutation = :4, countrycode = :5
              WHERE userid = :6";
    $dbh->prepare($query)->execute($this->username, $this->firstname,
                                   $this->lastname, $this->salutation,
                                   $countrycode, $this->userid);
  }
  public function delete()
  {
    if(!$this->userid) {
      throw new Exception("User object has no userid");
    }
    $query = "DELETE FROM users WHERE userid = :1";
    $dbh = new DB_Mysql_Test;
    $dbh->prepare($query)->execute($this->userid);
  }
}

$user = User::findByUsername('elen');
print_r($user);
$user->countryname = 'Canada';
try {
$user->update();
}
catch(Exception $e) {
  print_r($e);
}
?>
