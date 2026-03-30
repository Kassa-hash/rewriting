// Lazy Loading for Images with WebP support
document.addEventListener('DOMContentLoaded', function() {
	// Check WebP support
	const webpSupport = (() => {
		const canvas = document.createElement('canvas');
		canvas.width = canvas.height = 1;
		return canvas.toDataURL('image/webp').indexOf('image/webp') === 5;
	})();

	// Convert existing src to data-src for lazy loading
	const allImages = document.querySelectorAll('img');
	allImages.forEach(img => {
		// Skip if already has data-src
		if (!img.dataset.src && img.src) {
			img.dataset.src = img.src;
			img.src = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'; // Thin 1x1 transparent GIF
		}
	});

	// Create Intersection Observer for lazy loading
	const imageObserver = new IntersectionObserver((entries, observer) => {
		entries.forEach(entry => {
			if (entry.isIntersecting) {
				const img = entry.target;
				
				// Try to load WebP version if supported and available
				if (webpSupport && img.dataset.webp) {
					img.srcset = img.dataset.webp;
				} else if (img.dataset.src) {
					img.src = img.dataset.src;
				}
				
				if (img.dataset.srcset) {
					img.srcset = img.dataset.srcset;
				}
				
				img.classList.add('loaded');
				observer.unobserve(img);
			}
		});
	}, {
		rootMargin: '50px 0px',
		threshold: 0.01
	});

	// Observe all images for lazy loading
	document.querySelectorAll('img').forEach(img => {
		imageObserver.observe(img);
	});

	// Fallback for browsers without IntersectionObserver
	if (typeof IntersectionObserver === 'undefined') {
		document.querySelectorAll('img[data-src]').forEach(img => {
			img.src = img.dataset.src;
		});
	}
});

// Add CSS for image transitions
if (!document.getElementById('lazy-load-css')) {
	const style = document.createElement('style');
	style.id = 'lazy-load-css';
	style.textContent = `
		img[data-src] {
			opacity: 0;
			transition: opacity 0.3s ease-in-out;
		}
		img[data-src].loaded {
			opacity: 1;
		}
	`;
	document.head.appendChild(style);
}
