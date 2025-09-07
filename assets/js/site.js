// site.js – main JavaScript for Sun Services Inc
document.addEventListener('DOMContentLoaded', () => {
    // Mobile nav toggle
    const navToggle = document.querySelector('.nav-toggle');
    const navList = document.querySelector('.nav-list');
    if (navToggle && navList) {
        navToggle.setAttribute('aria-expanded', 'false');
        navToggle.addEventListener('click', () => {
            const isOpen = navList.classList.toggle('open');
            navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    }

    // Lightbox logic
    const lightboxOverlay = document.getElementById('lightbox-overlay');
    const openButtons = document.querySelectorAll('.open-enquiry');
    const closeButton = document.querySelector('.lightbox-close');
    const enquiryForm = document.getElementById('enquiryForm');
    const serviceSelect = document.getElementById('service');
    const subServiceSelect = document.getElementById('sub_service');

    function openLightbox(event) {
        event.preventDefault();
        const btn = event.currentTarget;
        // Preselect service if provided
        if (btn.dataset.service && serviceSelect) {
            const service = btn.dataset.service;
            Array.from(serviceSelect.options).forEach(opt => {
                opt.selected = (opt.value === service);
            });
            populateSubServices(service);
        }
        lightboxOverlay.removeAttribute('hidden');
        lightboxOverlay.setAttribute('aria-hidden', 'false');
    }
    function closeLightbox() {
        lightboxOverlay.setAttribute('hidden', 'true');
        lightboxOverlay.setAttribute('aria-hidden', 'true');
    }
    openButtons.forEach(btn => {
        btn.addEventListener('click', openLightbox);
    });
    if (closeButton) {
        closeButton.addEventListener('click', closeLightbox);
    }
    // Close lightbox when clicking outside content
    if (lightboxOverlay) {
        lightboxOverlay.addEventListener('click', (e) => {
            // Close if click is on overlay area (not inside modal box)
            const clickedInsideContent = e.target.closest('.lightbox-content');
            if (!clickedInsideContent) {
                closeLightbox();
            }
        });
    }

    // Close on ESC key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' || e.key === 'Esc') {
            // Only act if overlay is currently open
            if (lightboxOverlay && !lightboxOverlay.hasAttribute('hidden')) {
                e.preventDefault();
                closeLightbox();
            }
        }
    });

    // Populate sub-services when service changes
    function populateSubServices(service) {
        if (!subServiceSelect) return;
        const map = window.ssServicesMap || {};
        const subs = map[service] || [];
        subServiceSelect.innerHTML = '<option value="">-- Select Sub‑Service --</option>';
        subs.forEach(sub => {
            const opt = document.createElement('option');
            opt.value = sub;
            opt.textContent = sub;
            subServiceSelect.appendChild(opt);
        });
    }
    if (serviceSelect) {
        serviceSelect.addEventListener('change', () => {
            populateSubServices(serviceSelect.value);
        });
        // On page load, populate sub-services if service was preselected
        populateSubServices(serviceSelect.value);
    }
    // Form client‑side validation (optional – relies on HTML5 attributes)
    if (enquiryForm) {
        enquiryForm.addEventListener('submit', (e) => {
            if (!enquiryForm.checkValidity()) {
                e.preventDefault();
                enquiryForm.reportValidity();
            }
        });
    }
});
