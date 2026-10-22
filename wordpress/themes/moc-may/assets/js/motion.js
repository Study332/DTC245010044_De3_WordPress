(() => {
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  const revealGroups = [
    ['.trust-item', 70],
    ['.section-heading', 0],
    ['.product-card', 110],
    ['.story-art, .story-copy', 100],
    ['.story-point', 75],
    ['.brew-copy, .brew-card', 100],
    ['.contact-inner', 0],
  ];
  const targets = [];

  revealGroups.forEach(([selector, delayStep]) => {
    document.querySelectorAll(selector).forEach((element, index) => {
      element.dataset.reveal = '';
      element.style.setProperty('--reveal-delay', `${Math.min(index, 3) * delayStep}ms`);
      targets.push(element);
    });
  });

  if (!targets.length || !('IntersectionObserver' in window)) return;

  document.documentElement.classList.add('motion-ready');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) return;
      entry.target.classList.add('is-visible');
      observer.unobserve(entry.target);
    });
  }, { threshold: 0.14, rootMargin: '0px 0px -6% 0px' });

  targets.forEach((element) => observer.observe(element));
})();
