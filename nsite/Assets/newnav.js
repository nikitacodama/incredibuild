(function(){
  const nav      = document.querySelector('.nav');
  const burger   = nav.querySelector('.burger');
  const menu     = nav.querySelector('.menu');
  const closeBtn = menu.querySelector('.close-menu');
  const mqMobile = window.matchMedia('(max-width: 990px)');

  function setOpenDrawer(open){
    nav.classList.toggle('is-open', open);
    burger.setAttribute('aria-expanded', String(open));
    burger.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
    document.documentElement.style.overflow = open ? 'hidden' : '';
  }

  burger?.addEventListener('click', () => setOpenDrawer(!nav.classList.contains('is-open')));
  closeBtn?.addEventListener('click', () => setOpenDrawer(false));

  // Close on outside click (mobile)
  nav.addEventListener('click', (e) => {
    if(!nav.classList.contains('is-open')) return;
    const inside = menu.contains(e.target) || burger.contains(e.target);
    if(!inside) setOpenDrawer(false);
  });

  // ESC closes
  document.addEventListener('keydown', (e) => {
    if(e.key === 'Escape' && nav.classList.contains('is-open')) setOpenDrawer(false);
  });

  // Accordion toggle (mobile only) — event delegation
  function togglePanel(li){
    const panel   = li.querySelector(':scope > .subMenu');
    const toplink = li.querySelector(':scope > .toplink, :scope > a'); // supports button or anchor
    const toggler = li.querySelector(':scope > .sub-toggle');

    const isOpen = li.classList.toggle('open');

    // Close siblings
    menu.querySelectorAll('.has-sub.open').forEach(sib => {
      if (sib === li) return;
      sib.classList.remove('open');
      const p = sib.querySelector(':scope > .subMenu');
      if (p) p.style.maxHeight = 0;
      sib.querySelector(':scope > .toplink, :scope > a')?.setAttribute('aria-expanded','false');
      sib.querySelector(':scope > .sub-toggle')?.setAttribute('aria-expanded','false');
    });

    // Animate this panel
    if (panel){
      if (isOpen){
        panel.style.maxHeight = panel.scrollHeight + 'px';
      } else {
        panel.style.maxHeight = 0;
      }
    }
    toplink?.setAttribute('aria-expanded', String(isOpen));
    toggler?.setAttribute('aria-expanded', String(isOpen));
  }

  menu.addEventListener('click', (e) => {
    if (!mqMobile.matches) return; // only on mobile
    const trigger = e.target.closest(
      '.has-sub > .toplink, .has-sub > .sub-toggle, .has-sub > a:not(.nButton)'
    );
    if (!trigger) return;
    const li = trigger.closest('.has-sub');
    if (!li) return;
    e.preventDefault();
    e.stopPropagation();
    togglePanel(li);
  });

  // Cleanup when resizing to desktop
  window.addEventListener('resize', () => {
    if (!mqMobile.matches){
      menu.querySelectorAll('.has-sub.open').forEach(li => li.classList.remove('open'));
      menu.querySelectorAll('.has-sub > .subMenu').forEach(p => p.style.maxHeight = '');
    }
  });
})();