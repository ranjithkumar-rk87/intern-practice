<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP</title>
</head>
<body>

<?php
session_start();

$_SESSION['user'] = "tester";
?>
   
<h3>Get Method</h3>
<form method="get" action="">
    Name:
    <input type="text" name="name">
    <button type="submit">Submit</button>
</form>

<h3>post Method</h3>
<form method="post">
    Username: <input type="text" name="username">
    <button type="submit">Submit</button>
</form>


<form method="post" enctype="multipart/form-data">
    <input type="file" name="photo">
    <button type="submit">Upload</button>
</form>




<h4>user: <?php echo $_SESSION['user']; ?></h4>


<form method="post">
    Name: <input type="text" name="name" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button type="submit" name="register">Register</button>
</form>

<?php
include "db.php";

$stmt = $conn->prepare("SELECT id, username, email FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table cellpadding="10">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Action</th>
</tr>

<?php foreach ($users as $user): ?>
<tr>
    <td><?= $user['id'] ?></td>
    <td><?= $user['username'] ?></td>
    <td><?= $user['email'] ?></td>
    <td>
        <a href="edit.php?id=<?= $user['id'] ?>">Edit</a> |
        <a href="delete.php?id=<?= $user['id'] ?>">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>



<?php

echo "Hello world <br>";

$age=25;
echo "age : $age <br>";

$float=10.5;
echo $float."<br>";
var_dump($float);

$codeName="php";
echo "<br> $codeName <br>";

$greeting = "Hello";
echo "Message: $greeting  <br>";

$bool = true;
echo "$bool <br>";


$x = NULL;
var_dump($x);
echo gettype($codeName);

$y="10"+5;
echo "<br> $y <br>";


$a = 10;
$b = 3;

echo "addition ".$a + $b . "<br>";
echo " subtraction $a - $b . <br>";
echo " multiply $a * $b . <br>";
echo " division $a / $b . <br>";
echo "modulo divison $a % $b . <br>";
echo "Exponentiation $a ** $b . <br>";

$x = 10;

$x += 5;  echo $x . "<br>";
$x -= 2;  echo $x . "<br>";
$x *= 2;  echo $x . "<br>";
$x /= 2;  echo $x . "<br>";
$x %= 3;  echo $x . "<br>";

$a = 5;
$b = "5";

var_dump($a == $b);  echo "<br>";
var_dump($a === $b); echo "<br>";
var_dump($a != $b);  echo "<br>";
var_dump($a !== $b); echo "<br>";
var_dump($a > 3);    echo "<br>";
var_dump($a < 10);   echo "<br>";
var_dump($a <=> 5);  echo "<br>";

$x = 10;
$y = 5;

var_dump($x > 5 && $y < 10); echo "<br>";
var_dump($x > 5 || $y > 10); echo "<br>";
var_dump(!($x == 10));       echo "<br>";

$i = 5;

echo ++$i . "<br>";
echo $i++ . "<br>";
echo --$i . "<br>";
echo $i-- . "<br>";

$age = 20;

$result = ($age >= 18) ? "Adult" : "Minor";
echo $result . "<br>";

$first = "Hello";
$second = "PHP";

echo $first . " " . $second . "<br>";

$first .= " World";
echo $first . "<br>";

$username = $_GET['user'] ?? "Guest";
echo $username . "<br>";


$a = ["a" => "Apple"];
$b = ["b" => "Banana"];

print_r($a + $b); echo "<br>";

var_dump($a == $b);  echo "<br>";
var_dump($a === $b); echo "<br>";


$x = 6;
$y = 3;

echo ($x & $y) . "<br>";
echo ($x | $y) . "<br>";
echo ($x ^ $y) . "<br>"; 


$age = 18;

if ($age >= 18) {
    echo "You are eligible to vote <br>";
}else {
    echo "Minor";
}

$marks = 75;

if ($marks >= 90) {
    echo "Grade A";
} elseif ($marks >= 60) {
    echo "Grade B ";
} else {
    echo "Grade C";
}

echo "<br>";
$day = 3;

switch ($day) {
    case 1:
        echo "Monday";
        break;
    case 2:
        echo "Tuesday";
        break;
    case 3:
        echo "Wednesday";
        break;
    default:
        echo "Invalid day";
}
echo "<br>";
for ($i = 1; $i <= 5; $i++) {
    echo $i . "<br>";
}

$j = 1;

while ($j <= 5) {
    echo $j . "<br>";
    $j++;
}

$k = 1;

do {
    echo $k . "<br>";
    $k++;
} while ($k <= 5);

$colors = ["red", "green", "blue"];

foreach ($colors as $color) {
    echo $color . "<br>";
}

$array = ["Apple", "Banana"];
print_r($array);
echo $array[0];echo "<br>";

echo count($array);echo "<br>";
array_push($array,"Mango");
print_r($array);echo "<br>";
array_pop($array);

$array[]="Orange";
echo "<br>";
foreach($array as $arr) {
    echo $arr . "<br>";
}

$person = [
    "name" => "Ranjith",
    "age" => 25,
    "city" => "Rajapalayam"
];

echo $person["name"];
$person["age"] = 26;
echo "<br>";
foreach($person as $key => $value) {
    echo "$key : $value<br>";
}

$inventory = [
    [
        "id" => 101,
        "name" => "Laptop",
        "price" => 50000,
        "quantity" => 5
    ],
    [
        "id" => 102,
        "name" => "Smartphone",
        "price" => 20000,
        "quantity" => 10
    ]
];

echo $inventory[1]["name"];
echo "<br>";
foreach($inventory as $product) {
    echo "ID: " . $product["id"] . " | ";
    echo "Name: " . $product["name"] . " | ";
    echo "Price: ₹" . $product["price"] . " | ";
    echo "Quantity: " . $product["quantity"] . "<br>";
}

/* 18-12-2025 */

echo abs(-15);echo "<br>";
echo sqrt(16);echo "<br>";
echo pow(2, 3);echo "<br>";
echo round(3.6);echo "<br>";
echo ceil(4.2);echo "<br>";
echo floor(4.9);echo "<br>";
echo min(10, 5, 20);echo "<br>";
echo max(10, 5, 20);echo "<br>";
echo rand(1, 10);echo "<br>";
echo mt_rand(1, 10);echo "<br>";

var_dump(is_numeric(100));echo "<br>";
var_dump(is_int(10));echo "<br>";
var_dump(is_float(10.5)); echo "<br>";

echo pi(); echo "<br>";


echo strlen("Hello");echo "<br>";
echo strtoupper("php");echo "<br>";
echo strtolower("PHP");echo "<br>";
echo ucfirst("php");echo "<br>";
echo ucwords("hello php");echo "<br>";
echo strpos("Hello PHP", "PHP");echo "<br>";
echo str_replace("PHP", "World", "Hello PHP");echo "<br>";
echo substr("Hello PHP", 0, 5);echo "<br>";
echo strcmp("php", "php");echo "<br>";
echo strrev("Hello");echo "<br>";

$text = "  PHP  ";
echo trim($text);echo "<br>";

$data = "Apple,Banana,Orange";
print_r(explode(",", $data));echo "<br>";

$fruits = ["Apple","Banana","Orange"];
echo implode(", ", $fruits);echo "<br>";


define("WELCOME", "Hello world");
echo WELCOME . "\n";

function sayHello() {
    echo "Hello PHP <br>";
}

sayHello();

function add($a, $b) {
    return $a + $b;
}

$result = add(10, 20);
echo $result."<br>";

$add = fn($a, $b) => $a + $b;
echo $add(3, 4)."<br>";

$greet = function($name) {
    echo "Hello $name <br>";
};

$greet("PHP");


if (isset($_GET['name'])) {
    echo "<h3>Hello, " . $_GET['name'] . "</h3>";
}
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    echo "Entered Username: " . htmlspecialchars($username);
}

