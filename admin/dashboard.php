<?php
require_once __DIR__ . '/../includes/auth_guard.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/helpers.php';

$pdo = ss_db_connect();

// Stats calculations
function countLeadsBetween(PDO $pdo, string $start, string $end): int {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM leads WHERE created_at >= ? AND created_at < ?');
    $stmt->execute([$start, $end]);
    return (int)$stmt->fetchColumn();
}

$todayStart = date('Y-m-d 00:00:00');
$tomorrowStart = date('Y-m-d 00:00:00', strtotime('+1 day'));
$weekStart = date('Y-m-d 00:00:00', strtotime('monday this week'));
$nextWeekStart = date('Y-m-d 00:00:00', strtotime('monday next week'));
$monthStart = date('Y-m-01 00:00:00');
$nextMonthStart = date('Y-m-d 00:00:00', strtotime('first day of next month'));

$stats = [
    'today' => countLeadsBetween($pdo, $todayStart, $tomorrowStart),
    'week'  => countLeadsBetween($pdo, $weekStart, $nextWeekStart),
    'month' => countLeadsBetween($pdo, $monthStart, $nextMonthStart),
];

// Recent leads
$recentStmt = $pdo->query('SELECT id, name, mobile, service, created_at FROM leads ORDER BY created_at DESC LIMIT 10');
$recentLeads = $recentStmt->fetchAll();

// Top services
$topStmt = $pdo->query('SELECT service, COUNT(*) AS cnt FROM leads GROUP BY service ORDER BY cnt DESC LIMIT 5');
$topServices = $topStmt->fetchAll();

$page_meta = [
    'title' => 'Admin Dashboard | Sun Services Inc',
    'description' => 'Administration dashboard for Sun Services Inc',
];
include __DIR__ . '/../includes/header.php';
?>
<section class="hero">
    <h1>Dashboard</h1>
    <p>Welcome back, <?= e($_SESSION['user_name'] ?? ''); ?>!</p>
</section>
<section>
    <div class="container">
        <div class="section-columns">
            <div class="col">
                <h2>Lead Summary</h2>
                <p>Leads Today: <?= $stats['today']; ?></p>
                <p>Leads This Week: <?= $stats['week']; ?></p>
                <p>Leads This Month: <?= $stats['month']; ?></p>
            </div>
            <div class="col">
                <h2>Top Services</h2>
                <ul>
                    <?php foreach ($topServices as $row): ?>
                        <li><?= e($row['service']); ?> (<?= (int)$row['cnt']; ?>)</li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <h2>Recent Leads</h2>
        <div class="table-wrapper" style="overflow-x:auto;">
            <table style="width:100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align:left; border-bottom:1px solid #ccc; padding:0.5rem;">ID</th>
                        <th style="text-align:left; border-bottom:1px solid #ccc; padding:0.5rem;">Name</th>
                        <th style="text-align:left; border-bottom:1px solid #ccc; padding:0.5rem;">Mobile</th>
                        <th style="text-align:left; border-bottom:1px solid #ccc; padding:0.5rem;">Service</th>
                        <th style="text-align:left; border-bottom:1px solid #ccc; padding:0.5rem;">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentLeads as $lead): ?>
                        <tr>
                            <td style="padding:0.5rem; border-bottom:1px solid #eee;"><?= (int)$lead['id']; ?></td>
                            <td style="padding:0.5rem; border-bottom:1px solid #eee;"><?= e($lead['name']); ?></td>
                            <td style="padding:0.5rem; border-bottom:1px solid #eee;"><?= e($lead['mobile']); ?></td>
                            <td style="padding:0.5rem; border-bottom:1px solid #eee;"><?= e($lead['service']); ?></td>
                            <td style="padding:0.5rem; border-bottom:1px solid #eee;"><?= e(date('d M Y, H:i', strtotime($lead['created_at']))); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>