<?php
require_once __DIR__ . '/../includes/auth_guard.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/helpers.php';

// Handle filters
$serviceFilter = trim($_GET['service'] ?? '');
$cityFilter = trim($_GET['city'] ?? '');
$startDate = trim($_GET['start_date'] ?? '');
$endDate = trim($_GET['end_date'] ?? '');
$exportCsv = isset($_GET['export']) && $_GET['export'] === '1';

$pdo = ss_db_connect();
// Build query
$where = [];
$params = [];
if ($serviceFilter !== '') {
    $where[] = 'service = ?';
    $params[] = $serviceFilter;
}
if ($cityFilter !== '') {
    $where[] = 'city = ?';
    $params[] = $cityFilter;
}
if ($startDate !== '') {
    $where[] = 'created_at >= ?';
    $params[] = $startDate . ' 00:00:00';
}
if ($endDate !== '') {
    $where[] = 'created_at <= ?';
    $params[] = $endDate . ' 23:59:59';
}
$whereClause = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

// Export CSV if requested
if ($exportCsv) {
    $stmt = $pdo->prepare("SELECT * FROM leads $whereClause ORDER BY created_at DESC");
    $stmt->execute($params);
    $filename = 'leads_export_' . date('Ymd_His') . '.csv';
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    $output = fopen('php://output', 'w');
    // CSV headers
    fputcsv($output, ['ID','Name','Mobile','Email','Service','Sub Service','City','Pincode','Preferred At','Message','Source Page','Created At']);
    while ($row = $stmt->fetch()) {
        fputcsv($output, [
            $row['id'], $row['name'], $row['mobile'], $row['email'],
            $row['service'], $row['sub_service'], $row['city'], $row['pincode'],
            $row['preferred_at'], $row['message'], $row['source_page'], $row['created_at'],
        ]);
    }
    fclose($output);
    exit;
}

// Pagination
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 50;
$offset = ($page - 1) * $perPage;

// Get total count for pagination
$countStmt = $pdo->prepare("SELECT COUNT(*) FROM leads $whereClause");
$countStmt->execute($params);
$totalRows = (int)$countStmt->fetchColumn();
// Fetch rows for current page
$stmt = $pdo->prepare("SELECT * FROM leads $whereClause ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
$stmt->execute($params);
$leads = $stmt->fetchAll();

$page_meta = [
    'title' => 'Leads | Admin | Sun Services Inc',
    'description' => 'Manage and export lead data',
];
include __DIR__ . '/../includes/header.php';
?>
<section class="hero">
    <h1>Leads</h1>
    <p>Manage all enquiries received through the website.</p>
</section>
<section>
    <div class="container">
        <form method="get" class="enquiry-form" style="gap:0.5rem;">
            <div class="section-columns">
                <div class="col">
                    <label for="serviceFilter">Service</label>
                    <input type="text" id="serviceFilter" name="service" value="<?= e($serviceFilter); ?>" placeholder="Service name" />
                </div>
                <div class="col">
                    <label for="cityFilter">City</label>
                    <input type="text" id="cityFilter" name="city" value="<?= e($cityFilter); ?>" placeholder="City" />
                </div>
                <div class="col">
                    <label for="startDate">From</label>
                    <input type="date" id="startDate" name="start_date" value="<?= e($startDate); ?>" />
                </div>
                <div class="col">
                    <label for="endDate">To</label>
                    <input type="date" id="endDate" name="end_date" value="<?= e($endDate); ?>" />
                </div>
                <div class="col" style="display:flex; align-items:flex-end; gap:0.5rem;">
                    <button type="submit" class="btn-primary">Filter</button>
                    <a href="?<?= http_build_query(array_merge($_GET, ['export' => 1])); ?>" class="btn-primary" style="white-space:nowrap;">Export CSV</a>
                </div>
            </div>
        </form>
        <div style="overflow-x:auto; margin-top:1rem;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr>
                        <th style="padding:0.5rem; border-bottom:1px solid #ccc;">ID</th>
                        <th style="padding:0.5rem; border-bottom:1px solid #ccc;">Name</th>
                        <th style="padding:0.5rem; border-bottom:1px solid #ccc;">Mobile</th>
                        <th style="padding:0.5rem; border-bottom:1px solid #ccc;">Email</th>
                        <th style="padding:0.5rem; border-bottom:1px solid #ccc;">Service</th>
                        <th style="padding:0.5rem; border-bottom:1px solid #ccc;">Sub‑Service</th>
                        <th style="padding:0.5rem; border-bottom:1px solid #ccc;">City</th>
                        <th style="padding:0.5rem; border-bottom:1px solid #ccc;">Pincode</th>
                        <th style="padding:0.5rem; border-bottom:1px solid #ccc;">Preferred</th>
                        <th style="padding:0.5rem; border-bottom:1px solid #ccc;">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($leads as $lead): ?>
                        <tr>
                            <td style="padding:0.5rem; border-bottom:1px solid #eee;"><?= (int)$lead['id']; ?></td>
                            <td style="padding:0.5rem; border-bottom:1px solid #eee;"><?= e($lead['name']); ?></td>
                            <td style="padding:0.5rem; border-bottom:1px solid #eee;"><?= e($lead['mobile']); ?></td>
                            <td style="padding:0.5rem; border-bottom:1px solid #eee;"><?= e($lead['email']); ?></td>
                            <td style="padding:0.5rem; border-bottom:1px solid #eee;"><?= e($lead['service']); ?></td>
                            <td style="padding:0.5rem; border-bottom:1px solid #eee;"><?= e($lead['sub_service']); ?></td>
                            <td style="padding:0.5rem; border-bottom:1px solid #eee;"><?= e($lead['city']); ?></td>
                            <td style="padding:0.5rem; border-bottom:1px solid #eee;"><?= e($lead['pincode']); ?></td>
                            <td style="padding:0.5rem; border-bottom:1px solid #eee;"><?= e($lead['preferred_at']); ?></td>
                            <td style="padding:0.5rem; border-bottom:1px solid #eee;"><?= e(date('d M Y, H:i', strtotime($lead['created_at']))); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- Pagination controls -->
        <?php
        $totalPages = ceil($totalRows / $perPage);
        if ($totalPages > 1):
        ?>
        <nav aria-label="Pagination" style="margin-top:1rem;">
            <ul class="nav-list" style="flex-wrap:wrap; gap:0.5rem;">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php $query = http_build_query(array_merge($_GET, ['page' => $i])); ?>
                    <li><a href="?<?= $query; ?>" class="btn-primary" style="padding:0.3rem 0.6rem;<?= $i == $page ? ' background:#e9961a;' : ''; ?>"> <?= $i; ?> </a></li>
                <?php endfor; ?>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>