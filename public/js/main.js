const VAL = (() => {
  'use strict';

  async function request(url) {
    const response = await fetch(url, {
      headers: { 'Accept': 'application/json' },
      credentials: 'same-origin'
    });

    if (!response.ok) {
      throw new Error(`Request failed (${response.status})`);
    }

    return response.json();
  }

  function initComboTool() {
    const form = document.getElementById('combo-form');
    if (!form) return;

    const endpoint = form.dataset.endpoint;
    if (!endpoint) return;

    const result = document.getElementById('combo-result');
    const bhava = document.getElementById('bhava_id');
    const rashi = document.getElementById('rashi_id');
    const graha = document.getElementById('graha_id');

    function render(data) {
      if (!data || !data.found) {
        const message = data && data.pending
          ? 'यो संयोजनको फलदेश अहिले तयार हुँदैछ।'
          : 'यो संयोजनको विवरण उपलब्ध छैन।';
        result.innerHTML = `<p class="combo-empty">${message}</p>`;
        return;
      }

      const blocks = [
        ['सामान्य व्याख्या', data.interpretation_np],
        ['सकारात्मक प्रभाव', data.positive_effects],
        ['चुनौतीहरू', data.challenges],
        ['करियर', data.career_indication],
        ['वित्त', data.financial_indication],
        ['सम्बन्ध', data.relationship_indication],
        ['स्वास्थ्य', data.health_indication],
        ['आध्यात्मिक पक्ष', data.spiritual_indication],
        ['पारम्परिक व्याख्या', data.classical_interpretation],
        ['शास्त्रीय स्रोत', data.sanskrit_reference],
        ['उपाय', data.remedies]
      ];

      const title = data.title_np || `${data.graha_np} + ${data.target_np}`;

      const html = `
        <h2>${escapeHtml(title)}</h2>
        <p class="card-sanskrit">${escapeHtml(data.sanskrit_line || `${data.graha_sanskrit} in ${data.target_sanskrit}`)}</p>
        ${blocks
          .filter(([, body]) => body && String(body).trim() !== '')
          .map(([heading, body]) => `
            <div class="combo-section">
              <h3>${heading}</h3>
              <p>${escapeHtml(body)}</p>
            </div>
          `)
          .join('')}
      `;

      result.innerHTML = html;
    }

    form.addEventListener('submit', async (event) => {
      event.preventDefault();

      if (!bhava.value || !rashi.value || !graha.value) {
        result.innerHTML = '<p class="combo-empty">भाव, राशि र ग्रह चयन गर्नुहोस्।</p>';
        return;
      }

      const params = new URLSearchParams({
        action: 'combination',
        target_type: 'bhava_rashi',
        bhava_id: bhava.value,
        rashi_id: rashi.value,
        graha_id: graha.value
      });

      result.classList.add('loading');

      try {
        render(await request(`${endpoint}?${params.toString()}`));
      } catch (error) {
        result.innerHTML = '<p class="combo-empty">डाटा लोड गर्न असफल भयो।</p>';
        console.error(error);
      } finally {
        result.classList.remove('loading');
      }
    });
  }

  function escapeHtml(value) {
    return String(value ?? '').replace(/[&<>"']/g, (char) => ({
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#39;'
    })[char]);
  }

  function initNavbar() {
    const header = document.querySelector('.site-header');
    if (!header) return;

    const toggle = header.querySelector('.nav-toggle');

    const closeDrops = (except) => {
      header.querySelectorAll('.nav-item.open').forEach((item) => {
        if (item === except) return;
        item.classList.remove('open');
        const btn = item.querySelector('.drop-btn, .drop-trigger');
        if (btn) btn.setAttribute('aria-expanded', 'false');
      });
    };

    if (toggle) {
      toggle.addEventListener('click', () => {
        const open = header.classList.toggle('nav-open');
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        if (!open) closeDrops();
      });
    }

    header.querySelectorAll('.drop-btn, .drop-trigger').forEach((btn) => {
      btn.addEventListener('click', (event) => {
        event.preventDefault();
        const item = btn.closest('.nav-item');
        const willOpen = !item.classList.contains('open');
        closeDrops(item);
        item.classList.toggle('open', willOpen);
        btn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
      });
    });

    document.addEventListener('click', (event) => {
      if (!header.contains(event.target)) {
        closeDrops();
        header.classList.remove('nav-open');
        if (toggle) toggle.setAttribute('aria-expanded', 'false');
      }
    });

    document.addEventListener('keydown', (event) => {
      if (event.key !== 'Escape') return;
      closeDrops();
      header.classList.remove('nav-open');
      if (toggle) {
        toggle.setAttribute('aria-expanded', 'false');
        toggle.focus();
      }
    });

    window.addEventListener('resize', () => {
      if (window.innerWidth > 1120) {
        header.classList.remove('nav-open');
        if (toggle) toggle.setAttribute('aria-expanded', 'false');
      }
    });
  }

  function initTopicNav() {
    const nav = document.querySelector('.topic-nav');
    if (!nav) return;

    const track = nav.querySelector('.tnav-track');
    const prev = nav.querySelector('.tnav-prev');
    const next = nav.querySelector('.tnav-next');
    if (!track || !prev || !next) return;

    const sync = () => {
      const max = track.scrollWidth - track.clientWidth;
      prev.hidden = track.scrollLeft <= 2;
      next.hidden = max <= 2 || track.scrollLeft >= max - 2;
    };
    const step = () => Math.max(260, Math.round(track.clientWidth * 0.7));

    prev.addEventListener('click', () => track.scrollBy({ left: -step(), behavior: 'smooth' }));
    next.addEventListener('click', () => track.scrollBy({ left: step(), behavior: 'smooth' }));
    track.addEventListener('scroll', sync, { passive: true });
    window.addEventListener('resize', sync);

    const active = track.querySelector('a.active');
    if (active && track.scrollWidth > track.clientWidth) {
      track.scrollLeft = Math.max(0, active.offsetLeft - (track.clientWidth - active.offsetWidth) / 2);
    }
    sync();
  }

  function initBackToTop() {
    const button = document.querySelector('.back-to-top');
    if (!button) return;

    const sync = () => {
      button.classList.toggle('is-visible', window.scrollY > 480);
    };

    window.addEventListener('scroll', sync, { passive: true });
    window.addEventListener('resize', sync);
    sync();

    button.addEventListener('click', () => {
      const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
      window.scrollTo({ top: 0, behavior: reduced ? 'auto' : 'smooth' });

      const brand = document.querySelector('.site-header .brand');
      if (brand) brand.focus({ preventScroll: true });
    });
  }

  function initConfirmForms() {
    document.querySelectorAll('form[data-confirm]').forEach((form) => {
      form.addEventListener('submit', (event) => {
        if (!window.confirm(form.dataset.confirm)) {
          event.preventDefault();
        }
      });
    });
  }

  function initRailTop() {
    const header = document.querySelector('.site-header');
    if (!header) return;

    const sync = () => {
      document.documentElement.style.setProperty(
        '--rail-top',
        Math.round(header.getBoundingClientRect().height) + 'px'
      );
    };

    sync();
    window.addEventListener('resize', sync);
  }

  function initSideGroups() {
    const wrap = document.querySelector('.sidebar-scroll');
    if (!wrap) return;

    wrap.querySelectorAll('.side-group-head').forEach((head) => {
      head.addEventListener('click', () => {
        const group = head.closest('.side-group');
        if (!group) return;
        const open = group.classList.toggle('open');
        head.setAttribute('aria-expanded', open ? 'true' : 'false');
      });
    });

    const active = wrap.querySelector('li a.active');
    if (active) {
      const a = active.getBoundingClientRect();
      const s = wrap.getBoundingClientRect();
      if (a.top < s.top || a.bottom > s.bottom) {
        wrap.scrollTop += a.top - s.top - (s.height / 2 - a.height / 2);
      }
    }
  }

  function initSidebarFilter() {
    const input = document.getElementById('sidebar-filter');
    if (!input) return;

    input.addEventListener('input', () => {
      const term = input.value.trim().toLowerCase();

      document.querySelectorAll('.sidebar [data-filter-item]').forEach((item) => {
        item.hidden = term !== '' && !item.textContent.toLowerCase().includes(term);
      });

      document.querySelectorAll('.sidebar .side-group').forEach((group) => {
        const head = group.querySelector('.side-group-head');
        if (!head) return;

        if (term === '') {
          group.hidden = false;
          const open = head.classList.contains('is-active');
          group.classList.toggle('open', open);
          head.setAttribute('aria-expanded', open ? 'true' : 'false');
          return;
        }

        const shown = [...group.querySelectorAll('[data-filter-item]')]
          .filter((li) => !li.hidden).length;
        group.hidden = shown === 0;
        group.classList.toggle('open', shown > 0);
        head.setAttribute('aria-expanded', shown > 0 ? 'true' : 'false');
      });
    });
  }

  function initMantraFilter() {
    const input = document.getElementById('mantra-filter');
    if (!input) return;

    const apply = () => {
      const term = input.value.trim().toLowerCase();

      document.querySelectorAll('[data-mantra-item]').forEach((item) => {
        item.hidden = term !== '' && !item.textContent.toLowerCase().includes(term);
      });

      document.querySelectorAll('[data-mantra-group]').forEach((group) => {
        const cards = group.querySelectorAll('[data-mantra-item]');
        let visible = 0;
        cards.forEach((card) => { if (!card.hidden) visible += 1; });
        group.hidden = term !== '' && visible === 0;
      });

      const empty = document.getElementById('mantra-empty');
      if (empty) {
        const any = document.querySelector('[data-mantra-item]:not([hidden])');
        empty.hidden = any !== null;
      }
    };

    input.addEventListener('input', apply);
    apply();
  }

  function initTopicQuiz() {
    document.querySelectorAll('[data-topic-quiz]').forEach((box) => {
      if (box.dataset.quizReady === '1') return;
      box.dataset.quizReady = '1';

      const correct = box.dataset.correct || '';
      const result = box.querySelector('.topic-quiz-result');
      const verdict = box.querySelector('.topic-quiz-verdict');
      const explain = box.querySelector('.topic-quiz-explain');
      const options = [...box.querySelectorAll('[data-option]')];

      options.forEach((btn) => {
        btn.addEventListener('click', () => {
          if (box.classList.contains('is-answered')) return;
          box.classList.add('is-answered');

          const ok = btn.dataset.option === correct;
          btn.classList.add(ok ? 'is-correct' : 'is-wrong');
          if (!ok) {
            const right = options.find((o) => o.dataset.option === correct);
            if (right) right.classList.add('is-correct');
          }
          options.forEach((o) => { o.disabled = true; });

          if (verdict) {
            verdict.textContent = ok
              ? (box.dataset.msgRight || 'Correct!')
              : (box.dataset.msgWrong || 'Wrong!');
            verdict.classList.add(ok ? 'is-right' : 'is-wrong');
          }
          if (explain) explain.textContent = box.dataset.explanation || '';
          if (result) result.hidden = false;
        });
      });
    });
  }

  function initRailFooterGap() {
    const rail = document.querySelector('.layout > .sidebar');
    const footer = document.querySelector('.site-footer');
    if (!rail || !footer) return;

    let ticking = false;
    const apply = () => {
      ticking = false;
      if (getComputedStyle(rail).position !== 'fixed') {
        rail.style.height = '';
        return;
      }
      const railTop = rail.getBoundingClientRect().top;
      const avail = window.innerHeight - railTop;
      const gap = footer.getBoundingClientRect().top - railTop;
      rail.style.height = Math.max(0, Math.min(avail, gap)) + 'px';
    };
    const onScroll = () => {
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(apply);
    };

    apply();
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll);
  }

  document.addEventListener('DOMContentLoaded', () => {
    initNavbar();
    initTopicNav();
    initRailTop();
    initSideGroups();
    initComboTool();
    initConfirmForms();
    initSidebarFilter();
    initMantraFilter();
    initTopicQuiz();
    initRailFooterGap();
    initBackToTop();
  });

  return { request, escapeHtml };
})();
