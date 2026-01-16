(() => {
  const modal = document.getElementById("popbag-product-modal");
  if (!modal) return;

  const modalBody = document.getElementById("popbag-product-modal-body");
  const modalTitle = document.getElementById("popbag-product-modal-title");
  const closeBtns = modal.querySelectorAll("[data-popbag-modal-close]");
  const backdrop = modal.querySelector("[data-popbag-modal-backdrop]");

  /** @type {number|null} */
  let currentProductId = null;

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

  const setBodyScrollLocked = (locked) => {
    document.documentElement.style.overflow = locked ? "hidden" : "";
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
        syncCardState(currentProductId);
        const isSel = !!cb.checked;
        selectBtn.classList.toggle("is-selected", isSel);
        selectBtn.textContent = isSel ? "Rimuovi" : "Seleziona";
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
    if (e.key === "Escape" && !modal.hidden) closeModal();
  });

  // Keep card state consistent if checkboxes change elsewhere.
  document.querySelectorAll(".popbag-product-checkbox").forEach((cb) => {
    cb.addEventListener("change", () => {
      const id = Number(cb.getAttribute("data-product-id") || "0");
      if (id) syncCardState(id);
    });
    const id = Number(cb.getAttribute("data-product-id") || "0");
    if (id) syncCardState(id);
  });
})();

