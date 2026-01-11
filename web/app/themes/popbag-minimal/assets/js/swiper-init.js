/* global Swiper */

(() => {
  function initSwipers() {
    const blocks = document.querySelectorAll('[data-popbag-swiper]');
    if (!blocks.length) return;
    if (typeof Swiper === 'undefined') return;

    blocks.forEach((block) => {
      const el = block.querySelector('.swiper');
      if (!el) return;

      // Prevent double-init.
      if (el.dataset.popbagSwiperInited) return;
      el.dataset.popbagSwiperInited = '1';

      const prevEl = block.querySelector('[data-popbag-swiper-prev]');
      const nextEl = block.querySelector('[data-popbag-swiper-next]');

      new Swiper(el, {
        slidesPerView: 1.15,
        spaceBetween: 18,
        watchOverflow: true,
        navigation: prevEl && nextEl ? { prevEl, nextEl } : undefined,
        breakpoints: {
          640: { slidesPerView: 2.15, spaceBetween: 20 },
          1024: { slidesPerView: 3.15, spaceBetween: 24 },
        },
      });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSwipers);
  } else {
    initSwipers();
  }
})();

(() => {
  const swipers = document.querySelectorAll('[data-popbag-swiper]');
  if (!swipers.length) return;
  if (typeof window.Swiper === 'undefined') return;

  swipers.forEach((root) => {
    const swiperEl = root.querySelector('.swiper');
    if (!swiperEl) return;

    const nextEl = root.querySelector('[data-popbag-swiper-next]');
    const prevEl = root.querySelector('[data-popbag-swiper-prev]');

    // eslint-disable-next-line no-new
    new window.Swiper(swiperEl, {
      slidesPerView: 1.15,
      spaceBetween: 16,
      centeredSlides: false,
      navigation: nextEl && prevEl ? { nextEl, prevEl } : undefined,
      breakpoints: {
        640: { slidesPerView: 2.15, spaceBetween: 20 },
        1024: { slidesPerView: 3.15, spaceBetween: 24 },
      },
    });
  });
})();


