(() => {
  const modal = document.getElementById("popbag-product-modal");
  if (!modal) return;

  const modalBody = document.getElementById("popbag-product-modal-body");
  const modalTitle = document.getElementById("popbag-product-modal-title");
  const closeBtns = modal.querySelectorAll("[data-popbag-modal-close]");
  const backdrop = modal.querySelector("[data-popbag-modal-backdrop]");
  const notice = document.getElementById("popbag-bag-notice");

  // Lightbox (image zoom)
  const lightbox = document.getElementById("popbag-lightbox");
  const lightboxImg = document.getElementById("popbag-lightbox-img");
  const lightboxZoomLabel = document.getElementById("popbag-lightbox-zoom");
  const lightboxStage = lightbox ? lightbox.querySelector("[data-popbag-lightbox-stage]") : null;
  const lightboxCloseBtns = lightbox ? lightbox.querySelectorAll("[data-popbag-lightbox-close]") : [];
  const zoomInBtn = lightbox ? lightbox.querySelector("[data-popbag-zoom-in]") : null;
  const zoomOutBtn = lightbox ? lightbox.querySelector("[data-popbag-zoom-out]") : null;
  let lbScale = 1;
  let lbX = 0;
  let lbY = 0;
  let lbDragging = false;
  let lbStartX = 0;
  let lbStartY = 0;
  let lbStartTX = 0;
  let lbStartTY = 0;

  /** @type {number|null} */
  let currentProductId = null;

  const showNotice = (msg) => {
    if (!notice) return;
    if (!msg) {
      notice.hidden = true;
      notice.textContent = "";
      return;
    }
    notice.textContent = msg;
    notice.hidden = false;
    window.clearTimeout(showNotice._t);
    showNotice._t = window.setTimeout(() => {
      notice.hidden = true;
      notice.textContent = "";
    }, 3500);
  };

  // Advanced modes (if present).
  const modesEl = document.querySelector("[data-popbag-modes]");
  let modes = [];
  if (modesEl) {
    try {
      const raw = modesEl.getAttribute("data-popbag-modes") || "[]";
      const parsed = JSON.parse(raw);
      if (Array.isArray(parsed)) modes = parsed;
    } catch (_) {
      modes = [];
    }
  }

  // OR rules: pairs of product_cat where only 1 selection is allowed across both.
  const grid = document.querySelector("[data-popbag-or-pairs]");
  let orPairs = [];
  if (grid) {
    try {
      const raw = grid.getAttribute("data-popbag-or-pairs") || "[]";
      const parsed = JSON.parse(raw);
      if (Array.isArray(parsed)) orPairs = parsed;
    } catch (_) {
      orPairs = [];
    }
  }

  const parseCats = (el) => {
    const raw = el.getAttribute("data-product-cats") || "";
    if (!raw) return [];
    return raw
      .split(",")
      .map((s) => Number(String(s).trim()))
      .filter((n) => Number.isFinite(n) && n > 0);
  };

  const normalizeModes = () => {
    modes = (modes || [])
      .map((m) => {
        if (!m || typeof m !== "object") return null;
        const label = String(m.label || "").trim();
        const min_items = Number(m.min_items ?? 0);
        const max_items = Number(m.max_items ?? 0);
        const groups = Array.isArray(m.groups) ? m.groups : [];
        const g2 = groups
          .map((g) => {
            if (!g || typeof g !== "object") return null;
            const cats = Array.isArray(g.cats)
              ? g.cats.map((x) => Number(x)).filter((n) => n > 0)
              : [];
            const min = Number(g.min ?? 0);
            const max = Number(g.max ?? 0);
            if (!cats.length || !(max > 0)) return null;
            return { cats, min: Math.max(0, min), max: Math.max(0, max) };
          })
          .filter(Boolean);
        if (!label || !(max_items > 0) || !g2.length) return null;
        return {
          label,
          min_items: Math.max(0, min_items),
          max_items: Math.max(1, max_items),
          groups: g2,
        };
      })
      .filter(Boolean);
  };

  normalizeModes();

  const hasModes = Array.isArray(modes) && modes.length > 0;

  const getSelectedModeIndex = () => {
    const checked = document.querySelector('input[name="popbag_bag_mode"]:checked');
    const val = checked ? Number(checked.value) : -1;
    return Number.isFinite(val) ? val : -1;
  };

  const getSelectedProductIds = () => {
    return Array.from(document.querySelectorAll(".popbag-product-checkbox:checked"))
      .map((cb) => Number(cb.getAttribute("data-product-id") || "0"))
      .filter((n) => n > 0);
  };

  const catsForProductId = (productId) => {
    const cb = document.querySelector(
      `.popbag-product-checkbox[data-product-id="${productId}"]`
    );
    if (!cb) return [];
    return parseCats(cb);
  };

  const normalizeOrPairs = () => {
    orPairs = (orPairs || [])
      .map((row) => {
        if (!row || typeof row !== "object") return null;
        const a = Number(row.a ?? row[0] ?? 0);
        const b = Number(row.b ?? row[1] ?? 0);
        if (!a || !b || a === b) return null;
        return { a, b };
      })
      .filter(Boolean);
  };

  const validateMaxOnlyForMode = (mode, selectedIds) => {
    const selCount = selectedIds.length;
    if (selCount > mode.max_items) {
      return {
        ok: false,
        message: `Puoi selezionare al massimo ${mode.max_items} capi per questa modalità.`,
      };
    }

    for (const g of mode.groups) {
      let count = 0;
      for (const pid of selectedIds) {
        const cats = catsForProductId(pid);
        if (g.cats.some((c) => cats.includes(c))) count += 1;
      }
      if (count > g.max) {
        return {
          ok: false,
          message:
            "Hai superato il massimo consentito per una delle regole della modalità scelta.",
        };
      }
    }
    return { ok: true, message: "" };
  };

  const validateSelectionAgainstMode = (mode, selectedIds) => {
    const selCount = selectedIds.length;
    if (selCount < mode.min_items || selCount > mode.max_items) {
      return {
        ok: false,
        message: `Questa modalità richiede tra ${mode.min_items} e ${mode.max_items} capi.`,
      };
    }

    const allowed = new Set();
    mode.groups.forEach((g) => g.cats.forEach((c) => allowed.add(c)));

    for (const pid of selectedIds) {
      const cats = catsForProductId(pid);
      if (!cats.some((c) => allowed.has(c))) {
        return {
          ok: false,
          message: "Hai selezionato un capo non permesso per questa modalità.",
        };
      }
    }

    for (const g of mode.groups) {
      let count = 0;
      for (const pid of selectedIds) {
        const cats = catsForProductId(pid);
        if (g.cats.some((c) => cats.includes(c))) count += 1;
      }
      if (count < g.min || count > g.max) {
        return {
          ok: false,
          message:
            "Selezione non valida per una delle regole della modalità scelta.",
        };
      }
    }

    return { ok: true, message: "" };
  };

  const applyOrRulesForCheckbox = (checkbox) => {
    // If advanced modes exist, ignore legacy OR pairs swap logic.
    if (hasModes) return;
    if (!checkbox || !checkbox.checked) return;
    if (!orPairs || !orPairs.length) return;

    const currentId = Number(checkbox.getAttribute("data-product-id") || "0");
    const cats = parseCats(checkbox);
    if (!cats.length) return;

    // For each OR pair the current product belongs to, uncheck any other selected products in A or B.
    orPairs.forEach(({ a, b }) => {
      if (!cats.includes(a) && !cats.includes(b)) return;

      document.querySelectorAll(".popbag-product-checkbox:checked").forEach((cb) => {
        if (!(cb instanceof HTMLElement)) return;
        const otherId = Number(cb.getAttribute("data-product-id") || "0");
        if (!otherId || otherId === currentId) return;
        const otherCats = parseCats(cb);
        if (otherCats.includes(a) || otherCats.includes(b)) {
          cb.checked = false;
          syncCardState(otherId);
        }
      });
    });
  };

  normalizeOrPairs();

  const getCheckboxForProduct = (productId) => {
    return document.querySelector(
      `.popbag-product-checkbox[data-product-id="${productId}"]`
    );
  };

  const getCardForProduct = (productId) => {
    return document.querySelector(
      `.popbag-product-card[data-product-id="${productId}"]`
    );
  };

  const syncCardState = (productId) => {
    const checkbox = getCheckboxForProduct(productId);
    const card = getCardForProduct(productId);
    if (!checkbox || !card) return;
    card.classList.toggle("is-selected", !!checkbox.checked);
  };

  const clearAllSelections = () => {
    document.querySelectorAll(".popbag-product-checkbox:checked").forEach((cb) => {
      const id = Number(cb.getAttribute("data-product-id") || "0");
      cb.checked = false;
      if (id) syncCardState(id);
    });
  };

  const setBodyScrollLocked = (locked) => {
    document.documentElement.style.overflow = locked ? "hidden" : "";
  };

  const updateLightboxZoom = () => {
    if (!lightboxImg) return;
    const pct = Math.round(lbScale * 100);
    if (lightboxZoomLabel) lightboxZoomLabel.textContent = `${pct}%`;
    // translate first so it stays in screen pixels (CSS transforms apply right-to-left)
    lightboxImg.style.transform = `translate(${lbX}px, ${lbY}px) scale(${lbScale})`;
    lightboxImg.classList.toggle("is-zoomed", lbScale > 1);
  };

  const openLightbox = (src, alt = "") => {
    if (!lightbox || !lightboxImg) return;
    lbScale = 1;
    lbX = 0;
    lbY = 0;
    lightboxImg.src = src || "";
    lightboxImg.alt = alt || "";
    updateLightboxZoom();
    lightbox.hidden = false;
    setBodyScrollLocked(true);
  };

  const closeLightbox = () => {
    if (!lightbox || !lightboxImg) return;
    lightbox.hidden = true;
    lightboxImg.src = "";
    lbScale = 1;
    lbX = 0;
    lbY = 0;
    lbDragging = false;
    setBodyScrollLocked(false);
  };

  const openModal = (productId) => {
    const tpl = document.getElementById(`popbag-product-detail-${productId}`);
    if (!tpl || !modalBody) return;

    currentProductId = productId;
    modalBody.innerHTML = "";
    modalBody.appendChild(tpl.content.cloneNode(true));

    const name = tpl.getAttribute("data-product-name") || "";
    if (modalTitle) modalTitle.textContent = name;

    const checkbox = getCheckboxForProduct(productId);
    const selected = !!(checkbox && checkbox.checked);
    const selectBtn = modalBody.querySelector("[data-popbag-modal-select]");
    if (selectBtn) {
      selectBtn.classList.toggle("is-selected", selected);
      selectBtn.textContent = selected ? "Rimuovi" : "Seleziona";
      selectBtn.addEventListener("click", () => {
        if (!currentProductId) return;
        const cb = getCheckboxForProduct(currentProductId);
        if (!cb) return;
        cb.checked = !cb.checked;
        if (hasModes) {
          const idx = getSelectedModeIndex();
          const mode = modes[idx] || modes[0];
          if (mode) {
            const selectedIds = getSelectedProductIds();
            const res = validateMaxOnlyForMode(mode, selectedIds);
            if (!res.ok) {
              cb.checked = false;
              showNotice(res.message);
            }
          }
        } else {
          applyOrRulesForCheckbox(cb);
        }
        syncCardState(currentProductId);
        const isSel = !!cb.checked;
        selectBtn.classList.toggle("is-selected", isSel);
        selectBtn.textContent = isSel ? "Rimuovi" : "Seleziona";
        closeModal();
      });
    }

    // wire thumbs inside the injected content
    modalBody.querySelectorAll("[data-popbag-thumb]").forEach((btn) => {
      btn.addEventListener("click", () => {
        const url = btn.getAttribute("data-popbag-thumb") || "";
        const main = modalBody.querySelector("[data-popbag-main-image]");
        if (main && url) main.setAttribute("src", url);
      });
    });

    // Lightbox open on main image click (zoom)
    const mainImg = modalBody.querySelector("[data-popbag-main-image]");
    if (mainImg) {
      mainImg.style.cursor = "zoom-in";
      mainImg.addEventListener("click", () => {
        const src = mainImg.getAttribute("src") || "";
        openLightbox(src, name);
      });
    }

    modal.hidden = false;
    setBodyScrollLocked(true);
    // focus close for accessibility
    const close = modal.querySelector(".popbag-modal__close");
    if (close) close.focus();
  };

  const closeModal = () => {
    currentProductId = null;
    if (modalBody) modalBody.innerHTML = "";
    modal.hidden = true;
    setBodyScrollLocked(false);
  };

  // Open modal on card click.
  document.addEventListener("click", (e) => {
    const target = e.target;
    if (!(target instanceof Element)) return;

    const card = target.closest(".popbag-product-card");
    if (!card) return;

    // Clicking the top-right "check hole" toggles selection without opening the modal.
    const toggle = target.closest("[data-popbag-toggle]");
    if (toggle) {
      e.preventDefault();
      const id = Number(card.getAttribute("data-product-id") || "0");
      if (!id) return;
      const checkbox = getCheckboxForProduct(id);
      if (!checkbox) return;
      checkbox.checked = !checkbox.checked;
      if (hasModes) {
        const idx = getSelectedModeIndex();
        const mode = modes[idx] || modes[0];
        if (mode) {
          const selectedIds = getSelectedProductIds();
          const res = validateMaxOnlyForMode(mode, selectedIds);
          if (!res.ok) {
            checkbox.checked = false;
            showNotice(res.message);
          }
        }
      } else {
        applyOrRulesForCheckbox(checkbox);
      }
      syncCardState(id);
      return;
    }

    const id = Number(card.getAttribute("data-product-id") || "0");
    if (!id) return;
    openModal(id);
  });

  // Close interactions.
  closeBtns.forEach((btn) => btn.addEventListener("click", closeModal));
  if (backdrop) backdrop.addEventListener("click", closeModal);
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && lightbox && !lightbox.hidden) closeLightbox();
    else if (e.key === "Escape" && !modal.hidden) closeModal();
  });

  // Lightbox controls
  if (lightbox) {
    lightboxCloseBtns.forEach((btn) => btn.addEventListener("click", closeLightbox));
    if (zoomInBtn) {
      zoomInBtn.addEventListener("click", () => {
        lbScale = Math.min(4, lbScale + 0.25);
        updateLightboxZoom();
      });
    }
    if (zoomOutBtn) {
      zoomOutBtn.addEventListener("click", () => {
        lbScale = Math.max(1, lbScale - 0.25);
        if (lbScale === 1) {
          lbX = 0;
          lbY = 0;
        }
        updateLightboxZoom();
      });
    }
    if (lightboxStage) {
      lightboxStage.addEventListener(
        "wheel",
        (e) => {
          e.preventDefault();
          const dir = e.deltaY > 0 ? -1 : 1;
          lbScale = Math.max(1, Math.min(4, lbScale + dir * 0.15));
          if (lbScale === 1) {
            lbX = 0;
            lbY = 0;
          }
          updateLightboxZoom();
        },
        { passive: false }
      );
    }

    // Drag (grab) to pan when zoomed.
    if (lightboxImg) {
      lightboxImg.addEventListener("pointerdown", (e) => {
        if (lbScale <= 1) return;
        e.preventDefault();
        lbDragging = true;
        lbStartX = e.clientX;
        lbStartY = e.clientY;
        lbStartTX = lbX;
        lbStartTY = lbY;
        lightboxImg.setPointerCapture(e.pointerId);
        lightboxImg.classList.add("is-dragging");
      });

      lightboxImg.addEventListener("pointermove", (e) => {
        if (!lbDragging) return;
        lbX = lbStartTX + (e.clientX - lbStartX);
        lbY = lbStartTY + (e.clientY - lbStartY);
        updateLightboxZoom();
      });

      const endDrag = (e) => {
        if (!lbDragging) return;
        lbDragging = false;
        if (lightboxImg) lightboxImg.classList.remove("is-dragging");
        try {
          if (lightboxImg && e && "pointerId" in e) lightboxImg.releasePointerCapture(e.pointerId);
        } catch (_) {
          // ignore
        }
      };

      lightboxImg.addEventListener("pointerup", endDrag);
      lightboxImg.addEventListener("pointercancel", endDrag);
      lightboxImg.addEventListener("pointerleave", endDrag);
    }
  }

  // Keep card state consistent if checkboxes change elsewhere.
  document.querySelectorAll(".popbag-product-checkbox").forEach((cb) => {
    cb.addEventListener("change", () => {
      if (hasModes) {
        const idx = getSelectedModeIndex();
        const mode = modes[idx] || modes[0];
        if (mode) {
          const selectedIds = getSelectedProductIds();
          const res = validateMaxOnlyForMode(mode, selectedIds);
          if (!res.ok) {
            cb.checked = false;
            showNotice(res.message);
          }
        }
      } else {
        applyOrRulesForCheckbox(cb);
      }
      const id = Number(cb.getAttribute("data-product-id") || "0");
      if (id) syncCardState(id);
    });
    const id = Number(cb.getAttribute("data-product-id") || "0");
    if (id) syncCardState(id);
  });

  // Enforce initial state (prefill from cart).
  if (hasModes) {
    const idx = getSelectedModeIndex();
    const mode = modes[idx] || modes[0];
    if (mode) {
      const selectedIds = getSelectedProductIds();
      const res = validateMaxOnlyForMode(mode, selectedIds);
      if (!res.ok) {
        clearAllSelections();
        showNotice("Selezione ripristinata: non compatibile con la modalità scelta.");
      }
    }
  } else if (orPairs && orPairs.length) {
    document.querySelectorAll(".popbag-product-checkbox:checked").forEach((cb) => {
      applyOrRulesForCheckbox(cb);
    });
  }

  // Mode switching clears selection to avoid ambiguity.
  if (hasModes) {
    document.querySelectorAll('input[name="popbag_bag_mode"]').forEach((r) => {
      r.addEventListener("change", () => {
        clearAllSelections();
        showNotice("Modalità cambiata: selezione azzerata.");
      });
    });
  }

  // Prevent submit if selection doesn't satisfy min rules.
  const form = modal.closest("form");
  if (form) {
    form.addEventListener("submit", (e) => {
      if (!hasModes) return;
      const idx = getSelectedModeIndex();
      const mode = modes[idx] || modes[0];
      if (!mode) return;
      const selectedIds = getSelectedProductIds();
      const res = validateSelectionAgainstMode(mode, selectedIds);
      if (!res.ok) {
        e.preventDefault();
        showNotice(res.message);
      }
    });
  }
})();

