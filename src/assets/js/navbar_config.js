const moreOptionsBtn = document.getElementById("moreOptionsBtn");
const moreOptionsMenu = document.getElementById("moreOptionsMenu");
const mobileSearchBtn = document.getElementById("mobileSearchBtn");
const mobileSearchOverlay = document.getElementById("mobileSearchOverlay");
const mobileSearchInput = document.getElementById("mobileSearchInput");

document
  .getElementById("domain-name")
  .addEventListener("click", () => location.reload());
document
  .getElementById("domain-logo")
  .addEventListener("click", () => location.reload());

// Toggle 3-dot dropdown with enter/exit animations
moreOptionsBtn.addEventListener("click", function (e) {
  e.stopPropagation();
  if (moreOptionsMenu.classList.contains("hidden")) {
    moreOptionsMenu.classList.remove("hidden");
    setTimeout(() => {
      moreOptionsMenu.classList.remove("opacity-0", "scale-95");
      moreOptionsMenu.classList.add("opacity-100", "scale-100");
    }, 10);
  } else {
    moreOptionsMenu.classList.add("opacity-0", "scale-95");
    moreOptionsMenu.classList.remove("opacity-100", "scale-100");
    setTimeout(() => {
      moreOptionsMenu.classList.add("hidden");
    }, 200);
  }
});

// Close dropdown when clicking outside
document.addEventListener("click", function (e) {
  if (!moreOptionsMenu.contains(e.target) && e.target !== moreOptionsBtn) {
    if (!moreOptionsMenu.classList.contains("hidden")) {
      moreOptionsMenu.classList.add("opacity-0", "scale-95");
      moreOptionsMenu.classList.remove("opacity-100", "scale-100");
      setTimeout(() => {
        moreOptionsMenu.classList.add("hidden");
      }, 200);
    }
  }
});

// Prevent dropdown from closing on its own clicks
moreOptionsMenu.addEventListener("click", (e) => e.stopPropagation());

// Mobile search overlay open (also hides dropdown if open)
mobileSearchBtn.addEventListener("click", function (e) {
  e.stopPropagation();
  if (!moreOptionsMenu.classList.contains("hidden")) {
    moreOptionsMenu.classList.add("opacity-0", "scale-95");
    moreOptionsMenu.classList.remove("opacity-100", "scale-100");
    setTimeout(() => {
      moreOptionsMenu.classList.add("hidden");
    }, 200);
  }
  mobileSearchBtn.classList.add("hidden");
  mobileSearchOverlay.classList.remove("hidden");
  setTimeout(
    () => mobileSearchOverlay.classList.remove("-translate-y-full"),
    10
  );
  mobileSearchInput.focus();
});

// Close mobile search overlay with transition
function closeMobileSearch() {
  mobileSearchOverlay.classList.add("-translate-y-full");
  setTimeout(() => {
    mobileSearchOverlay.classList.add("hidden");
    mobileSearchBtn.classList.remove("hidden");
    mobileSearchInput.value = "";
  }, 300);
}

// Close mobile overlay on outside click
document.addEventListener("click", function (e) {
  if (!mobileSearchOverlay.contains(e.target) && e.target !== mobileSearchBtn) {
    if (!mobileSearchOverlay.classList.contains("hidden")) {
      closeMobileSearch();
    }
  }
});

// Prevent closing overlay on inner clicks
mobileSearchOverlay.addEventListener("click", (e) => e.stopPropagation());

// Close overlay on Enter or Escape key press
mobileSearchInput.addEventListener("keydown", function (e) {
  if (e.key === "Enter" || e.key === "Escape") {
    closeMobileSearch();
  }
});

const desktopButtons = document.querySelector(".min-\\[750px\\]\\:hidden");

// Responsive button visibility based on viewport width
function handleResponsiveNav() {
  if (window.innerWidth <= 750) {
    mobileSearchBtn.classList.remove("hidden");
    moreOptionsBtn.classList.remove("hidden");
    desktopButtons.classList.add("hidden");
  } else {
    mobileSearchBtn.classList.add("hidden");
    moreOptionsBtn.classList.add("hidden");
    desktopButtons.classList.remove("hidden");
    // Ensure mobile UI elements are closed in desktop view
    closeMobileSearch();
    moreOptionsMenu.classList.add("hidden");
  }
}

window.addEventListener("resize", handleResponsiveNav);
window.addEventListener("DOMContentLoaded", handleResponsiveNav);
