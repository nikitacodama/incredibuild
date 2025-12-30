(() => {
  // ──────────────────────────────────────────────────────────────
  // 1) Global helper: copy to clipboard (call via onclick="copyText()")
  // ──────────────────────────────────────────────────────────────
  window.copyText = function () {
    const input = document.getElementById("myInput");
    if (!input) return;

    input.select();
    input.setSelectionRange(0, 99999); // mobile

    navigator.clipboard.writeText(input.value)
      .then(() => alert("Text copied to clipboard!"))
      .catch(err => console.error("Failed to copy text:", err));
  };

  // ──────────────────────────────────────────────────────────────
  // 2) Vanilla: fade list items by viewport center + shrink divider
  // ──────────────────────────────────────────────────────────────
  function initScrollFade() {
    const SELECTORS = {
      list: ".hpblock ol",
      divider: ".divider > span"
    };
    const BASE_OPACITY = 0.3;
    const MAX_OPACITY  = 1.0;
    const FALLOFF      = 0.35;

    const list = document.querySelector(SELECTORS.list);
    if (!list) return;

    const items = Array.from(list.querySelectorAll("li"));
    const dividerSpan = document.querySelector(SELECTORS.divider);

    const clamp = (v, min = 0, max = 1) => Math.min(max, Math.max(min, v));

    let ticking = false;
    function onScrollOrResize() {
      if (!ticking) {
        ticking = true;
        requestAnimationFrame(update);
      }
    }

    function update() {
      ticking = false;

      const vh = window.innerHeight;
      const centerY = vh / 2;

      // 1) Fade each <li>
      items.forEach(li => {
        const r = li.getBoundingClientRect();
        const itemCenter = r.top + r.height / 2;
        const distance = Math.abs(itemCenter - centerY);
        const t = clamp(1 - distance / (vh * FALLOFF)); // 0..1
        const opacity = BASE_OPACITY + (MAX_OPACITY - BASE_OPACITY) * t;
        li.style.opacity = opacity.toFixed(3);
      });

      // 2) Shrink divider line
      if (dividerSpan) {
        const lr = list.getBoundingClientRect();
        const progress = clamp((centerY - lr.top) / lr.height, 0, 1);
        const scale = 1 - progress; // 1 → 0
        dividerSpan.style.transform = `scaleY(${scale})`;
      }
    }

    if (items.length) {
      if (dividerSpan) dividerSpan.style.transformOrigin = "bottom center";
      window.addEventListener("scroll", onScrollOrResize, { passive: true });
      window.addEventListener("resize", onScrollOrResize);
      update();
    }
  }

  // ──────────────────────────────────────────────────────────────
  // 3) Vanilla: randomly highlight N icons repeatedly
  // ──────────────────────────────────────────────────────────────
  function initIconRandomizer() {
    const MAX_ACTIVE = 6;      // how many icons to highlight at once
    const SWITCH_EVERY = 2500; // ms between switches

    const icons = Array.from(document.querySelectorAll(".hpblock .intIcons img"));
    if (!icons.length) return;

    let last = [];

    function pick(n) {
      const pool = icons.slice();
      for (let i = pool.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [pool[i], pool[j]] = [pool[j], pool[i]];
      }
      return pool.slice(0, Math.min(n, pool.length));
    }

    function tick() {
      last.forEach(el => el.classList.remove("is-active"));
      last.length = 0;

      const next = pick(MAX_ACTIVE);
      next.forEach(el => el.classList.add("is-active"));
      last = next;
    }

    tick();
    setInterval(tick, SWITCH_EVERY);
  }

  // ──────────────────────────────────────────────────────────────
  // 4) jQuery + OwlCarousel: init + custom next/prev buttons
  //    Safe for WP noConflict; runs only if jQuery & Owl exist.
  // ──────────────────────────────────────────────────────────────
  function initCarousel() {
    if (!(window.jQuery && jQuery.fn && jQuery.fn.owlCarousel)) {
      console.warn("[carousel] jQuery or OwlCarousel is missing.");
      return;
    }
    jQuery(function ($) {
      const $owl = $(".hpblock.gal .owl-carousel");
      if (!$owl.length) return;

      $owl.owlCarousel({
        loop: false,
        margin: 32,
        nav: false,
        dots: true,
        autoWidth: true,
        responsive: {
          600:  { items: 1 },
          1000: { items: 2 }
        }
      });

      $(".customNextBtn").on("click", function () {
        $owl.trigger("next.owl.carousel");
      });
      $(".customPrevBtn").on("click", function () {
        $owl.trigger("prev.owl.carousel", [300]);
      });
    });
  }

  // ──────────────────────────────────────────────────────────────
  // Boot
  // ──────────────────────────────────────────────────────────────
  document.addEventListener("DOMContentLoaded", () => {
    initScrollFade();
    initIconRandomizer();
  });
  // jQuery handles its own ready() internally
  initCarousel();
})();

