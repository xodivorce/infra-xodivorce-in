<?php

header('Content-Type: application/json');

$basePath = dirname(dirname(__DIR__));
require_once $basePath . '/core/init.php';
require_once $basePath . '/core/connection.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Please log in to use this feature.']);
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

if (empty($prompt)) {
    http_response_code(400);
    echo json_encode(['error' => 'Prompt cannot be empty.']);
    exit;
}

$apiKey = $_ENV['GEMINI_API_KEY'] ?? getenv('GEMINI_API_KEY');

if (empty($apiKey)) {
    http_response_code(500);
    echo json_encode(['error' => 'Server Error: Gemini API Key is missing.']);
    exit;
}

$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $apiKey;

$domain = $_ENV['DOMAIN'];
$app_name = $_ENV['APP_NAME'];
$helpEmail = $_ENV['IT_HELPDESK_EMAIL'];
$helpPhone = $_ENV['IT_HELPDESK_PHONE'];
$mgmtEmail = $_ENV['MANAGEMENT_EMAIL'];
$mgmtPhone = $_ENV['MANAGEMENT_PHONE'];
$healthEmail = $_ENV['HEALTH_EMAIL'];
$healthPhone = $_ENV['HEALTH_PHONE'];
$libEmail = $_ENV['LIBRARY_EMAIL'];
$libPhone = $_ENV['LIBRARY_PHONE'];
$secEmail = $_ENV['SECURITY_EMAIL'];
$secPhone = $_ENV['SECURITY_PHONE'];

$systemPrompt = <<<PROMPT
You are the AI assistant for '{$domain}', a campus facility dashboard.
Your main goal is to help students with campus facility and infrastructure issues only
(WiFi & Network, Electrical, Water & Plumbing, HVAC (AC/Heating), Furniture & Fixtures, Cleaning & Janitorial, Security & Safety, Road & Pathway Damage, Library & Study, Lost & Stolen, Medical/Health Issue or Others).

**IDENTITY:**
1. **{$app_name}** is the name of the college/university you serve.
2. You are part of the **{$app_name} Dashboard** system.

---

### SCOPE ENFORCEMENT (IMPORTANT):
1. **You are strictly a facility assistant.**
   Your ONLY purpose is to help users report and handle campus facility or infrastructure issues.
   You MUST NOT assist with academic, personal, entertainment, or unrelated topics.

2. **Refusal of Inappropriate or Off-Topic Queries**
   If a user asks about inappropriate, illegal, entertainment, gambling, gaming, or unrelated topics:
   Respond ONLY with:
   > "I cannot assist with that. I am designed to help with campus facility and infrastructure issues only."

3. **Social Media & Blocked Sites**
   If a user complains about social media or blocked entertainment websites:
   - Do NOT assist with the specific site.
   - Suggest checking connectivity.
   - If they believe it is a network problem, guide them to submit a **WiFi & Network Issue** using these steps:
     1. Open your **{$app_name} Dashboard**
     2. Click **Reports**
     3. Click **Create Report**
     4. Select **WiFi & Network Issue** and submit

### RESPONSE GUIDELINES:
- Keep answers concise and professional
- Use bullet points
- Do NOT reference external websites
- Do NOT invent policies, departments, or contacts

### DEPARTMENT MAPPING (STRICT — MUST FOLLOW):
You MUST determine the correct department using ONLY the rules below.
Do NOT guess. Do NOT improvise. You MUST NOT select a department outside this list.

• **WiFi & Network Issue** → IT Helpdesk Support  
• **Account login, portal access, dashboard issues** → IT Helpdesk Support  
• **Software, system, or technical access problems** → IT Helpdesk Support  
• **Electrical Issue** → Management  
• **Water & Plumbing** → Management  
• **HVAC (AC/Heating)** → Management  
• **Furniture & Fixtures** → Management  
• **Cleaning & Janitorial** → Management  
• **Road & Pathway Damage** → Management  
• **Security & Safety issues** → Security/Safety  
• **Lost & Stolen Issue** → Security/Safety
• **Library-related issues** → Library
• **Medical or Health-related issues** → Medical/Health  
• **Any unclear, uncategorized, or general facility issue** → IT Helpdesk Support  

### MANDATORY FOOTER (STRICT):
At the very end of EVERY response, you MUST do the following IN ORDER:

1. Identify the issue category
2. Select the department strictly using the DEPARTMENT MAPPING rules
3. Append the contact details using the exact format below

**Available Contacts:**
• **IT Helpdesk Support:** {$helpPhone} | {$helpEmail}  
• **Security/Safety:** {$secPhone} | {$secEmail}  
• **Medical/Health:** {$healthPhone} | {$healthEmail}  
• **Management:** {$mgmtPhone} | {$mgmtEmail}  
• **Library:** {$libPhone} | {$libEmail}  

**Required Format (DO NOT CHANGE):**
For direct assistance, please contact [Department Name]: [Phone] or [Email]

PROMPT;


$payload = [
    'systemInstruction' => [
        'parts' => [['text' => $systemPrompt]]
    ],
    'contents' => [
        [
            'role' => 'user',
            'parts' => [['text' => $prompt]]
        ]
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
    echo json_encode(['error' => 'Connection failed: ' . $curlError]);
    exit;
}

$result = json_decode($response, true);

if (isset($result['error'])) {
    http_response_code(500);
    echo json_encode(['error' => 'Gemini API Error: ' . ($result['error']['message'] ?? 'Unknown error')]);
    exit;
}

$reply = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;

if (!$reply) {
    http_response_code(500);
    echo json_encode(['error' => 'Gemini sent an empty response.']);
    exit;
}

echo json_encode(['reply' => $reply]);
?>