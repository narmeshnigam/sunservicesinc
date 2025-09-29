<?php
// Preserve your existing meta if already set; else provide a safe default to avoid header issues
if (!isset($page_meta)) {
  $page_meta = [
    'title' => 'Sun Services Inc — Cleaning, Polishing & Facility Services in Delhi NCR',
    'description' => 'Deep home cleaning, marble floor polishing, sofa shampooing, blinds & wallpaper installation, and housekeeping staffing across Delhi NCR.',
    'canonical' => '/'
  ];
}
include __DIR__ . '/includes/header.php';
?>

<!-- ============ PAGE-SCOPED CSS (NAMESPACED) ============ -->
<style>
  /* Sun Services Inc — Home (namespaced) */
  .ssi-home {
    --ink: #0f172a;
    --muted: #475569;
    --brand: #1b4dd9;
    --accent: #0ea5e9;
    --bg: #f8fafc;
    --card: #ffffff;
    --rule: #e2e8f0
  }

  .ssi-home {
    color: var(--ink);
    background: var(--bg)
  }

  .ssi-home .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: clamp(16px, 2vw, 24px)
  }

  /* HERO */
  .ssi-home__hero {
    display: grid;
    grid-template-columns: 1.25fr .75fr;
    gap: 24px;
    align-items: center;
    margin: 10px 0 22px
  }

  @media (max-width: 900px) {
    .ssi-home__hero {
      grid-template-columns: 1fr
    }
  }

  .ssi-home__eyebrow {
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
    background: #eef2ff;
    color: #1e293b;
    border: 1px solid var(--rule);
    border-radius: 999px;
    padding: 6px 10px;
    margin-bottom: 8px
  }

  .ssi-home__title {
    font-size: clamp(28px, 3.2vw, 42px);
    line-height: 1.15;
    margin: 0 0 10px
  }

  .ssi-home__lead {
    font-size: clamp(14px, 1.6vw, 18px);
    color: var(--muted);
    margin: 0 0 16px
  }

  .ssi-home__cta-row {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 10px
  }

  .ssi-btn {
    appearance: none;
    border: 0;
    border-radius: 10px;
    padding: 10px 14px;
    font-weight: 700;
    cursor: pointer
  }

  .ssi-btn--primary {
    background: #2563eb;
    color: #fff
  }

  .ssi-btn--ghost {
    background: #fff;
    border: 1px solid var(--rule);
    color: #111827
  }

  .ssi-home__media picture,
  .ssi-home__media img {
    width: 100%;
    height: auto;
    border-radius: 14px;
    display: block;
    border: 1px solid var(--rule)
  }

  /* TRUST */
  .ssi-home__trust {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin: 10px 0 28px
  }

  @media (max-width:900px) {
    .ssi-home__trust {
      grid-template-columns: repeat(2, 1fr)
    }
  }

  .ssi-home__trust .pill {
    background: #ecfeff;
    border: 1px solid var(--rule);
    color: #0c4a6e;
    border-radius: 12px;
    padding: 10px 12px;
    font-size: 13px
  }

  /* TOP SERVICES */
  .ssi-home__services {
    margin: 8px 0 30px
  }

  .ssi-home__head {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: flex-end;
    gap: 16px;
    margin: 0 0 12px
  }

  .ssi-home__head h2 {
    font-size: clamp(20px, 2.4vw, 28px);
    margin: 0
  }

  .ssi-home__list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin: 6px 0 14px
  }

  .ssi-home__list .chip {
    background: #fff;
    border: 1px solid var(--rule);
    border-radius: 999px;
    padding: 6px 10px;
    font-size: 12px
  }

  .ssi-home__grid {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    gap: 14px
  }

  @media (max-width:1200px) {
    .ssi-home__grid {
      grid-template-columns: repeat(8, 1fr)
    }
  }

  @media (max-width:900px) {
    .ssi-home__grid {
      grid-template-columns: repeat(4, 1fr)
    }
  }

  @media (max-width:600px) {
    .ssi-home__grid {
      grid-template-columns: repeat(2, 1fr)
    }
  }

  .ssi-card {
    grid-column: span 4;
    background: var(--card);
    border: 1px solid var(--rule);
    border-radius: 14px;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    transition: transform .18s ease, box-shadow .18s ease
  }

  .ssi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(2, 6, 23, .08)
  }

  .ssi-card__media img {
    width: 100%;
    height: auto;
    display: block
  }

  .ssi-card__body {
    padding: 14px
  }

  .ssi-card__body h3 {
    font-size: 16px;
    margin: 0 0 6px
  }

  .ssi-card__body p {
    font-size: 13px;
    color: var(--muted);
    margin: 0
  }

  /* USPs */
  .ssi-home__usps {
    margin: 10px 0 26px
  }

  .ssi-tiles {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px
  }

  @media (max-width:900px) {
    .ssi-tiles {
      grid-template-columns: repeat(2, 1fr)
    }
  }

  .ssi-tile {
    background: var(--card);
    border: 1px solid var(--rule);
    border-radius: 14px;
    padding: 16px
  }

  .ssi-tile h3 {
    margin: 0 0 6px;
    font-size: 15px
  }

  .ssi-tile p {
    margin: 0;
    color: var(--muted);
    font-size: 13px
  }

  /* PROCESS + KPIs */
  .ssi-home__process {
    margin: 4px 0 28px
  }

  .ssi-steps {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px
  }

  @media (max-width:900px) {
    .ssi-steps {
      grid-template-columns: repeat(2, 1fr)
    }
  }

  .ssi-step {
    background: var(--card);
    border: 1px solid var(--rule);
    border-radius: 14px;
    padding: 16px
  }

  .ssi-step strong {
    display: block;
    margin-bottom: 6px
  }

  .ssi-kpis {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-top: 8px
  }

  @media (max-width:900px) {
    .ssi-kpis {
      grid-template-columns: repeat(2, 1fr)
    }
  }

  .ssi-kpi {
    background: #0b1220;
    color: #e2e8f0;
    border-radius: 14px;
    padding: 16px;
    border: 1px solid #141b2f
  }

  .ssi-kpi b {
    display: block;
    font-size: 22px;
    color: #fff
  }

  /* PRICING */
  .ssi-home__pricing {
    margin: 8px 0 28px
  }

  .ssi-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px
  }

  .ssi-table th,
  .ssi-table td {
    border: 1px solid var(--rule);
    padding: 10px;
    text-align: left;
    vertical-align: top
  }

  .ssi-table th {
    background: #eef2ff
  }

  .ssi-note {
    font-size: 12px;
    color: var(--muted);
    margin-top: 6px
  }

  /* AREAS */
  .ssi-home__areas {
    margin: 8px 0 26px
  }

  .ssi-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px
  }

  .ssi-tags .tag {
    background: #fff;
    border: 1px solid var(--rule);
    border-radius: 999px;
    padding: 6px 10px;
    font-size: 12px
  }

  /* BEFORE/AFTER */
  .ssi-home__ba {
    margin: 8px 0 28px
  }

  .ssi-ba-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px
  }

  @media (max-width:900px) {
    .ssi-ba-grid {
      grid-template-columns: repeat(2, 1fr)
    }
  }

  .ssi-ba {
    position: relative;
    background: #000;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid var(--rule)
  }

  .ssi-ba img {
    width: 100%;
    height: auto;
    display: block
  }

  .ssi-ba span {
    position: absolute;
    left: 10px;
    top: 10px;
    background: rgba(0, 0, 0, .6);
    color: #fff;
    font-size: 12px;
    padding: 4px 8px;
    border-radius: 999px
  }

  /* EQUIPMENT */
  .ssi-home__equip {
    margin: 8px 0 26px
  }

  .ssi-list {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px
  }

  @media (max-width:900px) {
    .ssi-list {
      grid-template-columns: repeat(1, 1fr)
    }
  }

  .ssi-list li {
    background: #fff;
    border: 1px solid var(--rule);
    border-radius: 12px;
    padding: 10px
  }

  /* TESTIMONIALS */
  .ssi-home__testi {
    margin: 8px 0 26px
  }

  .ssi-testis {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px
  }

  @media (max-width:900px) {
    .ssi-testis {
      grid-template-columns: repeat(1, 1fr)
    }
  }

  .ssi-quote {
    background: #fff;
    border: 1px solid var(--rule);
    border-radius: 14px;
    padding: 14px
  }

  .ssi-quote p {
    margin: 0 0 6px
  }

  .ssi-quote small {
    color: var(--muted)
  }

  /* CTA */
  .ssi-home__cta {
    position: relative;
    background: #0b1220;
    color: #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    margin: 26px 0
  }

  .ssi-home__cta-inner {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 18px;
    align-items: center;
    padding: 18px
  }

  @media (max-width: 720px) {
    .ssi-home__cta-inner {
      grid-template-columns: 1fr
    }
  }

  .ssi-home__cta h3 {
    margin: 0
  }

  .ssi-home__cta img {
    position: absolute;
    inset: auto -20px 0 auto;
    width: 320px;
    opacity: .12;
    pointer-events: none
  }

  .sr-only {
    position: absolute !important;
    height: 1px;
    width: 1px;
    overflow: hidden;
    clip: rect(1px, 1px, 1px, 1px);
    white-space: nowrap
  }
  /* FAQ cards */
  .ssi-home__faq { margin: 8px 0 26px }
  .ssi-faq-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px }
  @media (max-width:900px){ .ssi-faq-grid { grid-template-columns: 1fr } }
  .ssi-faq { background: #fff; border: 2px solid var(--ink); border-radius: 12px; padding: 10px }
  .ssi-faq summary { list-style: none; cursor: pointer; font-weight: 700 }
  .ssi-faq summary::-webkit-details-marker { display: none }
  .ssi-faq[open] { box-shadow: 0 6px 20px rgba(2,6,23,.08) }
  .ssi-faq .faq-body { margin-top: 8px; color: var(--muted); font-size: 14px }
  /* Fallback: style existing <details> if wrapper class not present */
  .ssi-home__faq details { background:#fff; border:2px solid var(--ink); border-radius:12px; padding:10px; margin:10px 0 }
  .ssi-home__faq summary { list-style:none; cursor:pointer; font-weight:700 }
  .ssi-home__faq summary::-webkit-details-marker { display:none }
  .ssi-home__faq details[open] { box-shadow:0 6px 20px rgba(2,6,23,.08) }
</style>

<!-- ========================= -->
<!-- EXISTING LEGACY CONTENT  -->
<!-- (Left intact; links/paths preserved) -->
<?php /* Your original sections remain here untouched. If you have a legacy services list, leave it — the script below will mirror those links into the new cards. */ ?>

<!-- ========================= -->
<!-- NEW, LONG-FORM LANDING PAGE -->
<section class="ssi-home" data-ssi="home">
  <div class="container ssi-home__hero">
    <div>
      <span class="ssi-home__eyebrow">Delhi NCR · Since 2006</span>
      <h1 class="ssi-home__title">Curtains, Blinds &amp; Flooring and Maintenance Services — Done Right</h1>
      <p class="ssi-home__lead">Complete <strong>curtains, blinds, and flooring solutions</strong>—from consultation and measurement to supply, professional installation, and ongoing maintenance. We manage every step, ensuring perfect fit, finish, and long-term care for homes and offices.</p>
      <div class="ssi-home__cta-row">
        <button class="ssi-btn ssi-btn--primary open-enquiry" type="button" data-service="General Enquiry">Book a Visit</button>
        <button class="ssi-btn ssi-btn--ghost open-enquiry" type="button" data-service="Get Quote">Get a Quote</button>
      </div>
    </div>
    <div class="ssi-home__media">
      <picture>
        <img src="/assets/img/sun-services/hero-team-01.jpg" alt="Professional cleaning team polishing marble floors in a Delhi apartment" loading="lazy" width="1200" height="800">
      </picture>
    </div>
  </div>

  <!-- Trust indicators -->
  <div class="container ssi-home__trust">
    <div class="pill">Verified crew & PPE</div>
    <div class="pill">Pro machines & pads</div>
    <div class="pill">Transparent scope</div>
    <div class="pill">Digital invoices</div>
  </div>

  <!-- TOP SERVICES (explicit list + cards mirrored from legacy links) -->
  <div class="container ssi-home__services">
    <div class="ssi-home__head">
      <h2>Top Services</h2>
      <small class="sr-only">Cards below mirror your existing service links; explicit list ensures visibility.</small>
    </div>

    <!-- Explicit named list (always visible) -->
    <div class="ssi-home__list" aria-label="Popular services we provide">
      <span class="chip">Window Blinds Installtion</span>
      <span class="chip">Designer Curtains - Fabric &amp; Fitting</span>
      <span class="chip">Curtain Tracks Installation</span>
      <span class="chip">Mosquito Net</span>
      <span class="chip">Wall Covering</span>
      <span class="chip">Wallpaper Sale &amp; Installation</span>
      <span class="chip">UVM PVC Wall Sticker</span>
      <span class="chip">Carpet Flooring</span>
      <span class="chip">PVC Vinyl Flooring</span>
      <span class="chip">Wooden Laminate</span>
      <span class="chip">Diamond &amp; Silicate Polishing</span>
      <span class="chip">Marble, Granite, Mosaic &amp; Kota Floor Polishing</span>
      <span class="chip">Carpet Cleaning</span>
      <span class="chip">Sofa &amp; Chair Cleaning</span>
      <span class="chip">Window Blinds - Repairing &amp; Cleaning</span>
    </div>

    <!-- Server-rendered card grid (12 items) -->
    <?php
      $top_services = [
        ['title' => 'Window Blinds', 'href' => '/services/blinds.php'],
        ['title' => 'Roller Blinds', 'href' => '/services/roller-blinds.php'],
        ['title' => 'Roman Blinds', 'href' => '/services/roman-blinds.php'],
        ['title' => 'Honeycomb Blinds', 'href' => '/services/honeycomb-blinds.php'],
        ['title' => 'Window Blinds Cleaning', 'href' => '/services/window-cleaning.php'],
        ['title' => 'Designer Curtains', 'href' => '/services/curtains.php'],
        ['title' => 'Wooden Flooring', 'href' => '/services/laminate-flooring.php'],
        ['title' => 'PVC Vinyl Flooring', 'href' => '/services/vinyl-flooring.php'],
        ['title' => 'Wall Paper', 'href' => '/services/wallpaper-installation.php'],
        ['title' => 'Marble Floor Polishing', 'href' => '/services/marble-polishing.php'],
        ['title' => 'Sofa & Chairs Cleaning', 'href' => '/services/sofa-chair-cleaning.php'],
        ['title' => 'Carpet Cleaning', 'href' => '/services/carpet-cleaning.php'],
        
      ];
    ?>
    <div class="ssi-home__grid" id="ssiServiceCards">
      <?php $i = 0; foreach ($top_services as $svc): $i++; $n = str_pad((string)$i, 2, '0', STR_PAD_LEFT); ?>
        <a class="ssi-card" href="<?php echo htmlspecialchars($svc['href']); ?>" aria-label="<?php echo htmlspecialchars($svc['title']); ?>">
          <figure class="ssi-card__media">
            <img src="/assets/img/sun-services/service-<?php echo $n; ?>.jpg" alt="<?php echo htmlspecialchars($svc['title']); ?> – Sun Services Inc" loading="lazy" width="480" height="320">
          </figure>
          <div class="ssi-card__body">
            <h3><?php echo htmlspecialchars($svc['title']); ?></h3>
            <p><?php echo htmlspecialchars($svc['title']); ?> by trained professionals in Delhi NCR. Book a visit today.</p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Why choose us -->
  <div class="container ssi-home__usps">
    <div class="ssi-tiles">
      <div class="ssi-tile">
        <h3>Right Method, Right Chemistry</h3>
        <p>Stone-specific pads, calibrated machines, and pro-grade solutions for safe, lasting results.</p>
      </div>
      <div class="ssi-tile">
        <h3>Trained &amp; Supervised Teams</h3>
        <p>Briefed on scope, checklists, PPE, and care for furniture, edges, and finishes.</p>
      </div>
      <div class="ssi-tile">
        <h3>On-time &amp; Transparent</h3>
        <p>Slot confirmation, on-site assessment, and crystal-clear estimates. No surprises.</p>
      </div>
      <div class="ssi-tile">
        <h3>After-Care &amp; Support</h3>
        <p>Post-service QC, care tips, and digital invoices for easy records.</p>
      </div>
    </div>
  </div>

  <!-- Process + KPIs -->
  <div class="container ssi-home__process">
    <div class="ssi-steps">
      <div class="ssi-step"><strong>1) Book</strong><span>Pick a service &amp; slot — share photos if possible.</span></div>
      <div class="ssi-step"><strong>2) Inspect</strong><span>On-site scope & chemistry confirmation before start.</span></div>
      <div class="ssi-step"><strong>3) Service</strong><span>Machines + trained staff deliver defined outcomes.</span></div>
      <div class="ssi-step"><strong>4) QC &amp; Handover</strong><span>Final check with you, cleanup, and after-care tips.</span></div>
    </div>
    <div class="ssi-kpis">
      <div class="ssi-kpi"><b>4.3★</b><span>Avg. directory rating</span></div>
      <div class="ssi-kpi"><b>2006</b><span>Operational since</span></div>
      <div class="ssi-kpi"><b>10+</b><span>Service categories</span></div>
      <div class="ssi-kpi"><b>Delhi NCR</b><span>South/West Delhi &amp; Gurugram belt</span></div>
    </div>
  </div>

  <!-- Pricing snapshots (illustrative ranges; you can tune figures) -->
  <div class="container ssi-home__pricing">
    <h2>Pricing Snapshots</h2>
    <table class="ssi-table" aria-label="Indicative pricing">
      <thead>
        <tr>
          <th>Service</th>
          <th>Unit</th>
          <th>Typical Range</th>
          <th>Notes</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Blinds Installation</td>
          <td>per sq.ft.</td>
          <td>₹75 – ₹300+</td>
          <td>Depends on size, material and cartridge selection</td>
        </tr>
        <tr>
          <td>Marble Floor Polishing / Crystallization</td>
          <td>per sq.ft.</td>
          <td>₹25 – ₹60</td>
          <td>Depends on stone condition &amp; finish level</td>
        </tr>
        <tr>
          <td>Sofa Shampooing & Cleaning</td>
          <td>per seat</td>
          <td>₹180 – ₹350+</td>
          <td>Fabric type &amp; stain level</td>
        </tr>
        <tr>
          <td>Wallpaper Installation</td>
          <td>per roll</td>
          <td>₹1200 – ₹2000+</td>
          <td>Pattern match &amp; wall prep</td>
        </tr>
        <tr>
          <td>Curtain Fitting</td>
          <td>per panel</td>
          <td>₹800 – ₹2000+</td>
          <td>per square meter</td>
        </tr>
        <tr>
          <td>Carpet Shampooing & Cleaning</td>
          <td>per sq. ft.</td>
          <td>₹3 - ₹10+</td>
          <td>per square foot</td>
        </tr>
      </tbody>
    </table>
    <p class="ssi-note">Final quote is confirmed after on-site inspection. Consumables &amp; machines included; power &amp; water access to be provided by client.</p>
  </div>

  <!-- Areas we serve -->
  <div class="container ssi-home__areas">
    <h2>Areas We Serve</h2>
    <div class="ssi-tags">
      <span class="tag">Sultanpur</span><span class="tag">MG Road</span><span class="tag">Ghitorni</span><span class="tag">Gadaipur</span>
      <span class="tag">Andheria Mor</span><span class="tag">Fatehpur Beri</span><span class="tag">DLF Farms</span><span class="tag">Chhatarpur Extn.</span>
      <span class="tag">Vasant Kunj</span><span class="tag">Bhawani Kunj</span><span class="tag">New Manglapuri</span><span class="tag">Gurugram Belt</span>
    </div>
  </div>

  <!-- Before/After -->
  <div class="container ssi-home__ba">
    <h2>Before &amp; After</h2>
    <div class="ssi-ba-grid">
      <figure class="ssi-ba"><span>Before</span><img src="/assets/img/sun-services/ba-marble-before.jpg" alt="Before: Dull marble floor with etch marks" loading="lazy" width="500" height="333"></figure>
      <figure class="ssi-ba"><span>After</span><img src="/assets/img/sun-services/ba-marble-after.jpg" alt="After: High-gloss marble floor after crystallization" loading="lazy" width="500" height="333"></figure>
      <figure class="ssi-ba"><span>Before</span><img src="/assets/img/sun-services/ba-sofa-before.jpg" alt="Before: Stained sofa upholstery" loading="lazy" width="500" height="333"></figure>
      <figure class="ssi-ba"><span>After</span><img src="/assets/img/sun-services/ba-sofa-after.jpg" alt="After: Clean, refreshed sofa upholstery" loading="lazy" width="500" height="333"></figure>
    </div>
  </div>

  <!-- Equipment & Chemistry -->
  <div class="container ssi-home__equip">
    <h2>Equipment &amp; Chemistry We Use</h2>
    <ul class="ssi-list">
      <li>Single-disc floor machines with graded pads (honing to crystallization)</li>
      <li>Wet &amp; dry vacuum extractors and upholstery injectors</li>
      <li>Alkaline/neutral cleaners, descalers, and safe stone crystallizers</li>
      <li>Microfibers, edge protectors, masking for skirtings &amp; furniture</li>
      <li>Personal Protective Equipment (PPE) for crew safety</li>
      <li>Consumables included; MSDS available on request</li>
    </ul>
  </div>

  <!-- Testimonials (placeholders; replace with real quotes if available) -->
  <div class="container ssi-home__testi">
    <h2>What Customers Say</h2>
    <div class="ssi-testis">
      <div class="ssi-quote">
        <p>“Marble floors look brand new. Team was punctual and careful with furniture.”</p><small>— Homeowner, Vasant Kunj</small>
      </div>
      <div class="ssi-quote">
        <p>“Office deep cleaning finished in one day. Transparent scope and fair pricing.”</p><small>— Office Admin, Chhatarpur</small>
      </div>
      <div class="ssi-quote">
        <p>“Sofa shampoo removed old stains. Will call again before Diwali.”</p><small>— Resident, MG Road</small>
      </div>
    </div>
  </div>

  <!-- Final CTA -->
  <div class="container ssi-home__cta">
    <div class="ssi-home__cta-inner">
      <div>
        <h3>Ready to schedule a visit?</h3>
        <p class="sr-only">Tap the button to request service.</p>
      </div>
      <div>
        <button class="ssi-btn ssi-btn--primary open-enquiry" type="button" data-service="General Enquiry">Request Service</button>
      </div>
    </div>
    <img src="/assets/img/sun-services/hero-team-01.jpg" alt="" aria-hidden="true">
  </div>

  <!-- FAQs -->
  <div class="container ssi-home__faq">
    <h2>FAQs</h2>
    <details>
      <summary>What’s included in deep home cleaning?</summary>
      <p>Complete kitchen &amp; bathroom detailing, dusting, degreasing, vacuuming, floor scrubbing, high-touch disinfection; add-ons include sofa/mattress, balcony/glass, and appliances.</p>
    </details>
    <details>
      <summary>How do you polish marble floors safely?</summary>
      <p>Assessment → grinding/honing (if needed) → crystallization or polish → sealant → final cleanup. Stone-specific chemistry and pads; edges and furniture are protected.</p>
    </details>
    <details>
      <summary>Do you bring machines and consumables?</summary>
      <p>Yes. Machines, pads/brushes, pro-grade chemistry, microfiber sets, and PPE. We require power and water access on site.</p>
    </details>
    <details>
      <summary>Can I get a same-week slot?</summary>
      <p>Usually yes. Weekends fill quickly — book early during festival season.</p>
    </details>
    <details>
      <summary>Do you provide housekeeping staff?</summary>
      <p>Yes, for offices/hotels/hospitals. Share shift, headcount, and scope for a tailored quote.</p>
    </details>
  </div>
