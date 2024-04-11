<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gastenboek</title>
    <!-- Voeg hier CSS-links toe voor styling -->
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <script defer src="app.js"></script>
</head>

<body>
    <div class="circle"></div> 
    <div class="circle2"></div>
    <div class="formulier">
        <h1>Gastenboek</h1>
        <!-- Formulier voor het toevoegen van een nieuw bericht -->
        <form action="bericht_verwerken.php" method="post" enctype="multipart/form-data">
            <label for="naam">Naam:</label><br>
            <input type="text" id="naam" name="naam" required><br>
            <label for="bericht">Bericht:</label><br>
            <textarea id="bericht" name="bericht" rows="4" required></textarea><br>
            <label for="afbeelding">Afbeelding:</label><br>
            <div class="custom-file-input">
            <input type="file" id="afbeelding" name="afbeelding" accept="image/*">
            <label for="afbeelding" name="image">Choose file </label>
            </div><br>
            <button class="verzendButton" type="submit">Plaats bericht</button>
        </form>
    </div>

    <!-- Weergeven van geplaatste berichten -->
    <div class="message-container">
        <?php
        // Laden van de berichten uit het JSON-bestand
        $inhoud = file_get_contents("berichten.json");
        $berichten = json_decode($inhoud, true);

        // Loop door elk bericht en toon deze op het scherm
        foreach ($berichten as $bericht) {
            // HTML voor het weergeven van het bericht
            echo '<div class="bericht">';
            echo "<p><strong>Naam:</strong> " . $bericht['naam'] . "</p>";
            echo "<p><strong>Datum en tijd:</strong> " . $bericht['datum_tijd'] . "</p>";
            echo "<p><strong>Bericht:</strong> " . $bericht['bericht'] . "</p>";
            // Afbeelding weergeven als deze beschikbaar is
            if (!empty ($bericht['afbeelding'])) {
                echo "<img src='{$bericht['afbeelding']}' alt='Afbeelding bij het bericht' style='max-width: 100%; max-height: 50vh;'>";

            }
            echo "</div>";
        }
//         // Check if the cookie for the message exists
// if (isset($_COOKIE['message_submitted']) && $_COOKIE['message_submitted'] === 'true') {
//     echo "You have already submitted a message.";
//     // You may choose to redirect them elsewhere or display a message
    
//     // Adding console log
//     echo "<script>console.log('Cookie already set');</script>";
    
//     exit;
// }

// // If not submitted, allow the user to submit the message
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the cookie for message submission exists
    if (isset($_COOKIE['message_submitted'])) {
        // If the cookie exists, the user has already submitted a message
        echo  "alert('You have already submitted a message.')";
        exit;
    }}

        ?>
    </div>
</body>

</html>