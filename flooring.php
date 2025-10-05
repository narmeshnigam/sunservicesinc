<?php
// Include header
include 'header.php';
?>

<!-- Landing Page: Flooring Services -->
<div class="container" style="max-width:900px; margin:auto; padding:40px 20px;">
    <section style="text-align:center; margin-bottom:40px;">
        <h1>Flooring Services</h1>
        <p>Transform your space with our expert flooring solutions. Choose from laminate, wooden, carpet, and PVC carpet flooring for homes and businesses.</p>
        <a href="#contact" class="btn btn-primary" style="margin-top:20px;">Get a Free Quote</a>
    </section>

    <section style="margin-bottom:40px;">
        <h2>Our Flooring Types</h2>
        <div style="display:flex; flex-wrap:wrap; gap:30px; justify-content:space-between;">
            <div style="flex:1; min-width:220px; background:#f8f8f8; padding:20px; border-radius:8px;">
                <h3>Laminate Flooring</h3>
                <p>Durable, easy to maintain, and available in a variety of styles.</p>
                <strong>Starting at $3.50/sq.ft</strong>
                <br>
                <a href="#contact" class="btn btn-outline-primary" style="margin-top:10px;">Book Laminate</a>
            </div>
            <div style="flex:1; min-width:220px; background:#f8f8f8; padding:20px; border-radius:8px;">
                <h3>Wooden Flooring</h3>
                <p>Classic elegance with premium hardwood options for lasting beauty.</p>
                <strong>Starting at $7.00/sq.ft</strong>
                <br>
                <a href="#contact" class="btn btn-outline-primary" style="margin-top:10px;">Book Wooden</a>
            </div>
            <div style="flex:1; min-width:220px; background:#f8f8f8; padding:20px; border-radius:8px;">
                <h3>Carpet Flooring</h3>
                <p>Soft, comfortable, and available in various colors and textures.</p>
                <strong>Starting at $2.50/sq.ft</strong>
                <br>
                <a href="#contact" class="btn btn-outline-primary" style="margin-top:10px;">Book Carpet</a>
            </div>
            <div style="flex:1; min-width:220px; background:#f8f8f8; padding:20px; border-radius:8px;">
                <h3>PVC Carpet Flooring</h3>
                <p>Water-resistant, affordable, and ideal for high-traffic areas.</p>
                <strong>Starting at $2.00/sq.ft</strong>
                <br>
                <a href="#contact" class="btn btn-outline-primary" style="margin-top:10px;">Book PVC Carpet</a>
            </div>
        </div>
    </section>

    <section style="margin-bottom:40px;">
        <h2>Why Choose Us?</h2>
        <ul style="list-style:disc; padding-left:20px;">
            <li>Professional installation by certified experts</li>
            <li>Wide range of flooring options</li>
            <li>Competitive pricing and transparent quotes</li>
            <li>Warranty on materials and workmanship</li>
            <li>Fast turnaround and flexible scheduling</li>
        </ul>
    </section>

    <section id="contact" style="background:#eef6fa; padding:30px; border-radius:8px;">
        <h2>Request a Free Estimate</h2>
        <form method="post" action="contact_submit.php">
            <div style="margin-bottom:15px;">
                <input type="text" name="name" placeholder="Your Name" required style="width:100%; padding:10px;">
            </div>
            <div style="margin-bottom:15px;">
                <input type="email" name="email" placeholder="Your Email" required style="width:100%; padding:10px;">
            </div>
            <div style="margin-bottom:15px;">
                <input type="text" name="phone" placeholder="Phone Number" required style="width:100%; padding:10px;">
            </div>
            <div style="margin-bottom:15px;">
                <select name="flooring_type" required style="width:100%; padding:10px;">
                    <option value="">Select Flooring Type</option>
                    <option value="Laminate">Laminate</option>
                    <option value="Wooden">Wooden</option>
                    <option value="Carpet">Carpet</option>
                    <option value="PVC Carpet">PVC Carpet</option>
                </select>
            </div>
            <div style="margin-bottom:15px;">
                <textarea name="details" placeholder="Project Details" rows="3" style="width:100%; padding:10px;"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Request Quote</button>
        </form>
    </section>
</div>

<?php
// Include footer
include 'footer.php';
?>