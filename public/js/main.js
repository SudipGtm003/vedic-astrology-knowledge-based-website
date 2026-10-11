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
    const dropdown = document.getElementById('graha-dropdown');
    const multiBtn = document.getElementById('graha-multi-btn');
    const btnLabel = document.getElementById('graha-btn-label');
    const countBadge = document.getElementById('graha-count');
    const panel = document.getElementById('graha-panel');
    const clearBtn = document.getElementById('graha-clear');
    const doneBtn = document.getElementById('graha-done');
    const rowsBox = document.getElementById('graha-list');
    const chipsRow = document.getElementById('chips-row');
    const chipsList = document.getElementById('chips-list');
    const quickList = document.getElementById('chips-quick');

    const GRAHAS = {};
    const order = [];
    rowsBox.querySelectorAll('.multi-row').forEach((row) => {
      GRAHAS[row.dataset.id] = row.dataset.name;
      order.push(row.dataset.id);
    });

    let selected = [{ id: '1', retro: false }];
    let focus = '1';

    // राहु(8) / केतु(9) सधैँ वक्री
    const isAutoRetro = (id) => id === '8' || id === '9';
    const entryOf = (id) => selected.find((item) => item.id === id) || null;

    function btnText() {
      if (selected.length === 0) return 'रिक्त भाव (कुनै ग्रह छैन)';
      if (selected.length === 1) {
        const only = selected[0];
        return GRAHAS[only.id] + (only.retro ? ' (वक्री)' : '');
      }
      return selected
        .map((item) => GRAHAS[item.id] + (item.retro ? '(व)' : ''))
        .join(', ');
    }

    function multiTabs() {
      if (selected.length <= 1) return '';
      return `<div class="shloka-tabs"><span class="stab-label">ग्रह श्लोक छान्नुहोस्:</span>${selected
        .map((item) => `<button type="button" class="stab${item.id === focus ? ' on' : ''}" data-gid="${item.id}">${escapeHtml(GRAHAS[item.id] || '')}${item.retro ? '(व)' : ''}</button>`)
        .join('')}</div>`;
    }

    function renderChips() {
      rowsBox.querySelectorAll('.multi-row').forEach((row) => {
        const id = row.dataset.id;
        const item = entryOf(id);
        row.classList.toggle('on', !!item);
        const retroBtn = row.querySelector('.multi-retro');
        retroBtn.hidden = !item;
        retroBtn.textContent = item && item.retro ? 'वक्री (व)' : 'मार्गी';
        retroBtn.classList.toggle('on', !!(item && item.retro));
      });

      btnLabel.textContent = btnText();
      countBadge.hidden = selected.length <= 1;
      countBadge.textContent = `${selected.length} ग्रह युति`;

      chipsList.innerHTML = selected
        .map((item) => `
          <span class="chip">
            <span class="chip-name">${escapeHtml(GRAHAS[item.id] || '')}</span>
            ${item.retro ? '<span class="chip-badge">वक्री</span>' : ''}
            <button type="button" class="chip-x" data-remove="${item.id}" title="हटाउनुहोस्" aria-label="हटाउनुहोस्">×</button>
          </span>`)
        .join('');

      // थप्नुहोस् — बाँकीका पहिलो ४ ग्रह
      quickList.innerHTML = order
        .filter((id) => !entryOf(id))
        .slice(0, 4)
        .map((id) => `<button type="button" class="chip chip-add" data-add="${id}">+ ${escapeHtml(GRAHAS[id] || '')}</button>`)
        .join('');

      chipsRow.hidden = selected.length === 0;
    }

    function toggle(id) {
      const item = entryOf(id);
      if (item) {
        selected = selected.filter((x) => x.id !== id);
        if (focus === id) focus = selected.length ? selected[0].id : null;
      } else {
        selected = selected.concat({ id, retro: isAutoRetro(id) });
        if (!focus) focus = id;
      }
      renderChips();
    }

    function openPanel(open) {
      panel.hidden = !open;
      multiBtn.classList.toggle('open', open);
      multiBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    multiBtn.addEventListener('click', () => openPanel(panel.hidden));
    doneBtn.addEventListener('click', () => openPanel(false));

    clearBtn.addEventListener('click', () => {
      selected = [];
      focus = null;
      renderChips();
    });

    document.addEventListener('mousedown', (event) => {
      if (!panel.hidden && !dropdown.contains(event.target)) openPanel(false);
    });

    rowsBox.addEventListener('click', (event) => {
      const row = event.target.closest('.multi-row');
      if (!row) return;

      if (event.target.closest('.multi-retro')) {
        const item = entryOf(row.dataset.id);
        if (item) {
          item.retro = !item.retro;
          renderChips();
        }
        return;
      }

      toggle(row.dataset.id);
    });

    chipsRow.addEventListener('click', (event) => {
      const remove = event.target.closest('[data-remove]');
      if (remove) {
        toggle(remove.dataset.remove);
        return;
      }
      const add = event.target.closest('[data-add]');
      if (add) toggle(add.dataset.add);
    });

    function render(data) {
      if (!data || !data.found) {
        const message = data && data.pending
          ? 'यो संयोजनको फलदेश अहिले तयार हुँदैछ।'
          : 'यो संयोजनको विवरण उपलब्ध छैन।';
        result.innerHTML = `<p class="combo-empty">${message}</p>`;
        return;
      }

      const bold = (text) => text.replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>');

      const paras = (text) => String(text || '')
        .split(/\n\s*\n/)
        .filter((part) => part.trim() !== '')
        .map((part) => `<p>${bold(escapeHtml(part))}</p>`)
        .join('');

      const bullets = (items) => (!Array.isArray(items) || items.length === 0
        ? ''
        : `<ul class="combo-list">${items
          .map((item) => `<li>${bold(escapeHtml(item))}</li>`)
          .join('')}</ul>`);

      const title = data.title_np || `${data.graha_np} + ${data.target_np}`;
      const head = `
        <h2>${escapeHtml(title)}</h2>
        <p class="card-sanskrit">${escapeHtml(data.sanskrit_line || '')}</p>`;

      let sections = [];
      let source = '';

      if (data.reading) {
        const reading = data.reading;
        const bhavesh = reading.bhavesh || {};

        sections = [
          [
            'शास्त्रीय संस्कृत श्लोक',
            `${multiTabs()}<p class="combo-shloka">${escapeHtml(reading.shloka || '')}</p>`
          ],
          ['नेपाली भावार्थ', paras(reading.shloka_translation)],
          [
            'सम्बन्ध र फल बल',
            `<p><strong>सम्बन्ध:</strong> ${escapeHtml(reading.relationship || '')}</p>`
            + `<p><strong>फल बल:</strong> ${escapeHtml(reading.strength || '')}</p>`
          ],
          ['ज्योतिषीय विश्लेषण', paras(reading.analysis)],
          [
            '🔑 भावेश फल (बृहत्पाराशर होराशास्त्र)',
            `<p class="bhavesh-title">${escapeHtml([bhavesh.label, bhavesh.title].filter(Boolean).join(' — '))}</p>
             <div class="combo-box bx-amber">
               <span class="box-tag">📜 बृ.पा.हो.शा. (भावेशफलाध्याय) — श्लोक ${escapeHtml(String(bhavesh.shlokaNo ?? ''))}</span>
               <p class="box-shloka">${escapeHtml(bhavesh.shloka || '')}</p>
             </div>
             <div class="combo-box bx-blue">
               <span class="box-tag">नेपाली भावार्थ</span>
               ${paras(bhavesh.meaning)}
             </div>
             <div class="combo-box bx-gray">
               <span class="box-tag">ज्योतिषीय व्याख्या</span>
               ${paras(bhavesh.commentary)}
             </div>`,
            'bhavesh-kicker'
          ],
          ['सकारात्मक प्रभाव', bullets(reading.positive_effects)],
          ['चुनौतीहरू', bullets(reading.negative_effects)],
          ['उपाय', bullets(reading.remedies)]
        ];

        source = reading.source
          ? `<p class="combo-src">स्रोत: ${escapeHtml(reading.source)}</p>`
          : '';
      }

      const html = `
        ${head}
        ${sections
          .filter(([, body]) => body && String(body).trim() !== '')
          .map(([heading, body, cls]) => `
            <div class="combo-section">
              <h3${cls ? ` class="${cls}"` : ''}>${heading}</h3>
              ${body}
            </div>
          `)
          .join('')}
        ${source}
      `;

      result.innerHTML = html;
    }

    async function fetchReading() {
      if (!focus || !bhava.value || !rashi.value) {
        result.innerHTML = '<p class="combo-empty">भाव, राशि र ग्रह छान्नुहोस्।</p>';
        return;
      }

      const item = entryOf(focus) || { retro: false };
      const params = new URLSearchParams({
        action: 'combination',
        target_type: 'bhava_rashi',
        bhava_id: bhava.value,
        rashi_id: rashi.value,
        graha_id: focus,
        retrograde: item.retro ? '1' : '0'
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
    }

    form.addEventListener('submit', (event) => {
      event.preventDefault();
      openPanel(false);
      fetchReading();
    });

    result.addEventListener('click', (event) => {
      const tab = event.target.closest('.stab');
      if (!tab) return;
      focus = tab.dataset.gid;
      fetchReading();
    });

    renderChips();
    fetchReading();
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
