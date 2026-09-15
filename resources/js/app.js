import './bootstrap';
import { initScene } from './three-scene';

document.addEventListener('DOMContentLoaded', function () {
    initScene();

    const preloader = document.getElementById('preloader');
    if (preloader) {
        const bar = preloader.querySelector('.preloader-bar');
        let progress = 0;
        const interval = setInterval(function () {
            progress += Math.random() * 15 + 5;
            if (progress >= 100) {
                progress = 100;
                clearInterval(interval);
                preloader.classList.add('hidden');
                document.body.style.overflow = '';
                setTimeout(function () {
                    preloader.style.display = 'none';
                }, 800);
            }
            if (bar) bar.style.width = progress + '%';
        }, 200);
    }

    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });
    }

    const heroTitle = document.querySelector('.hero-title');
    const heroSubtitle = document.querySelector('.hero-subtitle');
    const heroCta = document.querySelector('.hero-cta');
    const heroBadge = document.querySelector('.hero-badge');
    const heroStats = document.querySelector('.hero-stats');
    const pageHeaderTitle = document.querySelector('.page-header-title');
    const pageHeaderSubtitle = document.querySelector('.page-header-subtitle');
    const statsValues = document.querySelectorAll('.counter-value');
    const aboutGallery = document.getElementById('aboutGallery');
    const ctaTitle = document.querySelector('.cta-title');
    const formCard = document.querySelector('.form-card');
    const contactInfoItems = document.querySelectorAll('.contact-info-item');

    if (typeof gsap !== 'undefined') {
        if (heroTitle) {
            const chars = heroTitle.textContent.split('');
            heroTitle.innerHTML = '';
            chars.forEach(function (char) {
                const span = document.createElement('span');
                span.textContent = char === ' ' ? '\u00A0' : char;
                span.className = 'char';
                heroTitle.appendChild(span);
            });
            gsap.to('.hero-title .char', {
                opacity: 1,
                y: 0,
                duration: 0.05,
                stagger: 0.03,
                ease: 'power2.out',
                delay: 0.5,
            });
        }

        if (heroSubtitle) {
            gsap.to(heroSubtitle, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                delay: 1.0,
                ease: 'power3.out',
            });
        }

        if (heroCta) {
            gsap.to(heroCta, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                delay: 1.4,
                ease: 'power3.out',
            });
        }

        if (heroBadge) {
            gsap.to(heroBadge, {
                opacity: 1,
                y: 0,
                duration: 0.6,
                delay: 0.2,
                ease: 'power3.out',
            });
        }

        if (heroStats) {
            gsap.to(heroStats, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                delay: 1.8,
                ease: 'power3.out',
            });
        }

        if (pageHeaderTitle) {
            const chars = pageHeaderTitle.textContent.split('');
            pageHeaderTitle.innerHTML = '';
            chars.forEach(function (char) {
                const span = document.createElement('span');
                span.textContent = char === ' ' ? '\u00A0' : char;
                span.className = 'char';
                pageHeaderTitle.appendChild(span);
            });
            gsap.to('.page-header-title .char', {
                opacity: 1,
                y: 0,
                duration: 0.05,
                stagger: 0.03,
                ease: 'power2.out',
                delay: 0.3,
            });
        }

        if (pageHeaderSubtitle) {
            gsap.to(pageHeaderSubtitle, {
                opacity: 1,
                y: 0,
                duration: 0.6,
                delay: 0.8,
                ease: 'power3.out',
            });
        }

        if (formCard) {
            ScrollTrigger.create({
                trigger: formCard,
                start: 'top 85%',
                onEnter: function () {
                    gsap.to(formCard, {
                        opacity: 1,
                        y: 0,
                        duration: 0.8,
                        ease: 'power3.out',
                    });
                },
            });
        }

        contactInfoItems.forEach(function (item, i) {
            ScrollTrigger.create({
                trigger: item,
                start: 'top 85%',
                onEnter: function () {
                    gsap.to(item, {
                        opacity: 1,
                        x: 0,
                        duration: 0.6,
                        delay: i * 0.15,
                        ease: 'power3.out',
                    });
                },
            });
        });
    }

    if (statsValues.length) {
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const text = el.textContent;
                    const isPercent = text.includes('%');
                    const isPlus = text.includes('+');
                    const target = parseInt(text.replace(/[^0-9]/g, ''));

                    if (isNaN(target)) return;

                    let current = 0;
                    const duration = 2000;
                    const startTime = performance.now();

                    function update(currentTime) {
                        const elapsed = currentTime - startTime;
                        const progress = Math.min(elapsed / duration, 1);
                        const eased = 1 - Math.pow(1 - progress, 3);
                        current = Math.floor(eased * target);
                        el.textContent = current + (isPercent ? '%' : isPlus ? '+' : '');
                        if (progress < 1) {
                            requestAnimationFrame(update);
                        } else {
                            el.textContent = text;
                        }
                    }
                    requestAnimationFrame(update);
                    observer.unobserve(el);
                }
            });
        }, { threshold: 0.5 });

        statsValues.forEach(function (el) { observer.observe(el); });
    }

    if (aboutGallery) {
        const slides = aboutGallery.querySelectorAll('.about-gallery-slide');
        const badge = aboutGallery.querySelector('.about-badge');
        let currentSlide = 0;

        if (badge) {
            if (typeof gsap !== 'undefined') {
                gsap.to(badge, { opacity: 1, scale: 1, duration: 0.6, delay: 1.5, ease: 'back.out(1.7)' });
            } else {
                badge.style.opacity = '1';
                badge.style.transform = 'rotate(-10deg) scale(1)';
            }
        }

        if (slides.length > 1) {
            setInterval(function () {
                slides.forEach(function (s) { s.classList.remove('active', 'active-zoom'); });
                currentSlide = (currentSlide + 1) % slides.length;
                slides[currentSlide].classList.add('active');
                setTimeout(function () { slides[currentSlide].classList.add('active-zoom'); }, 100);
            }, 4000);
        }
    }

    const tiltCards = document.querySelectorAll('.tilt-card');
    tiltCards.forEach(function (card) {
        card.addEventListener('mousemove', function (e) {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = (y - centerY) / centerY * -8;
            const rotateY = (x - centerX) / centerX * 8;
            card.style.transform = 'perspective(1200px) rotateX(' + rotateX + 'deg) rotateY(' + rotateY + 'deg) scale3d(1.02,1.02,1.02)';
        });

        card.addEventListener('mouseleave', function () {
            card.style.transform = 'perspective(1200px) rotateX(0deg) rotateY(0deg) scale3d(1,1,1)';
        });
    });
});
