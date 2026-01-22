<?php
// =============================
// PHP ARRAY FUNCTIONS EXAMPLES
// صقر الحراني Lab1
// =============================

echo "PHP ARRAY FUNCTIONS EXAMPLES" . "<br>" . "صقر الحراني Lab1";
echo "<br>";
echo "<br>";

// 1. count()
// Description: Returns the number of elements in an array.
echo "1. count() example:" . "<br>";
$values_set = [15, 25, 35, 45, 55];
echo "Total elements: " . count($values_set) . "<br>";
echo "<hr>";

// 2. array_push()
// Description: Adds elements to the end of an array.
echo "2. array_push() example:" . "<br>";
$user_list = ["Ahmed", "Sami"];
echo "//Before Using array_push() function :";
echo "<br>";
print_r($user_list);
echo "<br>";
array_push($user_list, "Saqer", "Khaled");
echo "//After Using array_push() function I Pushed Saqer And Khaled :";
echo "<br>";
print_r($user_list);
echo "<br>";
echo "<hr>";

// 3. array_pop()
// Description: Removes the last element from an array and returns it.
echo "3. array_pop() example:" . "<br>";
$fruit_collection = ["Orange", "Banana", "Grapes"];
$removed_item = array_pop($fruit_collection);
echo "Removed item:" . $removed_item . "<br>";
print_r($fruit_collection);
echo "<br>";
echo "<hr>";


// 4. array_merge()
// Description: Merges two or more arrays.
echo "4. array_merge() example:" . "<br>";
$list_one = [10, 20];
$list_two = [30, 40];
$merged_result = array_merge($list_one, $list_two);
print_r($merged_result);
echo "<br>";
echo "<hr>";

// 5. in_array()
// Description: Checks if a value exists in an array.
echo "5. in_array() example:" . "<br>";
$inventory = ["Laptop", "Mouse", "Keyboard"];
if (in_array("Mouse", $inventory)) {
    echo "Mouse exists in the array" . "<br>";
}
echo "<br>";
echo "<hr>";

// 6. array_reverse()
// Description: Returns an array with elements in reverse order.
echo "6. array_reverse() example:" . "<br>";
$reversed_set = array_reverse($values_set);
print_r($reversed_set);
echo "<br>";
echo "<hr>";

// 7. array_search()
// Description: Searches the array for a value and returns its key.
echo "7. array_search() example:" . "<br>";
$found_index = array_search(35, $values_set);
echo "Value 35 found at index: $found_index" . "<br>";
echo "<hr>";

// 8. sort()
// Description: Sorts an array in ascending order.
echo "8. sort() example:" . "<br>";
$data_points = [45, 12, 89, 34];
sort($data_points);
print_r($data_points);
echo "<br>";
echo "<hr>";

?>
