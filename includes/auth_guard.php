<?php
/**
 * Authentication guard for admin pages
 */
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Not logged in, redirect to login page
    header('Location: /admin/login.php');
    exit;
}