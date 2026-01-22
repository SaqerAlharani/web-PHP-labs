<?php
/*
========================================
PHP Functions & OOP Demonstration
Student Name: صقر الحراني
========================================
*/

/* ---------- 1. Basic Functions ---------- */

function greetUser() {
    echo "Hello! This is a custom greeting for PHP functions.<br>";
}

greetUser();
greetUser();


/* ---------- 2. Functions with Parameters ---------- */

function welcomeGuest($guestName) {
    echo "Welcome, $guestName! Have a great day.<br>";
}

welcomeGuest("Khalid");
welcomeGuest("Maya");
welcomeGuest("Omar");


/* ---------- 3. Functions with Return Values ---------- */

function getStaticSum() {
    return 15 + 35;
}

$total = getStaticSum();
echo "Static Sum Result = $total<br>";


function calculateTotal($val1, $val2) {
    return $val1 + $val2;
}

echo "Calculation Result = " . calculateTotal(12, 18) . "<br>";


/* ---------- 4. Multiple Parameters ---------- */

function displayProfile($username, $userAge) {
    return "Profile Name: $username | User Age: $userAge<br>";
}

echo displayProfile("Saqer", 25);
echo displayProfile("Fatima", 21);


/* ---------- 5. Variable Scope ---------- */

function localScopeDemo() {
    $value = 100; // local variable
    echo "Inside function, value = $value<br>";
}

localScopeDemo();


$main_val = 50;

function globalScopeDemo() {
    global $main_val;
    echo "Global access, value = $main_val<br>";
}

globalScopeDemo();


$app_id = 999;

function globalsAccess() {
    echo "Accessing via GLOBALS, app_id = " . $GLOBALS['app_id'] . "<br>";
}

globalsAccess();


/* ---------- 6. Variable-Length Arguments ---------- */

function processAll(...$items) {
    $sum = 0;
    foreach ($items as $val) {
        $sum += $val;
    }
    return $sum;
}

echo "Total Sum of Arguments = " . processAll(10, 20, 30, 40) . "<br>";


/* ---------- 7. Anonymous Functions ---------- */

$notify = function () {
    echo "Message from an anonymous function closure!<br>";
};

$notify();


$context = "Execution Context";

$printContext = function () use ($context) {
    echo "Current context: " . $context . "<br>";
};

$printContext();


/* ---------- 8. Callback Function ---------- */

function executeTask($taskCallback) {
    echo "Executing task...<br>";
    $taskCallback();
}

executeTask(function () {
    echo "Task callback completed successfully!<br>";
});


/* ---------- 9. Anonymous Function with Array ---------- */

$members = ["Sami", "Waleed", "Huda", "Rami", "Zaid"];

$shortNames = array_filter($members, function ($name) {
    return strlen($name) <= 4;
});

echo "Short Character Names:<br>";
print_r($shortNames);
echo "<br>";


/* ---------- 10. Recursion ---------- */

function findFactorial($number) {
    if ($number <= 1) {
        return 1;
    }
    return $number * findFactorial($number - 1);
}

echo "Factorial of 4 = " . findFactorial(4) . "<br>";


/* ---------- 11. Higher-Order Functions ---------- */

function scalarMultiplier($factor) {
    return function ($input) use ($factor) {
        return $input * $factor;
    };
}

$quadruple = scalarMultiplier(4);
echo "Quadruple of 5 = " . $quadruple(5) . "<br>";

$half = scalarMultiplier(0.5);
echo "Half of 20 = " . $half(20) . "<br>";


/* ---------- 12. Nested Closures ---------- */

function compute($x) {
    return function ($y) use ($x) {
        return function ($z) use ($x, $y) {
            return ($x + $y) * $z;
        };
    };
}

echo "Nested Computation Result = " . compute(2)(3)(5) . "<br>";


/* ---------- 13. Object-Oriented Programming ---------- */

class MemberAccount {
    public function introduce() {
        echo "Greetings, I am a system member!<br>";
    }
}

$member = new MemberAccount();
$member->introduce();


class SimpleCalc {

    public function addition($x, $y) {
        return $x + $y;
    }

    public function product($x, $y) {
        return $x * $y;
    }
}

$objCalc = new SimpleCalc();
echo "Addition Result = " . $objCalc->addition(25, 75) . "<br>";
echo "Product Result = " . $objCalc->product(6, 7) . "<br>";


class AccountOwner {
    private $ownerName;

    public function setOwner($name) {
        $this->ownerName = $name;
    }

    public function getOwner() {
        return $this->ownerName;
    }
}

$owner = new AccountOwner();
$owner->setOwner("صقر الحراني");

echo "Owner Identity = " . $owner->getOwner() . "<br>";


/* ---------- End of File ---------- */
?>
