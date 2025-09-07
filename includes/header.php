<?php
// Header include for Sun Services Inc website
// This file defines the opening HTML structure and reusable site-wide header

// Use default meta values if none provided by page
if (!isset($page_meta) || !is_array($page_meta)) {
    $page_meta = [];
}
$defaults = [
    'title' => 'Sun Services Inc — Quality Home & Business Services in India',
    'description' => 'Sun Services Inc provides comprehensive home and business services across India including flooring, blinds, curtains, cleaning, maintenance and more.',
    'keywords' => 'home services, business services, cleaning, flooring, blinds, curtains, maintenance, India',
    'canonical' => ''
];
$page_meta = array_merge($defaults, $page_meta);

// Ensure the correct timezone is set for all date operations
date_default_timezone_set('Asia/Kolkata');

// Basic HTML document structure
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($page_meta['title']); ?></title>
    <meta name="description" content="<?= htmlspecialchars($page_meta['description']); ?>" />
    <meta name="keywords" content="<?= htmlspecialchars($page_meta['keywords']); ?>" />
    <?php if (!empty($page_meta['canonical'])): ?>
    <link rel="canonical" href="<?= htmlspecialchars($page_meta['canonical']); ?>" />
    <?php endif; ?>
    <!-- OpenGraph/Twitter meta tags -->
    <meta property="og:title" content="<?= htmlspecialchars($page_meta['title']); ?>" />
    <meta property="og:description" content="<?= htmlspecialchars($page_meta['description']); ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />
    <meta property="og:image" content="/assets/images/og-default.jpg" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?= htmlspecialchars($page_meta['title']); ?>" />
    <meta name="twitter:description" content="<?= htmlspecialchars($page_meta['description']); ?>" />
    <meta name="twitter:image" content="/assets/images/og-default.jpg" />
    <link rel="stylesheet" href="/assets/css/site.css" />
    <script defer src="/assets/js/site.js"></script>
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="logo">
                <a href="/">
                    <img src="/assets/images/logo.png" alt="Sun Services Inc logo" />
                </a>
            </div>
            <div class="header-cta">
                <button class="btn-primary open-enquiry" data-service="General Enquiry">Enquire Now</button>
            </div>
            <nav class="main-nav" aria-label="Main navigation">
                <button class="nav-toggle" aria-label="Toggle navigation" aria-expanded="false"><span class="hamburger" aria-hidden="true"></span></button>
                <ul class="nav-list">
                    <li><a href="/">Home</a></li>
                    <li><a href="/services/">Services</a></li>
                    <li><a href="/use-cases/">Use Cases</a></li>
                    <li><a href="/b2b/">B2B</a></li>
                    <li><a href="/locations/">Locations</a></li>
                    <li><a href="/pricing/">Pricing</a></li>
                    <li><a href="/blog/">Blog</a></li>
                    <li><a href="/about/">About Us</a></li>
                    <li><a href="/contact/">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <!-- Overlay for enquiry lightbox -->
    <div id="lightbox-overlay" class="lightbox-overlay" hidden aria-hidden="true">
        <div class="lightbox-content" role="dialog" aria-modal="true" aria-labelledby="enquiryTitle">
            <button class="lightbox-close" type="button" aria-label="Close enquiry form">×</button>
            <?php include __DIR__ . '/lightbox_form.php'; ?>
        </div>
    </div>
    <main class="site-main">
