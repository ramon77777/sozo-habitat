import './property-media-upload';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('catalogFilters', (hasActiveFilters = false) => ({
    open: hasActiveFilters || window.innerWidth >= 768,

    init() {
        this.handleResize = () => {
            if (window.innerWidth >= 768) {
                this.open = true;
            }
        };

        window.addEventListener('resize', this.handleResize, { passive: true });
    },

    toggle() {
        if (window.innerWidth < 768) {
            this.open = !this.open;
        }
    },
}));

Alpine.start();

const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

const initRevealAnimations = () => {
    const items = document.querySelectorAll('[data-reveal]');

    if (!items.length) {
        return;
    }

    if (prefersReducedMotion || !('IntersectionObserver' in window)) {
        items.forEach((item) => item.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries, instance) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                const delay = Number(entry.target.dataset.revealDelay || 0);
                entry.target.style.setProperty('--reveal-delay', `${delay}ms`);
                entry.target.classList.add('is-visible');
                instance.unobserve(entry.target);
            });
        },
        {
            threshold: 0.14,
            rootMargin: '0px 0px -7% 0px',
        }
    );

    items.forEach((item) => observer.observe(item));
};

const initHeroParallax = () => {
    const layer = document.querySelector('[data-hero-parallax]');

    if (!layer || prefersReducedMotion || window.matchMedia('(max-width: 767px)').matches) {
        return;
    }

    let ticking = false;

    const update = () => {
        const scrollY = window.scrollY;
        const offset = Math.min(scrollY * 0.08, 70);
        layer.style.transform = `translate3d(0, ${offset}px, 0) scale(1.04)`;
        ticking = false;
    };

    window.addEventListener(
        'scroll',
        () => {
            if (!ticking) {
                window.requestAnimationFrame(update);
                ticking = true;
            }
        },
        { passive: true }
    );

    update();
};

const initPublicNav = () => {
    const nav = document.querySelector('[data-public-nav]');

    if (!nav) {
        return;
    }

    const update = () => {
        nav.classList.toggle('is-scrolled', window.scrollY > 36);
    };

    window.addEventListener('scroll', update, { passive: true });
    update();
};

const initSmoothAnchors = () => {
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener('click', (event) => {
            const targetId = anchor.getAttribute('href');

            if (!targetId || targetId === '#') {
                return;
            }

            const target = document.querySelector(targetId);

            if (!target) {
                return;
            }

            event.preventDefault();
            target.scrollIntoView({
                behavior: prefersReducedMotion ? 'auto' : 'smooth',
                block: 'start',
            });
        });
    });
};

const bootSozoExperience = () => {
    initRevealAnimations();
    initHeroParallax();
    initPublicNav();
    initSmoothAnchors();
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bootSozoExperience);
} else {
    bootSozoExperience();
}
