document.addEventListener("DOMContentLoaded", () => {
  const menuIcon = document.getElementById("menu-icon");
  const sidebar = document.querySelector(".sidebar");
  const allButtons = document.querySelectorAll(".shortcut-links .icon-btn");
  const allDropdowns = document.querySelectorAll(".dropdown");
  const homeButton = document.getElementById("home-btn");

  // --- LOGIC FOR RESPONSIVE SIDEBAR (always same) ---
  const handleResponsiveSidebar = () => {
    if (!sidebar) return;

    sidebar.classList.add("hidden");
    sidebar.classList.add("small-sidebar");
  };

  handleResponsiveSidebar();
  window.addEventListener("resize", handleResponsiveSidebar);
  // --- END ---

  // Toggle sidebar on menu icon click
  if (menuIcon && sidebar) {
    menuIcon.addEventListener("click", () => {
      sidebar.classList.toggle("hidden");
      sidebar.classList.toggle("small-sidebar");
    });
  }

  // --- ICON HOVER SWAP ---
  allButtons.forEach((btn) => {
    const img = btn.querySelector("img.icon");
    if (img && !btn.classList.contains("no-hover-swap")) {
      btn.dataset.originalSrc = img.src;
    }
    if (img && img.dataset.hover) {
      btn.addEventListener("mouseover", () => (img.src = img.dataset.hover));
      btn.addEventListener("mouseout", () => {
        if (!btn.classList.contains("active")) {
          img.src = btn.dataset.originalSrc;
        }
      });
    }
  });

  // --- ACTIVE BUTTON HANDLER ---
  const setActiveButton = (newActiveButton) => {
    const currentActiveButton = document.querySelector(
      ".shortcut-links .icon-btn.active"
    );
    if (currentActiveButton) {
      currentActiveButton.classList.remove("active");
      const oldImg = currentActiveButton.querySelector("img.icon");
      if (oldImg && currentActiveButton.dataset.originalSrc) {
        oldImg.src = currentActiveButton.dataset.originalSrc;
      }
    }
    if (newActiveButton) {
      newActiveButton.classList.add("active");
      const newImg = newActiveButton.querySelector("img.icon");
      if (newImg && newImg.dataset.hover) {
        newImg.src = newImg.dataset.hover;
      }
    }
  };

  allButtons.forEach((btn) => {
    btn.addEventListener("click", (event) => {
      if (btn.classList.contains("categories-btn")) {
        event.stopPropagation();

        if (
          sidebar.classList.contains("small-sidebar") &&
          btn.id === "fan-picks-btn"
        ) {
          sidebar.classList.remove("small-sidebar");
        }

        const currentDropdown = btn.nextElementSibling;
        setActiveButton(btn);

        allDropdowns.forEach((d) => {
          if (d !== currentDropdown) d.classList.add("hidden");
        });

        if (currentDropdown) currentDropdown.classList.toggle("hidden");
      } else {
        setActiveButton(btn);
        if (!btn.closest(".dropdown")) {
          allDropdowns.forEach((dropdown) => dropdown.classList.add("hidden"));
        }
      }
    });
  });

  if (homeButton) setActiveButton(homeButton);

  document.addEventListener("click", (event) => {
    if (
      !event.target.closest(".categories-btn") &&
      !event.target.closest(".dropdown")
    ) {
      allDropdowns.forEach((dropdown) => dropdown.classList.add("hidden"));
    }
  });
});
