(() => {
  const toggle = document.querySelector('[data-popbag-menu-toggle]');
  const panel = document.querySelector('[data-popbag-menu-panel]');
  const backdrop = document.querySelector('[data-popbag-menu-backdrop]');

  if (!toggle || !panel) return;

  const open = () => {
    panel.classList.remove('hidden');
    backdrop?.classList.remove('hidden');
    toggle.setAttribute('aria-expanded', 'true');
    document.documentElement.classList.add('overflow-hidden');
  };

  const close = () => {
    panel.classList.add('hidden');
    backdrop?.classList.add('hidden');
    toggle.setAttribute('aria-expanded', 'false');
    document.documentElement.classList.remove('overflow-hidden');
  };

  toggle.addEventListener('click', () => {
    const isOpen = toggle.getAttribute('aria-expanded') === 'true';
    isOpen ? close() : open();
  });

  backdrop?.addEventListener('click', close);

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') close();
  });

  // Mobile sub-menu toggles (accordion).
  const bindSubmenuToggles = () => {
    const buttons = panel?.querySelectorAll('.popbag-submenu-toggle');
    if (!buttons || !buttons.length) return;

    buttons.forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();

        const li = btn.closest('li');
        if (!li) return;

        const isOpen = li.classList.toggle('is-open');
        btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      });
    });
  };

  bindSubmenuToggles();
})();



