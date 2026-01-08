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
    'system-logs' => [
        'role'  => 'admin',
        'label' => 'System Logs',
        'icon'  => 'clock',
        'file'  => './assets/admin/_system_logs.php',
        'nav'   => true,
    ],
    'admin-panel' => [
        'role'  => 'admin',
        'label' => 'Admin Panel',
        'icon'  => 'settings',
        'file'  => './assets/admin/_admin_panel.php',
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