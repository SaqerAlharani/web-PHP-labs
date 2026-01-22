<?php
/*
====================================================
Lab 6: OOP E-commerce System
Student Name: صقر الحراني
====================================================
*/

/**
 * Class Product
 * Represents a store product with name, price, and stock levels.
 */
class Product {
    private $name;
    private $price;
    private $stock;
    private $discount = 0;

    public function __construct($name, $price, $stock) {
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setDiscount($percentage) {
        if ($percentage >= 0 && $percentage <= 100) {
            $this->discount = $percentage;
        }
    }

    public function getDiscountedPrice() {
        return $this->price - ($this->price * ($this->discount / 100));
    }

    public function getStock() {
        return $this->stock;
    }

    public function reduceStock($quantity) {
        if ($quantity <= $this->stock) {
            $this->stock -= $quantity;
            return true;
        }
        return false;
    }
}

/**
 * Class Customer
 * Represents a customer with registration details.
 */
class Customer {
    private $name;
    private $email;
    private $registrationDate;

    public function __construct($name, $email, $registrationDate) {
        $this->name = $name;
        $this->email = $email;
        $this->registrationDate = new DateTime($registrationDate);
    }

    public function getName() {
        return $this->name;
    }

    public function getMembershipAge() {
        $now = new DateTime();
        $interval = $this->registrationDate->diff($now);
        return $interval->format('%y years, %m months, %d days');
    }
}

/**
 * Class Order
 * Manages order details and items.
 */
class Order {
    private $orderNumber;
    private $date;
    private $status;
    private $items = [];

    public function __construct($orderNumber, $status = 'Pending') {
        $this->orderNumber = $orderNumber;
        $this->date = date("Y-m-d H:i:s");
        $this->status = $status;
    }

    public function addProduct(Product $product, $quantity) {
        if ($product->reduceStock($quantity)) {
            $this->items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'price' => $product->getDiscountedPrice()
            ];
            return true;
        }
        return false;
    }

    public function calculateTotal() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function displayOrderSummary() {
        echo "<h3>Order Summary (#{$this->orderNumber})</h3>";
        echo "Date: {$this->date}<br>";
        echo "Status: {$this->status}<br>";
        echo "<h4>Items:</h4><ul>";
        foreach ($this->items as $item) {
            echo "<li>" . $item['product']->getName() . " | Qty: " . $item['quantity'] . " | Price: " . number_format($item['price'], 2) . "$</li>";
        }
        echo "</ul>";
        echo "<strong>Total Amount: " . number_format($this->calculateTotal(), 2) . "$</strong><br><hr>";
    }
}

/* ================================================
   DEMONSTRATION
================================================ */

echo "<h2>E-commerce System Demonstration - صقر الحراني</h2>";

// 1. Create Products
$laptop = new Product("High-End Laptop", 1200.00, 10);
$mouse = new Product("Wireless Mouse", 25.50, 50);
$keyboard = new Product("Mechanical Keyboard", 85.00, 20);

// Apply Discount to Laptop
$laptop->setDiscount(10); // 10% OFF

// 2. Create Customer
$customer = new Customer("Saqer Al-Harani", "saqer@example.com", "2024-05-10");

echo "Customer: " . $customer->getName() . "<br>";
echo "Membership Age: " . $customer->getMembershipAge() . "<br><hr>";

// 3. Create Order
$order1 = new Order("ORD-1001");
$order1->addProduct($laptop, 1);
$order1->addProduct($mouse, 2);

// Display Summary
$order1->displayOrderSummary();

// 4. Check Stock After Order
echo "<h4>Stock Status:</h4>";
echo $laptop->getName() . " Remaining Stock: " . $laptop->getStock() . "<br>";
echo $mouse->getName() . " Remaining Stock: " . $mouse->getStock() . "<br>";

?>
