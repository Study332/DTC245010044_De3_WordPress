(() => {
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const header = document.querySelector('.site-header');
  const root = document.documentElement;

  if (header) {
    let scrollFrame = 0;
    const updateScrollState = () => {
      scrollFrame = 0;
      header.classList.toggle('is-scrolled', window.scrollY > 12);
      const scrollableDistance = root.scrollHeight - window.innerHeight;
      const progress = scrollableDistance > 0 ? Math.min(100, (window.scrollY / scrollableDistance) * 100) : 0;
      root.style.setProperty('--scroll-progress', `${progress}%`);
    };
    const requestScrollUpdate = () => {
      if (!scrollFrame) scrollFrame = window.requestAnimationFrame(updateScrollState);
    };
    window.addEventListener('scroll', requestScrollUpdate, { passive: true });
    window.addEventListener('resize', requestScrollUpdate, { passive: true });
    updateScrollState();
  }

  if (!reduceMotion) {
    const hero = document.querySelector('.hero-visual');
    if (hero && window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
      const layers = [
        [hero.querySelector('.hero-sun'), 3],
        [hero.querySelector('.hero-leaf'), -5],
        [hero.querySelector('.hero-pouch'), 9],
        [hero.querySelector('.hero-sticker'), 14],
      ].filter(([element]) => element);

      hero.addEventListener('pointermove', (event) => {
        const bounds = hero.getBoundingClientRect();
        const horizontal = (event.clientX - bounds.left) / bounds.width - 0.5;
        const vertical = (event.clientY - bounds.top) / bounds.height - 0.5;
        layers.forEach(([element, depth]) => {
          element.style.setProperty('--parallax-x', `${(horizontal * depth).toFixed(1)}px`);
          element.style.setProperty('--parallax-y', `${(vertical * depth).toFixed(1)}px`);
        });
      }, { passive: true });

      hero.addEventListener('pointerleave', () => {
        layers.forEach(([element]) => {
          element.style.setProperty('--parallax-x', '0px');
          element.style.setProperty('--parallax-y', '0px');
        });
      }, { passive: true });
    }
  }

  if (reduceMotion) return;

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

  if (!targets.length) return;
  if (!('IntersectionObserver' in window)) {
    targets.forEach((element) => element.classList.add('is-visible'));
    return;
  }

  root.classList.add('motion-ready');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) return;
      entry.target.classList.add('is-visible');
      observer.unobserve(entry.target);
    });
  }, { threshold: 0.14, rootMargin: '0px 0px -6% 0px' });

  targets.forEach((element) => observer.observe(element));
})();
