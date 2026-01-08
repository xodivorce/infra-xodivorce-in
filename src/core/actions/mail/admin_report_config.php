<?php
function sendReportStatusEmail($conn, $report_id, $new_status) {
    // Fetch user email and report details
    $stmt = $conn->prepare("
        SELECT r.title, u.email, u.username 
        FROM reports r 
        JOIN users u ON r.user_id = u.id 
        WHERE r.id = ?
    ");
    $stmt->bind_param("i", $report_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return false;
    }

    $data = $result->fetch_assoc();
    $to = $data['email'];
    $username = htmlspecialchars($data['username']);
    $title = htmlspecialchars($data['title']);

    // Configuration
    $from_email = "no-reply@yourcampus.com"; // CHANGE THIS
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: <" . $from_email . ">" . "\r\n";

    $subject = "";
    $body_content = "";
    $color_code = "";

    if ($new_status === 'In Progress') {
        $subject = "Update: Report #$report_id is In Progress";
        $color_code = "#eab308"; // Yellow/Orange
        $body_content = "Good news! Your report regarding <strong>'$title'</strong> has been reviewed and our team is currently working on it.";
    } elseif ($new_status === 'Resolved') {
        $subject = "Resolved: Report #$report_id has been fixed";
        $color_code = "#22c55e"; // Green
        $body_content = "Great news! The issue <strong>'$title'</strong> has been successfully resolved. Thank you for helping improve our campus.";
    } else {
        return false; 
    }

    // HTML Email Template
    $message = "
    <html>
    <head>
        <style>
            .container { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
            .header { background-color: $color_code; color: white; padding: 10px 20px; border-radius: 6px 6px 0 0; }
            .content { padding: 20px; color: #333; line-height: 1.6; }
            .footer { margin-top: 20px; font-size: 12px; color: #777; border-top: 1px solid #eee; padding-top: 10px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>Status Update</h2>
            </div>
            <div class='content'>
                <p>Hello $username,</p>
                <p>$body_content</p>
                <p><strong>Current Status:</strong> <span style='color: $color_code; font-weight: bold;'>$new_status</span></p>
            </div>
            <div class='footer'>
                <p>This is an automated message. Please do not reply directly to this email.</p>
            </div>
        </div>
    </body>
    </html>
    ";

    // Send Mail
    return mail($to, $subject, $message, $headers);
}
?>