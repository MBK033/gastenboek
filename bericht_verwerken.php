<?php
session_start();

// Set the session duration for the cooldown period (3 hours)
$cooldownDuration = 3 * 60 * 60; // 3 hours in seconds

// Check if the session contains a timestamp indicating the last submission time
if (isset($_SESSION['last_submission_time'])) {
    // Check if the cooldown period has not passed since the last submission
    if (time() - $_SESSION['last_submission_time'] < $cooldownDuration) {
        // If the cooldown period has not passed, redirect to a cooldown page or display an error message
        echo "<script> window.location.href = 'cooldownRedirect.php'; </script>";
        exit;
    }
}

// If the cooldown period has passed or there was no previous submission, update the last submission time in the session
$_SESSION['last_submission_time'] = time();

function filter_curse_words($text) {
    // List of curse words to filter out
    $curse_words = ['hamlap'];

    // Check if any curse words are found in the text
    $has_curse_word = false;
    foreach ($curse_words as $word) {
        if (strpos($text, $word) !== false) {
            $has_curse_word = true;
            break;
        }
    }

    // If a curse word is found, replace the entire sentence with asterisks
    if ($has_curse_word) {
        return str_ireplace($curse_words, '****', $text);
    }

    // Replace curse words with the provided text
    $filtered_text = str_ireplace($curse_words, 'arne is gay', $text);

    return $filtered_text;
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_curse_words($_POST["naam"]);
    $name = htmlspecialchars(mb_substr($name, 0, 50));
    $message = filter_curse_words($_POST["bericht"]);
    $message = htmlspecialchars(mb_substr($message, 0, 255));
    $date_time = date("d-m-Y H:i"); // Server's date and time
    $image_name = ''; // Variable to store the image filename

    // Process the uploaded image
    if ($_FILES['afbeelding']['size'] > 0) {
        $uploadDir = 'uploads/';
        $image_name = $uploadDir . basename($_FILES['afbeelding']['name']);
        move_uploaded_file($_FILES['afbeelding']['tmp_name'], $image_name);
    }

    // Create an associative array with the message data
    $messageData = array(
        'naam' => $name,
        'datum_tijd' => $date_time,
        'bericht' => $message,
        'afbeelding' => $image_name
    );

    // Convert the array to JSON format with proper indentation
    $jsonMessage = json_encode($messageData, JSON_PRETTY_PRINT);

    // Add the JSON message to the JSON file
    $file = 'berichten.json';
    $content = file_get_contents($file);
    if ($content === false) {
        // If the file doesn't exist, create a new one
        file_put_contents($file, '[' . $jsonMessage . ']');
    } else {
        // If the file exists, append the new message to the array and save it
        $messages = json_decode($content, true);
        $messages[] = $messageData; // Add the new message to the array
        file_put_contents($file, json_encode($messages, JSON_PRETTY_PRINT));
    }

    // Redirect back to the guestbook
    header("Location: gastenboek.php");
    exit;
}
?>
