/**
 * Teba Suci Suite — mobile menu and scroll-reveal animation.
 *
 * Content is fully visible without this script; it only adds behaviour.
 */
(function () {
	'use strict';

	var root = document.documentElement;

	/* Mobile menu ---------------------------------------------------------- */

	var toggle = document.querySelector('.menu-toggle');
	var nav = document.getElementById('site-navigation');

	if (toggle && nav) {
		var setOpen = function (open) {
			nav.classList.toggle('is-open', open);
			root.classList.toggle('menu-open', open);
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
			toggle.setAttribute('aria-label', open ? toggle.getAttribute('data-label-close') : toggle.getAttribute('data-label-open'));
		};

		toggle.addEventListener('click', function () {
			setOpen(!nav.classList.contains('is-open'));
		});

		// Close after choosing a link (most links scroll within the homepage).
		nav.addEventListener('click', function (event) {
			if (event.target.closest && event.target.closest('a')) {
				setOpen(false);
			}
		});

		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape' && nav.classList.contains('is-open')) {
				setOpen(false);
				toggle.focus();
			}
		});

		var desktop = window.matchMedia('(min-width: 761px)');
		var onChange = function (query) {
			if (query.matches) {
				setOpen(false);
			}
		};
		if (desktop.addEventListener) {
			desktop.addEventListener('change', onChange);
		} else if (desktop.addListener) {
			desktop.addListener(onChange);
		}
	}

	/* Scroll reveal -------------------------------------------------------- */

	var targets = document.querySelectorAll('[data-reveal]');
	var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	if (!targets.length || reducedMotion || !('IntersectionObserver' in window)) {
		return;
	}

	root.classList.add('reveal-ready');

	var observer = new IntersectionObserver(
		function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-visible');
					observer.unobserve(entry.target);
				}
			});
		},
		{ threshold: 0.14 }
	);

	Array.prototype.forEach.call(targets, function (target) {
		observer.observe(target);
	});
})();
