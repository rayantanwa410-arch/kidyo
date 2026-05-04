
console.log('app.js loaded');
// Count-up animation for the impact numbers
document.addEventListener('DOMContentLoaded', function () {
  const counters = document.querySelectorAll('.px[data-target]');
  const options = { root: null, rootMargin: '0px', threshold: 0.3 };

  function animateCount(el, target) {
    const duration = parseInt(el.dataset.duration, 10) || 1500; // ms
    const easingName = el.dataset.easing || 'linear';
    const start = performance.now();

    function getEasing(name) {
      switch (name) {
        case 'easeOutCubic':
          return (t) => 1 - Math.pow(1 - t, 3);
        case 'easeOutQuad':
          return (t) => 1 - (1 - t) * (1 - t);
        case 'linear':
        default:
          return (t) => t;
      }
    }

    const ease = getEasing(easingName);

    function step(now) {
      const progress = Math.min((now - start) / duration, 1);
      const eased = ease(progress);
      const value = Math.floor(eased * target);
      let text = value.toLocaleString();
      if (el.dataset.plus === 'true') text += '+';
      el.textContent = text;
      if (progress < 1) requestAnimationFrame(step);
      else {
        let finalText = target.toLocaleString();
        if (el.dataset.plus === 'true') finalText += '+';
        el.textContent = finalText;
      }
    }

    requestAnimationFrame(step);
  }

  const observer = new IntersectionObserver((entries, obs) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const el = entry.target;
        const target = parseInt(el.getAttribute('data-target'), 10) || 0;
        animateCount(el, target);
        obs.unobserve(el);
      }
    });
  }, options);

  counters.forEach((c) => observer.observe(c));
});