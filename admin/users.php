<?php
require_once __DIR__ . '/../includes/auth_guard.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/helpers.php';

$pdo = ss_db_connect();

// Handle actions: add, edit, delete, export
$action = $_GET['action'] ?? '';
$errors = [];
$successMsg = '';

// Delete user
if (isset($_GET['delete_id'])) {
    $deleteId = (int)$_GET['delete_id'];
    if ($deleteId > 0) {
        $delStmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
        $delStmt->execute([$deleteId]);
        $successMsg = 'User deleted successfully.';
    }
}

// Add or edit user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_submit'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password_plain = trim($_POST['password_plain'] ?? '');
    $role = trim($_POST['role'] ?? 'Viewer');
    $status = trim($_POST['status'] ?? 'Active');
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    // Validation
    if ($name === '' || $email === '' || ($id === 0 && $password_plain === '')) {
        $errors[] = 'Please fill in all required fields.';
    } else {
        // Check email uniqueness for new user or editing different user
        $emailCheckStmt = $pdo->prepare('SELECT id FROM users WHERE email = ? AND id != ?');
        $emailCheckStmt->execute([$email, $id]);
        if ($emailCheckStmt->fetch()) {
            $errors[] = 'Email is already in use.';
        }
    }
    if (empty($errors)) {
        if ($id > 0) {
            // Update existing
            if ($password_plain !== '') {
                $update = $pdo->prepare('UPDATE users SET name = ?, email = ?, password_plain = ?, role = ?, status = ? WHERE id = ?');
                $update->execute([$name, $email, $password_plain, $role, $status, $id]);
            } else {
                $update = $pdo->prepare('UPDATE users SET name = ?, email = ?, role = ?, status = ? WHERE id = ?');
                $update->execute([$name, $email, $role, $status, $id]);
            }
            $successMsg = 'User updated successfully.';
        } else {
            // Insert new
            $insert = $pdo->prepare('INSERT INTO users (name, email, password_plain, role, status, created_at, updated_at) VALUES (?,?,?,?,?, NOW(), NOW())');
            $insert->execute([$name, $email, $password_plain, $role, $status]);
            $successMsg = 'User added successfully.';
        }
        // Redirect to clear POST data
        header('Location: users.php');
        exit;
    }
}

// Export CSV
if (isset($_GET['export']) && $_GET['export'] === '1') {
    $stmt = $pdo->query('SELECT * FROM users ORDER BY id ASC');
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="users_export_' . date('Ymd_His') . '.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['ID','Name','Email','Password','Role','Status','Last Login','Created At','Updated At']);
    while ($row = $stmt->fetch()) {
        fputcsv($out, [$row['id'], $row['name'], $row['email'], $row['password_plain'], $row['role'], $row['status'], $row['last_login'], $row['created_at'], $row['updated_at']]);
    }
    fclose($out);
    exit;
}

// Get user to edit if applicable
$editUser = null;
if (isset($_GET['edit_id'])) {
    $editId = (int)$_GET['edit_id'];
    if ($editId > 0) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$editId]);
        $editUser = $stmt->fetch();
    }
}

// Fetch all users
$usersStmt = $pdo->query('SELECT * FROM users ORDER BY id ASC');
$usersList = $usersStmt->fetchAll();

$page_meta = [
    'title' => 'Users | Admin | Sun Services Inc',
    'description' => 'Manage admin users',
];
include __DIR__ . '/../includes/header.php';
?>
<section class="hero">
    <h1>Users</h1>
    <p>Manage administrative users.</p>
</section>
<section>
    <div class="container">
        <?php if ($successMsg): ?>
            <div class="enquiry-success" style="margin-bottom:1rem;">
                <p><?= e($successMsg); ?></p>
            </div>
        <?php endif; ?>
        <?php if (!empty($errors)): ?>
            <div class="enquiry-errors">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= e($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <!-- User form (Add/Edit) -->
        <details style="margin-bottom:1rem;" <?= $editUser ? 'open' : ''; ?>>
            <summary><?= $editUser ? 'Edit User' : 'Add User'; ?></summary>
            <form method="post" class="enquiry-form" novalidate style="margin-top:1rem;">
                <input type="hidden" name="id" value="<?= e($editUser['id'] ?? ''); ?>" />
                <div class="form-group">
                    <label for="userName">Name</label>
                    <input type="text" id="userName" name="name" required value="<?= e($_POST['name'] ?? ($editUser['name'] ?? '')); ?>" />
                </div>
                <div class="form-group">
                    <label for="userEmail">Email</label>
                    <input type="email" id="userEmail" name="email" required value="<?= e($_POST['email'] ?? ($editUser['email'] ?? '')); ?>" />
                </div>
                <div class="form-group">
                    <label for="userPassword">Password<?= $editUser ? ' (leave blank to keep current)' : ''; ?></label>
                    <input type="text" id="userPassword" name="password_plain" <?= $editUser ? '' : 'required'; ?> />
                </div>
                <div class="form-group">
                    <label for="userRole">Role</label>
                    <select id="userRole" name="role">
                        <?php
                        $roles = ['Admin','Viewer'];
                        $selectedRole = $_POST['role'] ?? ($editUser['role'] ?? 'Viewer');
                        foreach ($roles as $role): ?>
                            <option value="<?= e($role); ?>" <?= $selectedRole === $role ? 'selected' : ''; ?>><?= e($role); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="userStatus">Status</label>
                    <select id="userStatus" name="status">
                        <?php
                        $statuses = ['Active','Disabled'];
                        $selectedStatus = $_POST['status'] ?? ($editUser['status'] ?? 'Active');
                        foreach ($statuses as $status): ?>
                            <option value="<?= e($status); ?>" <?= $selectedStatus === $status ? 'selected' : ''; ?>><?= e($status); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" name="user_submit" class="btn-primary"><?= $editUser ? 'Update' : 'Add'; ?> User</button>
                </div>
            </form>
        </details>
        <!-- Users table -->
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr>
                        <th style="padding:0.5rem; border-bottom:1px solid #ccc;">ID</th>
                        <th style="padding:0.5rem; border-bottom:1px solid #ccc;">Name</th>
                        <th style="padding:0.5rem; border-bottom:1px solid #ccc;">Email</th>
                        <th style="padding:0.5rem; border-bottom:1px solid #ccc;">Role</th>
                        <th style="padding:0.5rem; border-bottom:1px solid #ccc;">Status</th>
                        <th style="padding:0.5rem; border-bottom:1px solid #ccc;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usersList as $user): ?>
                        <tr>
                            <td style="padding:0.5rem; border-bottom:1px solid #eee;"><?= (int)$user['id']; ?></td>
                            <td style="padding:0.5rem; border-bottom:1px solid #eee;"><?= e($user['name']); ?></td>
                            <td style="padding:0.5rem; border-bottom:1px solid #eee;"><?= e($user['email']); ?></td>
                            <td style="padding:0.5rem; border-bottom:1px solid #eee;"><?= e($user['role']); ?></td>
                            <td style="padding:0.5rem; border-bottom:1px solid #eee;"><?= e($user['status']); ?></td>
                            <td style="padding:0.5rem; border-bottom:1px solid #eee;">
                                <a href="?edit_id=<?= (int)$user['id']; ?>" class="btn-primary" style="padding:0.3rem 0.6rem;">Edit</a>
                                <a href="?delete_id=<?= (int)$user['id']; ?>" class="btn-primary" style="padding:0.3rem 0.6rem; background:#d9534f;" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div style="margin-top:1rem;">
            <a href="?export=1" class="btn-primary">Export Users CSV</a>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>