<?php
header('Content-Type: application/json');

$basePath = dirname(dirname(__DIR__));
require_once $basePath . '/core/init.php';
require_once $basePath . '/core/connection.php';

if (session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    http_response_code(403);
    echo json_encode(['error' => 'Admin access only']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
$prompt = trim($data['prompt'] ?? '');

if ($prompt === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Prompt required']);
    exit;
}

$apiKey = $_ENV['GEMINI_API_KEY'] ?? getenv('GEMINI_API_KEY');
if (!$apiKey) {
    http_response_code(500);
    echo json_encode(['error' => 'Gemini API key missing']);
    exit;
}

/*
  System prompt: strict admin role. Instruct model to output:
  1) Plain readable analysis
  2) A JSON block STRICTLY wrapped between ###JSON_START### and ###JSON_END###
     with a defined schema so server can parse reliably.
  3) A YouTube search query + suggested video title.
  4) The mandatory footer contact lines.
*/
$domain    = $_ENV['DOMAIN']    ?? 'YourCampus';
$app_name  = $_ENV['APP_NAME']  ?? 'Campus Dashboard';
$helpEmail = $_ENV['IT_HELPDESK_EMAIL'] ?? 'it@example.com';
$helpPhone = $_ENV['IT_HELPDESK_PHONE'] ?? '+000';
$secEmail  = $_ENV['SECURITY_EMAIL'] ?? 'security@example.com';
$secPhone  = $_ENV['SECURITY_PHONE'] ?? '+000';
$healthEmail = $_ENV['HEALTH_EMAIL'] ?? 'health@example.com';
$healthPhone = $_ENV['HEALTH_PHONE'] ?? '+000';
$mgmtEmail = $_ENV['MANAGEMENT_EMAIL'] ?? 'mgmt@example.com';
$mgmtPhone = $_ENV['MANAGEMENT_PHONE'] ?? '+000';
$libEmail = $_ENV['LIBRARY_EMAIL'] ?? 'library@example.com';
$libPhone = $_ENV['LIBRARY_PHONE'] ?? '+000';


$systemPrompt = <<<PROMPT
You are the AI assistant for '{$domain}', a campus facility Admin dashboard.
Your main goal is to help Admins with campus facility and infrastructure issues only
(WiFi & Network, Electrical, Water & Plumbing, HVAC (AC/Heating), Furniture & Fixtures, Cleaning & Janitorial, Security & Safety, Road & Pathway Damage, Library & Study, Lost & Stolen, Medical/Health Issue or Others).

**IDENTITY:**
1. **{$app_name}** is the name of the college/university you serve.
2. You are part of the **{$app_name} Admin Dashboard** system.

---

### SCOPE ENFORCEMENT (IMPORTANT):
1. **You are strictly a facility Admin assistant.**
   Your ONLY purpose is to help Admins report and suggest about handling campus facility or infrastructure issues.
   You MUST NOT assist with academic, personal, entertainment, or unrelated topics.

2. **Refusal of Inappropriate or Off-Topic Queries**
   If a user asks about inappropriate, illegal, entertainment, gambling, gaming, or unrelated topics:
   Respond ONLY with:
   > "I cannot assist with that. I am designed to help with campus facility and infrastructure issues only."

---
### RESPONSE GUIDELINES:
- Keep answers concise and professional
- Use bullet points
- Do NOT reference external websites, except youtube.com for video suggestions.
- Always provide a YouTube search query and suggested video title for further learning.
- Do NOT invent policies, departments, or contacts

### MANDATORY FOOTER (STRICT):
At the very end of EVERY response, you MUST do the following IN ORDER:

1. Identify the issue category
2. Provide a Suggested YouTube Search Query as <how-to style query>. Do NOT fabricate direct links.
PROMPT;

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";

$payload = [
    'systemInstruction' => [
        'parts' => [['text' => $systemPrompt]]
    ],
    'contents' => [
        [
            'role' => 'user',
            'parts' => [['text' => $prompt]]
        ]
    ],
    'generationConfig' => [
        'temperature' => 0.25,
        'maxOutputTokens' => 700
    ]
];

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS => json_encode($payload),
    CURLOPT_TIMEOUT => 30
]);

$response = curl_exec($ch);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    http_response_code(500);
    echo json_encode(['error' => 'Connection failed', 'details' => $curlError]);
    exit;
}

$result = json_decode($response, true);
if ($result === null) {
    // invalid JSON from API
    http_response_code(500);
    echo json_encode(['error' => 'Invalid API response', 'raw' => $response]);
    exit;
}

if (isset($result['error'])) {
    http_response_code($result['error']['code'] ?? 500);
    echo json_encode([
        'error' => $result['error'],
        'raw_response' => $result
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}


/* Merge all text parts reliably */
$fullText = '';
if (!empty($result['candidates'])) {
    foreach ($result['candidates'] as $cand) {
        if (!empty($cand['content']['parts'])) {
            foreach ($cand['content']['parts'] as $part) {
                if (!empty($part['text'])) $fullText .= $part['text'] . "\n";
            }
        }
    }
}
$fullText = trim($fullText);

if ($fullText === '') {
    http_response_code(500);
    echo json_encode(['error' => 'Gemini returned empty response', 'debug' => $result]);
    exit;
}

/* Try to extract the structured JSON between markers ###JSON_START### ... ###JSON_END### */
$structured = null;
$jsonStart = strpos($fullText, '###JSON_START###');
$jsonEnd   = strpos($fullText, '###JSON_END###');

if ($jsonStart !== false && $jsonEnd !== false && $jsonEnd > $jsonStart) {
    $jsonBlock = substr($fullText, $jsonStart + strlen('###JSON_START###'), $jsonEnd - ($jsonStart + strlen('###JSON_START###')));
    $jsonBlock = trim($jsonBlock);

    // try to json_decode; if fails, attempt to clean common markdown fences
    $decoded = json_decode($jsonBlock, true);
    if ($decoded === null) {
        // remove triple backticks if present
        $jsonBlockClean = preg_replace('/^```json\s*/i', '', $jsonBlock);
        $jsonBlockClean = preg_replace('/```$/', '', $jsonBlockClean);
        $jsonBlockClean = trim($jsonBlockClean);
        $decoded = json_decode($jsonBlockClean, true);
    }

    if ($decoded !== null) {
        $structured = $decoded;
    } else {
        // keep raw block as fallback
        $structured = ['raw_json_block' => $jsonBlock];
    }
}

/* Build final response */
$responsePayload = [
    'reply' => $fullText,
    'structured' => $structured,
    'debug' => null
];

echo json_encode($responsePayload, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