</section>

<!-- Build service cards by mirroring your existing service links (fallback-safe) -->
<script>
  (function() {
    var grid = document.getElementById('ssiServiceCards');
    if (!grid) return;
    // Prevent duplicating server-rendered cards
    if (grid.children && grid.children.length) return;
    // Try to locate an existing services block to mirror links from
    var legacy = document.querySelector('.section-columns, .services-list, .services, #services, main .links, nav .services');
    var links = legacy ? legacy.querySelectorAll('a[href]') : [];
    if (links.length === 0) {
      // Nothing to mirror; create a minimal featured set so the section is not empty
      var featured = [{
          t: 'Marble Floor Polishing',
          h: '#'
        },
        {
          t: 'Deep Home Cleaning',
          h: '#'
        },
        {
          t: 'Sofa & Upholstery Cleaning',
          h: '#'
        },
        {
          t: 'Bathroom Deep Cleaning',
          h: '#'
        },
        {
          t: 'Window & Façade Cleaning',
          h: '#'
        },
        {
          t: 'Wallpaper Installation',
          h: '#'
        }
      ];
      featured.forEach(function(it, i) {
        addCard(it.t, it.h, i + 1);
      });
    } else {
      links.forEach(function(a, i) {
        var text = (a.textContent || a.innerText || '').trim();
        var href = a.getAttribute('href');
        addCard(text, href, i + 1);
      });
    }

    function addCard(text, href, idx) {
      var n = String(idx).padStart(2, '0');
      var card = document.createElement('a');
      card.className = 'ssi-card';
      card.href = href;
      card.setAttribute('aria-label', text);
      card.innerHTML =
        '<figure class="ssi-card__media">' +
        '<img src="/assets/img/sun-services/service-' + n + '.jpg" alt="' + text + ' — Sun Services Inc" loading="lazy" width="480" height="320">' +
        '</figure>' +
        '<div class="ssi-card__body">' +
        '<h3>' + text + '</h3>' +
        '<p>' + text + ' by trained professionals in Delhi NCR. Book a visit today.</p>' +
        '</div>';
      grid.appendChild(card);
    }
  })();
