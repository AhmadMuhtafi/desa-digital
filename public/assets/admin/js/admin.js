/* =========================================================
   Admin Dashboard — interaksi dasar (tanpa dependensi)
   Letakkan di: public/assets/admin/js/admin.js
   ========================================================= */
(function () {
  "use strict";

  var root = document.documentElement;
  var app = document.getElementById("app");
  var mqMobile = window.matchMedia("(max-width: 991px)");

  function store(key, val) {
    try {
      if (val === undefined) return localStorage.getItem(key);
      localStorage.setItem(key, val);
    } catch (e) { /* storage diblokir */ }
  }

  /* ---------- Sidebar ---------- */
  if (store("admin.sidebar") === "collapsed" && !mqMobile.matches) {
    app.classList.add("is-collapsed");
  }

  var sidebarToggle = document.getElementById("sidebarToggle");
  var overlay = document.getElementById("overlay");

  function closeMobileSidebar() { app.classList.remove("sidebar-open"); }

  if (sidebarToggle) {
    sidebarToggle.addEventListener("click", function () {
      if (mqMobile.matches) {
        app.classList.toggle("sidebar-open");
      } else {
        var collapsed = app.classList.toggle("is-collapsed");
        store("admin.sidebar", collapsed ? "collapsed" : "expanded");
        window.dispatchEvent(new Event("resize")); // agar chart menyesuaikan
      }
    });
  }
  if (overlay) overlay.addEventListener("click", closeMobileSidebar);
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") { closeMobileSidebar(); closeDropdowns(); }
  });

  /* ---------- Tema (light / dark) ---------- */
  var themeToggle = document.getElementById("themeToggle");

  function applyTheme(theme) {
    root.setAttribute("data-theme", theme);
    store("admin.theme", theme);
    if (themeToggle) {
      themeToggle.innerHTML = theme === "dark"
        ? '<i class="bi bi-sun"></i>'
        : '<i class="bi bi-moon-stars"></i>';
    }
    window.dispatchEvent(new CustomEvent("themechange", { detail: theme }));
  }

  if (themeToggle) {
    applyTheme(root.getAttribute("data-theme") || "light");
    themeToggle.addEventListener("click", function () {
      applyTheme(root.getAttribute("data-theme") === "dark" ? "light" : "dark");
    });
  }

  /* ---------- Dropdown ---------- */
  function closeDropdowns(except) {
    document.querySelectorAll(".dropdown.open").forEach(function (d) {
      if (d !== except) {
        d.classList.remove("open");
        var t = d.querySelector("[data-dropdown]");
        if (t) t.setAttribute("aria-expanded", "false");
      }
    });
  }

  document.querySelectorAll("[data-dropdown]").forEach(function (trigger) {
    trigger.setAttribute("aria-expanded", "false");
    trigger.addEventListener("click", function (e) {
      e.stopPropagation();
      var dd = trigger.closest(".dropdown");
      var willOpen = !dd.classList.contains("open");
      closeDropdowns(dd);
      dd.classList.toggle("open", willOpen);
      trigger.setAttribute("aria-expanded", String(willOpen));
    });
  });
  document.addEventListener("click", function (e) {
    if (!e.target.closest(".dropdown")) closeDropdowns();
  });

  /* ---------- Pencarian: pintasan "/" atau Ctrl/Cmd + K ---------- */
  var searchInput = document.getElementById("globalSearch");
  document.addEventListener("keydown", function (e) {
    var typing = /input|textarea|select/i.test(document.activeElement.tagName);
    if ((e.key === "/" && !typing) || ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === "k")) {
      e.preventDefault();
      if (searchInput) searchInput.focus();
    }
  });

  var searchBtn = document.getElementById("searchToggle"); // tombol cari di mobile
  if (searchBtn) {
    searchBtn.addEventListener("click", function () {
      var box = document.querySelector(".search");
      box.classList.toggle("is-open");
      if (box.classList.contains("is-open")) searchInput.focus();
    });
  }

  /* ---------- Filter tabel (data-table-filter="#idTabel") ---------- */
  document.querySelectorAll("[data-table-filter]").forEach(function (input) {
    var table = document.querySelector(input.getAttribute("data-table-filter"));
    if (!table) return;
    var body = table.tBodies[0];
    var emptyRow = body.querySelector(".empty-row");

    input.addEventListener("input", function () {
      var q = input.value.trim().toLowerCase();
      var visible = 0;
      body.querySelectorAll("tr:not(.empty-row)").forEach(function (tr) {
        var show = tr.textContent.toLowerCase().indexOf(q) !== -1;
        tr.style.display = show ? "" : "none";
        if (show) visible++;
      });
      if (emptyRow) emptyRow.style.display = visible ? "none" : "";
    });
  });

  /* ---------- Toast: window.toast("Pesan", "bi-check-circle") ---------- */
  var stack = document.createElement("div");
  stack.className = "toast-stack";
  stack.setAttribute("aria-live", "polite");
  document.body.appendChild(stack);

  window.toast = function (message, icon) {
    var el = document.createElement("div");
    el.className = "toast";
    var i = document.createElement("i");
    i.className = "bi " + (icon || "bi-check-circle");
    var span = document.createElement("span");
    span.textContent = message;
    el.appendChild(i);
    el.appendChild(span);
    stack.appendChild(el);
    setTimeout(function () {
      el.style.transition = "opacity .25s";
      el.style.opacity = "0";
      setTimeout(function () { el.remove(); }, 250);
    }, 3000);
  };

  /* ---------- Segmented control (data-segmented) ---------- */
  document.querySelectorAll("[data-segmented]").forEach(function (group) {
    group.addEventListener("click", function (e) {
      var btn = e.target.closest("button");
      if (!btn) return;
      group.querySelectorAll("button").forEach(function (b) { b.classList.remove("active"); });
      btn.classList.add("active");
      group.dispatchEvent(new CustomEvent("segment", { detail: btn.dataset.value }));
    });
  });

  /* ---------- Dialog konfirmasi: <form data-confirm="Pesan"
       data-confirm-title="Judul" data-confirm-ok="Teks tombol"> ---------- */
  (function () {
    var modal = document.createElement("div");
    modal.className = "modal";
    modal.setAttribute("role", "dialog");
    modal.setAttribute("aria-modal", "true");
    modal.setAttribute("aria-labelledby", "modalTitle");
    modal.innerHTML =
      '<div class="modal-backdrop" data-close></div>' +
      '<div class="modal-box">' +
      '<span class="modal-icon tone-danger"><i class="bi bi-exclamation-triangle"></i></span>' +
      '<h3 id="modalTitle"></h3><p id="modalText"></p>' +
      '<div class="modal-actions">' +
      '<button type="button" class="btn btn-ghost" id="modalCancel" data-close>Batal</button>' +
      '<button type="button" class="btn btn-danger" id="modalOk"></button>' +
      '</div>' +
      '</div>';
    document.body.appendChild(modal);

    var pendingForm = null;
    var lastFocus = null;

    function openModal(form) {
      pendingForm = form;
      lastFocus = document.activeElement;
      document.getElementById("modalTitle").textContent = form.dataset.confirmTitle || "Konfirmasi";
      document.getElementById("modalText").textContent = form.dataset.confirm || "Lanjutkan tindakan ini?";
      document.getElementById("modalOk").textContent = form.dataset.confirmOk || "Ya, lanjutkan";
      modal.classList.add("open");
      document.getElementById("modalCancel").focus();
    }

    function closeModal() {
      modal.classList.remove("open");
      pendingForm = null;
      if (lastFocus) lastFocus.focus();
    }

    document.addEventListener("submit", function (e) {
      var form = e.target;
      if (form.matches && form.matches("form[data-confirm]")) {
        e.preventDefault();
        openModal(form);
      }
    });

    modal.addEventListener("click", function (e) {
      if (e.target.closest("[data-close]")) closeModal();
    });

    document.getElementById("modalOk").addEventListener("click", function () {
      var form = pendingForm;
      if (!form) return;
      this.disabled = true;
      form.submit(); // submit() tidak memicu event "submit" lagi
    });

    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && modal.classList.contains("open")) closeModal();
    });
  })();

  /* ---------- Tutup sidebar mobile saat pindah halaman ---------- */
  document.querySelectorAll(".nav-link").forEach(function (a) {
    a.addEventListener("click", closeMobileSidebar);
  });
  mqMobile.addEventListener("change", closeMobileSidebar);
})();