setcookie("user", "tester", time() + 3600);

echo $_COOKIE['user'];


if (isset($_FILES['photo'])) {
    $file = $_FILES['photo'];

    echo "File Name: " . $file['name'] . "<br>";
    echo "File Size: " . $file['size'] . "<br>";
    echo "File Type: " . $file['type'] . "<br>";
    move_uploaded_file($file['tmp_name'], "uploads/" . $file['name']);

}
echo "<br>";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST['username'])) {
        echo "Username is required";
    } else {
        echo "Username: " . $_POST['username'];
    }
}



class Person {
    public $name;

    public function sayHello() {
        echo "<br> Hello, I am $this->name <br>";
    }
}
$person = new Person();
$person->name = "tester";
$person->sayHello();


class Person1 {
    public $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function sayHello() {
        echo "Hello, I am $this->name <br>";
    }
}

$person = new Person1("tester");
$person->sayHello();

class Animal {
    public function sound() {
        echo "Animal sound";
    }
}

class Dog extends Animal {
    public function sound() {
        echo "Dog barks <br>";
    }
}

$dog = new Dog();
$dog->sound();

class User {
    public $name = "Public";
    protected $email = "Protected";
    private $password = "Private";

    public function showData() {
        echo $this->name . "<br>";
        echo $this->email . "<br>";
        echo $this->password . "<br>";
    }
}

$user = new User();
$user->showData();
echo $user->name;
//echo $user->email;
// echo $user->password;

// multi level
class GrandParent {
    public function gp() {
        echo "Grand Parent<br>";
    }
}

class ParentClass extends GrandParent {
    public function parent() {
        echo "Parent<br>";
    }
}

class ChildClass extends ParentClass {
    public function child() {
        echo "Child";
    }
}

$obj = new ChildClass();
$obj->gp();
$obj->parent();
$obj->child();



include "db.php";

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password)
            VALUES (:name, :email, :password)";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':password' => $password
    ]);

    echo "<br> Registration successful";
}



?>
    
</body>
</html>