<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP</title>
</head>
<body>
   

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

$colors = ["Red", "Green", "Blue"];

foreach ($colors as $color) {
    echo $color . "<br>";
}

$array = ["Apple", "Banana"];
print_r($array);
echo $array[0];

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
?>
    
</body>
</html>