<?php

if (!isset($_SESSION['user_id'])) {
    header('Location: ./pages/sign_in_email.php');
    exit;
}

$is_admin = $_SESSION['is_admin'] ?? false;
$page = $_GET['page'] ?? 'overview';

$routes = [
    'overview' => [
        'role'  => 'user',
        'label' => 'Overview',
        'icon'  => 'home',
        'file'  => './assets/users/_overview.php',
        'nav'   => true,
    ],
    'reports' => [
        'role'  => 'user',
        'label' => 'Reports',
        'icon'  => 'file-text',
        'file'  => './assets/users/_reports.php',
        'nav'   => true,
    ],
    'admin_overview' => [
        'role'  => 'admin',
        'label' => 'Admin Overview',
        'icon'  => 'activity',
        'file'  => './assets/admin/_admin_overview.php',
        'nav'   => true,
    ],
    'activity-logs' => [
        'role'  => 'admin',
        'label' => 'Activity Logs',
        'icon'  => 'clock',
        'file'  => './assets/admin/_activity_logs.php',
        'nav'   => true,
    ],
    'admin' => [
        'role'  => 'admin',
        'label' => 'Admin',
        'icon'  => 'settings',
        'file'  => './assets/admin/_admin.php',
        'nav'   => true,
    ],
];

if (!isset($routes[$page])) {
    $page = $is_admin ? 'admin_overview' : 'overview';
}

$routeRole = $routes[$page]['role'];

if (
    ($routeRole === 'admin' && !$is_admin) ||
    ($routeRole === 'user' && $is_admin)
) {
    $page = $is_admin ? 'admin_overview' : 'overview';
}

$current_route = $routes[$page];
?>