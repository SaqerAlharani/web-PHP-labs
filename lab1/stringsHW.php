<?php
// =============================
// PHP STRING FUNCTIONS EXAMPLES
// صقر الحراني Lab1
// =============================

echo "PHP STRING FUNCTIONS EXAMPLES" . "<br>" . "صقر الحراني Lab1";
echo "<br><br>";

// 1. strlen()
// Description: Returns the length of a string.
echo "1. strlen() example:" . "<br>";
$sample_text = "PHP is Powerful";
echo "The text is: $sample_text<br>";
echo "Length: " . strlen($sample_text) . "<br>";
echo "<hr>";

// 2. strtoupper()
// Description: Converts all characters to uppercase.
echo "2. strtoupper() example:" . "<br>";
$target_str = "web development";
echo "//Before using strtoupper(): $target_str<br>";
echo "//After using strtoupper(): " . strtoupper($target_str) . "<br>";
echo "<hr>";

// 3. strtolower()
// Description: Converts all characters to lowercase.
echo "3. strtolower() example:" . "<br>";
$target_str2 = "LEARN PHP FAST";
echo "//Before using strtolower(): $target_str2<br>";
echo "//After using strtolower(): " . strtolower($target_str2) . "<br>";
echo "<hr>";

// 4. substr()
// Description: Returns part of a string.
echo "4. substr() example:" . "<br>";
$main_sentence = "Mastering PHP Programming";
echo "Original text: $main_sentence<br>";
echo "Substring (0,9): " . substr($main_sentence, 0, 9) . "<br>";
echo "<hr>";

// 5. str_replace()
// Description: Replaces all occurrences of a string with another string.
echo "5. str_replace() example:" . "<br>";
$input_phrase = "I love Python";
echo "Before replace: $input_phrase<br>";
echo "After replace (Python → PHP): " . str_replace("Python", "PHP", $input_phrase) . "<br>";
echo "<hr>";

// 6. strpos()
// Description: Finds the position of the first occurrence of a substring.
echo "6. strpos() example:" . "<br>";
$search_line = "Discover the world of PHP";
echo "Text: $search_line<br>";
echo "Position of 'PHP': " . strpos($search_line, "PHP") . "<br>";
echo "<hr>";

// 7. trim()
// Description: Removes spaces from the beginning and end of a string.
echo "7. trim() example:" . "<br>";
$padded_text = "   Hello World   ";
echo "Before trim: [$padded_text]<br>";
echo "After trim: [" . trim($padded_text) . "]<br>";
echo "<hr>";

// 8. explode()
// Description: Splits a string into an array.
echo "8. explode() example:" . "<br>";
$data_string = "One,Two,Three,Four";
echo "Original text: $data_string<br>";
$data_array = explode(",", $data_string);
echo "After explode():<br>";
print_r($data_array);
echo "<br>";
echo "<hr>";

// 9. implode()
// Description: Joins array elements into a string.
echo "9. implode() example:" . "<br>";
echo "Imploded with ' | ' : " . implode(" | ", $data_array) . "<br>";
echo "<hr>";

?>
