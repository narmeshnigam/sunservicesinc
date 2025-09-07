<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/helpers.php';

session_start();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_submit'])) {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    if ($email === '' || $password === '') {
        $errors[] = 'Please fill in both email and password.';
    } else {
        try {
            $pdo = ss_db_connect();
            $stmt = $pdo->prepare('SELECT id, name, email, password_plain, role FROM users WHERE email = ? AND status = "Active" LIMIT 1');
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            if ($user && hash_equals($user['password_plain'], $password)) {
                // Login success
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];
                // update last_login
                $update = $pdo->prepare('UPDATE users SET last_login = NOW() WHERE id = ?');
                $update->execute([$user['id']]);
                redirect('/admin/dashboard.php');
            } else {
                $errors[] = 'Invalid email or password.';
            }
        } catch (Exception $e) {
            $errors[] = 'An error occurred during login.';
        }
    }
}

// HTML for login page
$page_meta = [
    'title' => 'Admin Login | Sun Services Inc',
    'description' => 'Login to the administration panel of Sun Services Inc.',
    'keywords' => 'admin login, sun services inc',
];
include __DIR__ . '/../includes/header.php';
?>
<section class="hero">
    <h1>Admin Login</h1>
</section>
<section>
    <div class="container">
        <?php if (!empty($errors)): ?>
            <div class="enquiry-errors">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= e($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="post" class="enquiry-form" novalidate>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required value="<?= e($_POST['email'] ?? ''); ?>" />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required />
            </div>
            <div class="form-group">
                <button type="submit" name="login_submit" class="btn-primary">Login</button>
            </div>
        </form>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>