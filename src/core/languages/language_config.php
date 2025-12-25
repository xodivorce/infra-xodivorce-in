<?php
// Load all available languages from DB
$languages = [];
$sql = "SELECT name FROM languages ORDER BY id ASC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $languages[] = $row['name'];
    }
}

// Function to fetch translations for a given language
function getTranslations($conn, $langName)
{
    $translations = [];
    $sql = "SELECT t.`key`, t.value 
            FROM translations t
            JOIN languages l ON t.language_id = l.id
            WHERE l.name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $langName);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $translations[$row['key']] = $row['value'];
    }

    return $translations;
}

// Pick selected language (from session, fallback to first in DB, or default UK English)
$selected_language = $_SESSION['language'] ?? ($languages[0] ?? 'English (United Kingdom)');
$current_texts = getTranslations($conn, $selected_language);

// Helper for echoing translations safely
function t($key, $fallback = '')
{
    global $current_texts;
    return htmlspecialchars($current_texts[$key] ?? $fallback);
}
?>