</script>

<!-- Schema for LocalBusiness + FAQ + key Services -->
<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "LocalBusiness",
    "@id": "/#sunservices",
    "name": "Sun Services Inc",
    "url": "/",
    "areaServed": {
      "@type": "AdministrativeArea",
      "name": "Delhi NCR"
    },
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "Sultanpur, M.G. Road",
      "addressLocality": "New Delhi",
      "postalCode": "110030",
      "addressCountry": "IN"
    },
    "description": "Cleaning, marble floor polishing, sofa shampooing, blinds & wallpaper installation, and facility housekeeping across Delhi NCR.",
    "priceRange": "₹₹",
    "sameAs": []
  }
</script>
<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [{
        "@type": "Question",
        "name": "What’s included in deep home cleaning?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Complete kitchen & bathroom detailing, dusting, degreasing, vacuuming, floor scrubbing, high-touch disinfection; add-ons include sofa/mattress, balcony/glass, and appliances."
        }
      },
      {
        "@type": "Question",
        "name": "How do you polish marble floors safely?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Assessment -> grinding/honing (if needed) -> crystallization or polish -> sealant -> final cleanup. Stone-specific chemistry and pads; edges and furniture are protected."
        }
      },
      {
        "@type": "Question",
        "name": "Do you bring machines and consumables?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Yes. Machines, pads/brushes, pro-grade chemistry, microfiber sets, and PPE. We require power and water access on site."
        }
      },
      {
        "@type": "Question",
        "name": "Can I get a same-week slot?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Usually yes. Weekends fill quickly—book early during festival season."
        }
      },
      {
        "@type": "Question",
        "name": "Do you provide housekeeping staff?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Yes, for offices/hotels/hospitals. Share shift, headcount, and scope for a tailored quote."
        }
      }
    ]
  }
</script>
<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "ItemList",
    "name": "Top Services",
    "itemListElement": [{
        "@type": "Service",
        "name": "Marble Floor Polishing"
      },
      {
        "@type": "Service",
        "name": "Deep Home Cleaning"
      },
      {
        "@type": "Service",
        "name": "Sofa & Upholstery Cleaning"
      },
      {
        "@type": "Service",
        "name": "Bathroom Deep Cleaning"
      },
      {
        "@type": "Service",
        "name": "Window & Façade Cleaning"
      },
      {
        "@type": "Service",
        "name": "Wallpaper Installation"
      },
      {
        "@type": "Service",
        "name": "Window Blinds Installation"
      },
      {
        "@type": "Service",
        "name": "Curtain Rod Installation"
      },
      {
        "@type": "Service",
        "name": "Office Housekeeping"
      },
      {
        "@type": "Service",
        "name": "PVC/Vinyl & Wooden Floor Care"
      }
    ]
  }
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
