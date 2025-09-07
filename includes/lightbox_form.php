<?php
// Enquiry form displayed in lightbox
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/helpers.php';

$errors = [];
$success = false;

// If the form is posted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enquiry_submit'])) {
    // Retrieve and sanitize fields
    $name = trim($_POST['name'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $service = trim($_POST['service'] ?? '');
    $sub_service = trim($_POST['sub_service'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $pincode = trim($_POST['pincode'] ?? '');
    $preferred_at = trim($_POST['preferred_at'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $source_page = trim($_POST['source_page'] ?? ($_SERVER['REQUEST_URI'] ?? ''));
    $consent = isset($_POST['consent']) ? true : false;

    // Validate required fields
    if ($name === '') {
        $errors[] = 'Please enter your name';
    }
    if (!preg_match('/^\d{10}$/', $mobile)) {
        $errors[] = 'Please enter a valid 10‑digit mobile number';
    }
    if ($service === '') {
        $errors[] = 'Please select a service';
    }
    if (!$consent) {
        $errors[] = 'Please accept the terms and conditions';
    }

    // If no errors, insert into DB
    if (empty($errors)) {
        try {
            $pdo = ss_db_connect();
            $stmt = $pdo->prepare('INSERT INTO leads (name, mobile, email, service, sub_service, city, pincode, preferred_at, message, source_page, created_at) VALUES (?,?,?,?,?,?,?,?,?,?, NOW())');
            $stmt->execute([
                $name,
                $mobile,
                $email ?: null,
                $service,
                $sub_service ?: null,
                $city ?: null,
                $pincode ?: null,
                $preferred_at ?: null,
                $message ?: null,
                $source_page,
            ]);
            // Attempt to send email notification (suppressed on platforms without mail function)
            @mail('support@sunservicesinc.in', 'New Enquiry Received', "Name: $name\nMobile: $mobile\nEmail: $email\nService: $service\nSub Service: $sub_service\nCity: $city\nPincode: $pincode\nPreferred At: $preferred_at\nMessage: $message\nSource Page: $source_page", "From: no-reply@sunservicesinc.in\r\n");
            $success = true;
        } catch (Exception $e) {
            $errors[] = 'There was a problem submitting your enquiry. Please try again later.';
        }
    }
}

// Build list of services and sub‑services for select fields. The mapping is reused on the front‑end via JavaScript.
$services_map = [
    'Flooring' => ['Carpet Flooring','Laminate Flooring','Vinyl Flooring'],
    'Cleaning' => ['Carpet Cleaning','Sofa & Chair Cleaning','Window Cleaning','Marble Polishing'],
    'Window Treatments' => ['Blinds','Honeycomb Blinds','Roller Blinds','Roman Blinds','PVC Chick Blinds'],
    'Curtains & Nets' => ['Curtains','PVC Strip Curtains','Mosquito Nets'],
    'Wall & Décor' => ['Wallpaper Installation','PVC Wall Stickers'],
    'Facility Services' => ['Facility Management','Annual Maintenance','Corporate AMC'],
];

?>
<?php if ($success): ?>
    <div class="enquiry-success">
        <h2>Thank you!</h2>
        <p>Your enquiry has been submitted successfully. Our team will contact you shortly.</p>
    </div>
<?php else: ?>
    <?php if (!empty($errors)): ?>
        <div class="enquiry-errors">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= e($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="post" class="enquiry-form" id="enquiryForm" novalidate>
        <h2 id="enquiryTitle">Service Enquiry</h2>
        <input type="hidden" name="source_page" value="<?= e($_SERVER['REQUEST_URI'] ?? ''); ?>" />
        <div class="form-group">
            <label for="name">Full Name<span>*</span></label>
            <input type="text" id="name" name="name" required value="<?= e($_POST['name'] ?? ''); ?>" />
        </div>
        <div class="form-group">
            <label for="mobile">Mobile Number<span>*</span></label>
            <input type="tel" id="mobile" name="mobile" pattern="\d{10}" maxlength="10" required value="<?= e($_POST['mobile'] ?? ''); ?>" />
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= e($_POST['email'] ?? ''); ?>" />
        </div>
        <div class="form-group">
            <label for="service">Service Category<span>*</span></label>
            <select id="service" name="service" required>
                <option value="">-- Select Service --</option>
                <?php foreach (array_keys($services_map) as $cat): ?>
                    <option value="<?= e($cat); ?>" <?= (($_POST['service'] ?? '') === $cat) ? 'selected' : ''; ?>><?= e($cat); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="sub_service">Sub‑Service</label>
            <select id="sub_service" name="sub_service">
                <option value="">-- Select Sub‑Service --</option>
                <!-- Options populated via JS -->
            </select>
        </div>
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" id="city" name="city" value="<?= e($_POST['city'] ?? ''); ?>" />
        </div>
        <div class="form-group">
            <label for="pincode">Pincode</label>
            <input type="text" id="pincode" name="pincode" pattern="\d{6}" maxlength="6" value="<?= e($_POST['pincode'] ?? ''); ?>" />
        </div>
        <div class="form-group">
            <label for="preferred_at">Preferred Date/Time</label>
            <input type="datetime-local" id="preferred_at" name="preferred_at" value="<?= e($_POST['preferred_at'] ?? ''); ?>" />
        </div>
        <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" rows="4"><?= e($_POST['message'] ?? ''); ?></textarea>
        </div>
        <div class="form-group consent">
            <label>
                <input type="checkbox" name="consent" <?= isset($_POST['consent']) ? 'checked' : ''; ?> required />
                I agree to the <a href="/privacy-policy.php">terms & conditions</a>
            </label>
        </div>
        <div class="form-group">
            <button type="submit" name="enquiry_submit" class="btn-primary">Submit Enquiry</button>
        </div>
    </form>
    <script>
        // Pass services map to JS
        window.ssServicesMap = <?php echo json_encode($services_map, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;
    </script>
<?php endif; ?>