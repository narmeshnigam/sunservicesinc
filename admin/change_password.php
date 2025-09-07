<?php
require_once __DIR__ . '/../includes/auth_guard.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/helpers.php';

session_start();
// Redirect if not logged in (auth_guard ensures)
$userId = $_SESSION['user_id'] ?? 0;
$pdo = ss_db_connect();

$errors = [];
$successMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password_submit'])) {
    $currentPassword = trim($_POST['current_password'] ?? '');
    $newPassword = trim($_POST['new_password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');
    if ($currentPassword === '' || $newPassword === '' || $confirmPassword === '') {
        $errors[] = 'All fields are required.';
    } elseif ($newPassword !== $confirmPassword) {
        $errors[] = 'New password and confirmation do not match.';
    } else {
        // Fetch current
        $stmt = $pdo->prepare('SELECT password_plain FROM users WHERE id = ?');
        $stmt->execute([$userId]);
        $row = $stmt->fetch();
        if (!$row || !hash_equals($row['password_plain'], $currentPassword)) {
            $errors[] = 'Current password is incorrect.';
        } else {
            // Update password
            $update = $pdo->prepare('UPDATE users SET password_plain = ?, updated_at = NOW() WHERE id = ?');
            $update->execute([$newPassword, $userId]);
            $successMsg = 'Password updated successfully.';
        }
    }
}

$page_meta = [
    'title' => 'Change Password | Admin | Sun Services Inc',
    'description' => 'Change your administrative password',
];
include __DIR__ . '/../includes/header.php';
?>
<section class="hero">
    <h1>Change Password</h1>
</section>
<section>
    <div class="container">
        <?php if ($successMsg): ?>
            <div class="enquiry-success">
                <p><?= e($successMsg); ?></p>
            </div>
        <?php endif; ?>
        <?php if (!empty($errors)): ?>
            <div class="enquiry-errors">
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?= e($err); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="post" class="enquiry-form" novalidate>
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password" required />
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" required />
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required />
            </div>
            <div class="form-group">
                <button type="submit" name="change_password_submit" class="btn-primary">Change Password</button>
            </div>
        </form>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>