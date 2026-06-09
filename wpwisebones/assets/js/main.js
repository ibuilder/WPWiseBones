/**
 * WPWiseBones â€“ main.js
 */

(function () {
    'use strict';

    /* â”€â”€ Back to Top â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    const backToTop = document.getElementById('back-to-top');
    if (backToTop) {
        window.addEventListener('scroll', () => {
            backToTop.classList.toggle('visible', window.scrollY > 300);
        }, { passive: true });
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    /* â”€â”€ Active nav link highlighting â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    const currentPath = window.location.pathname;
    document.querySelectorAll('.main-navigation .nav-link').forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
            link.setAttribute('aria-current', 'page');
        }
    });

    /* â”€â”€ Countdown timers â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    document.querySelectorAll('.wpb-countdown[data-date]').forEach(el => {
        const target = new Date(el.dataset.date).getTime();
        const id     = el.id;
        if (!target || isNaN(target)) return;

        function tick() {
            const diff = target - Date.now();
            if (diff <= 0) {
                ['d','h','m','s'].forEach(u => {
                    const span = document.getElementById(id + '_' + u);
                    if (span) span.textContent = '00';
                });
                return;
            }
            const d = Math.floor(diff / 86400000);
            const h = Math.floor((diff % 86400000) / 3600000);
            const m = Math.floor((diff % 3600000) / 60000);
            const s = Math.floor((diff % 60000) / 1000);
            const pad = n => String(n).padStart(2, '0');
            document.getElementById(id + '_d').textContent = pad(d);
            document.getElementById(id + '_h').textContent = pad(h);
            document.getElementById(id + '_m').textContent = pad(m);
            document.getElementById(id + '_s').textContent = pad(s);
            setTimeout(tick, 1000);
        }
        tick();
    });

    /* â”€â”€ Bootstrap tooltips â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    if (typeof bootstrap !== 'undefined') {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
            new bootstrap.Tooltip(el);
        });

        /* â”€â”€ Bootstrap popovers â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        document.querySelectorAll('[data-bs-toggle="popover"]').forEach(el => {
            new bootstrap.Popover(el);
        });
    }

    /* â”€â”€ Search form toggle in navbar â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    const searchToggle = document.querySelector('.wpb-search-toggle');
    const searchForm   = document.querySelector('.wpb-header-search');
    if (searchToggle && searchForm) {
        searchToggle.addEventListener('click', e => {
            e.preventDefault();
            searchForm.classList.toggle('d-none');
            if (!searchForm.classList.contains('d-none')) {
                searchForm.querySelector('input[type="search"]')?.focus();
            }
        });
    }

    /* â”€â”€ Lazy-load images not handled by browser â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    if ('IntersectionObserver' in window) {
        const imgObserver = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                    }
                    imgObserver.unobserve(img);
                }
            });
        }, { rootMargin: '200px' });

        document.querySelectorAll('img[data-src]').forEach(img => imgObserver.observe(img));
    }

    /* â”€â”€ Smooth anchor scroll (for older browsers) â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const target = document.querySelector(a.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    /* â”€â”€ Table of contents (auto-generate) â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    const tocContainer = document.getElementById('wpb-toc');
    if (tocContainer) {
        const headings = document.querySelectorAll('.entry-content h2, .entry-content h3');
        if (headings.length > 2) {
            const ul = document.createElement('ul');
            ul.className = 'list-unstyled';
            headings.forEach((h, i) => {
                if (!h.id) h.id = 'toc-heading-' + i;
                const li = document.createElement('li');
                li.className = 'h3' === h.tagName.toLowerCase() ? 'ms-3' : '';
                li.innerHTML = '<a href="#' + h.id + '">' + h.textContent + '</a>';
                ul.appendChild(li);
            });
            tocContainer.appendChild(ul);
        } else {
            tocContainer.remove();
        }
    }

    /* â”€â”€ AJAX load more â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    const loadMoreBtn = document.getElementById('wpb-load-more');
    if (loadMoreBtn && typeof wpbData !== 'undefined') {
        let page = 2;
        loadMoreBtn.addEventListener('click', async () => {
            loadMoreBtn.disabled = true;
            loadMoreBtn.textContent = wpbData.i18n.loading;

            try {
                const res = await fetch(wpbData.ajaxUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        action:   'wpb_load_more',
                        nonce:    wpbData.nonce,
                        page:     page,
                        query:    loadMoreBtn.dataset.query || '',
                    }),
                });
                const data = await res.json();

                if (data.success && data.data.html) {
                    const grid = document.querySelector('.wpb-posts-grid');
                    if (grid) grid.insertAdjacentHTML('beforeend', data.data.html);
                    page++;
                    if (!data.data.has_more) loadMoreBtn.remove();
                    else {
                        loadMoreBtn.disabled = false;
                        loadMoreBtn.textContent = loadMoreBtn.dataset.label || 'Load More';
                    }
                } else {
                    loadMoreBtn.remove();
                }
            } catch (err) {
                loadMoreBtn.disabled = false;
                loadMoreBtn.textContent = wpbData.i18n.error;
                console.error('Load more error:', err);
            }
        });
    }


    /* ── Preloader fade-out ───────────────────────────────────── */
    window.addEventListener('load', function () {
        var p = document.getElementById('wpb-preloader');
        if (p) {
            p.classList.add('fade-out');
            setTimeout(function () { p.remove(); }, 450);
        }
    });
})();
