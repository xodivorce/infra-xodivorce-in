async function loadDashboardMetrics() {
  const metricsData = {
    totalReports: null,
    activeIssues: null,
    resolvedIssues: null,
    criticalAlerts: null,
  };

  const safeSetText = (selector, value) => {
    const el = document.querySelector(selector);
    if (el) el.textContent = value !== null ? value : "—";
  };

  safeSetText('[data-value="total-reports"]', metricsData.totalReports);
  safeSetText('[data-value="active-issues"]', metricsData.activeIssues);
  safeSetText('[data-value="resolved-issues"]', metricsData.resolvedIssues);
  safeSetText('[data-value="critical-alerts"]', metricsData.criticalAlerts);
}

async function loadRecentActivity() {
  const activities = [];

  const listContainer = document.getElementById("activity-list");
  if (!listContainer) return;

  const skeleton = document.getElementById("activity-skeleton");
  const empty = document.getElementById("activity-empty");
  const items = document.getElementById("activity-items");

  if (skeleton) skeleton.classList.add("hidden");

  if (activities.length === 0) {
    listContainer.setAttribute("data-status", "empty");
    if (empty) empty.classList.remove("hidden");
  } else {
    listContainer.setAttribute("data-status", "loaded");
    if (items) {
      items.classList.remove("hidden");
      activities.forEach((activity) => {
        const item = createActivityItem(activity);
        items.appendChild(item);
      });
    }
  }
}

function createActivityItem(activity) {
  const div = document.createElement("div");
  div.className = "px-6 py-4 flex items-start space-x-4";
  div.setAttribute("data-activity-id", activity.id);

  const statusColors = {
    critical: "bg-red-400",
    warning: "bg-yellow-400",
    info: "bg-blue-400",
    success: "bg-green-400",
  };

  div.innerHTML = `
        <div class="w-2 h-2 mt-2 rounded-full ${
          statusColors[activity.severity] || "bg-gray-600"
        }"></div>
        <div class="flex-1 min-w-0">
            <p class="text-sm text-gray-200">${escapeHtml(activity.message)}</p>
            <div class="mt-1 flex items-center space-x-3">
                <span class="text-xs text-gray-500">${escapeHtml(
                  activity.timestamp
                )}</span>
                <span class="px-2 py-0.5 text-xs font-medium rounded ${getBadgeClass(
                  activity.status
                )}">
                    ${escapeHtml(activity.status)}
                </span>
            </div>
        </div>
    `;

  return div;
}

function getBadgeClass(status) {
  const classes = {
    new: "bg-blue-900/40 text-blue-400",
    "in-progress": "bg-yellow-900/40 text-yellow-400",
    resolved: "bg-green-900/40 text-green-400",
    closed: "bg-gray-800 text-gray-400",
  };
  return classes[status] || "bg-gray-800 text-gray-400";
}

function switchTab(tabName) {
  const reportsView = document.getElementById("view-reports");
  const geminiView = document.getElementById("view-gemini");

  if (!reportsView || !geminiView) return;

  reportsView.classList.add("hidden");
  geminiView.classList.add("hidden");

  const inactiveClass =
    "px-4 py-2 text-sm font-medium rounded-lg text-neutral-400 hover:text-white hover:bg-neutral-800 transition-all cursor-pointer flex items-center gap-2";
  const activeClass =
    "px-4 py-2 text-sm font-medium rounded-lg bg-neutral-800 text-white shadow-sm border border-neutral-700 transition-all cursor-default flex items-center gap-2";

  const btnReports = document.getElementById("tab-btn-reports");
  const btnGemini = document.getElementById("tab-btn-gemini");

  if (btnReports) btnReports.className = inactiveClass;
  if (btnGemini) btnGemini.className = inactiveClass;

  document.getElementById("view-" + tabName).classList.remove("hidden");

  if (tabName === "reports") {
    if (btnReports) btnReports.className = activeClass;
  } else {
    if (btnGemini) btnGemini.className = activeClass;
    setTimeout(() => {
      const input = document.getElementById("gemini-prompt");
      if (input) {
        input.focus();
        input.style.height = "auto";
        input.style.height = input.scrollHeight + "px";
      }
    }, 100);
  }
}

function setStatusAndSubmit(statusVal) {
  const input = document.getElementById("statusInput");
  const form = document.getElementById("filterForm");
  if (input && form) {
    input.value = statusVal;
    form.submit();
  }
}

function askAboutReport(id, title, category) {
  switchTab("gemini");
  const inputField = document.getElementById("gemini-prompt");

  if (inputField) {
    inputField.value = `Regarding Report #${id} ("${title}") in category "${category}":
    As a student, what can I personally do right now while this issue is unresolved?
    Structure your answer with these exact headers(keep bullet points short and concise):
    1. Precautions
    2. Alternatives
    3. Avoid
    4. Awareness`;
    inputField.style.height = "auto";
    inputField.style.height = inputField.scrollHeight + "px";
    inputField.focus();
  }
}

function validateFile(input) {
  const file = input.files[0];
  const labelMain = document.getElementById("file-label-main");
  const labelSub = document.getElementById("file-label-sub");
  const previewIcon = document.getElementById("file-icon");

  if (!file) {
    labelMain.innerText = "Click to upload or drag and drop";
    labelSub.innerText = "PNG, JPG, JPEG (max. 2MB)";
    labelSub.classList.remove("text-red-500");
    previewIcon.classList.remove("text-blue-500");
    previewIcon.classList.add("text-neutral-400");
    return;
  }

  const maxSize = 2 * 1024 * 1024; // 2MB
  if (file.size > maxSize) {
    input.value = "";
    labelMain.innerText = "File too large!";
    labelSub.innerText = "Please select a file under 2MB";
    labelSub.classList.add("text-red-500");
    previewIcon.classList.remove("text-blue-500");
    previewIcon.classList.add("text-neutral-400");
    return;
  }

  labelMain.innerText = file.name;
  labelSub.innerText = (file.size / 1024 / 1024).toFixed(2) + " MB";
  labelSub.classList.remove("text-red-500");
  previewIcon.classList.add("text-blue-500");
  previewIcon.classList.remove("text-neutral-400");
}

function useCurrentLocation() {
  if (!navigator.geolocation) {
    alert("Geolocation is not supported by your browser.");
    return;
  }

  const locInput = document.getElementById("locationInput");
  if (!locInput) return;

  locInput.placeholder = "Fetching location...";

  navigator.geolocation.getCurrentPosition(
    function (position) {
      const lat = position.coords.latitude;
      const lng = position.coords.longitude;
      const mapsLink = `https://www.google.com/maps?q=${lat},${lng}`;
      locInput.value = mapsLink;
    },
    function (error) {
      alert("Unable to retrieve your location.");
      locInput.placeholder = "Paste Google Maps link or enter address...";
    },
    { enableHighAccuracy: true, timeout: 10000 }
  );
}

document.addEventListener("DOMContentLoaded", () => {
  loadDashboardMetrics();
  setTimeout(() => loadRecentActivity(), 500);

  const textarea = document.getElementById("gemini-prompt");
  if (textarea) {
    textarea.addEventListener("input", function () {
      this.style.height = "auto";
      this.style.height = this.scrollHeight + "px";
    });
  }
});

function parseMarkdown(text) {
  if (!text) return "";

  let cleanText = text
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>")
    .replace(/\*(.*?)\*/g, "<em>$1</em>");

  const lines = cleanText.split("\n");

  let formattedHTML = "";

  lines.forEach((line) => {
    line = line.trim();

    if (!line) return;

    if (/^(\d+\.|[A-Z]).*?:$/.test(line) || line.startsWith("###")) {
      let content = line.replace(/^###\s*/, "");
      formattedHTML += `<div class="text-white font-bold mt-4 mb-1 text-sm">${content}</div>`;
    } else if (/^[\-\*]\s+/.test(line)) {
      let content = line.replace(/^[\-\*]\s+/, "");
      formattedHTML += `
                <div class="flex items-start ml-2 mb-1">
                    <span class="text-blue-400 mr-2 mt-1.5 leading-none" style="font-size: 6px;">●</span>
                    <span class="text-neutral-300 text-sm leading-snug">${content}</span>
                </div>`;
    } else {
      formattedHTML += `<div class="text-neutral-300 mb-1 text-sm leading-snug">${line}</div>`;
    }
  });

  return formattedHTML;
}

function escapeHtml(str) {
  if (!str) return "";
  const div = document.createElement("div");
  div.textContent = str;
  return div.innerHTML;
}

function appendUserMessage(text) {
  const c = document.getElementById("chat-container");
  c.insertAdjacentHTML(
    "beforeend",
    `
    <div class="flex gap-4 justify-end mb-4">
      <div class="max-w-[85%] bg-blue-600/20 border border-blue-500/20 rounded-2xl rounded-tr-none px-5 py-3 text-white text-sm">
        ${escapeHtml(text)}
      </div>
    </div>`
  );
  c.scrollTop = c.scrollHeight;
}

function appendGeminiMessage(text) {
  const c = document.getElementById("chat-container");
  const formattedHtml = parseMarkdown(text);

  c.insertAdjacentHTML(
    "beforeend",
    `
    <div class="flex gap-4 mb-4">
      <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-600 to-purple-600 flex-shrink-0 flex items-center justify-center mt-1">
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>
      </div>
      <div class="max-w-[90%] bg-neutral-700/50 border border-neutral-600 rounded-2xl rounded-tl-none px-5 py-4 text-neutral-200 text-sm">
        ${formattedHtml}
      </div>
    </div>`
  );
  c.scrollTop = c.scrollHeight;
}

function appendGeminiError(text) {
  const c = document.getElementById("chat-container");
  c.insertAdjacentHTML(
    "beforeend",
    `
    <div class="flex gap-4 mb-4">
       <div class="w-8 h-8 rounded-full bg-red-900/50 flex-shrink-0 flex items-center justify-center mt-1">
        <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <div class="max-w-[85%] bg-red-900/20 border border-red-700/30 rounded-2xl rounded-tl-none px-5 py-3 text-red-300 text-sm">
        ${escapeHtml(text)}
      </div>
    </div>`
  );
  c.scrollTop = c.scrollHeight;
}

function appendGeminiTyping() {
  const c = document.getElementById("chat-container");
  const id = "gemini-typing";
  if (document.getElementById(id)) return;

  c.insertAdjacentHTML(
    "beforeend",
    `
    <div id="${id}" class="flex gap-4 mb-4">
        <div class="w-8 h-8 rounded-full bg-neutral-700 flex-shrink-0 flex items-center justify-center mt-1 animate-pulse">
            <div class="w-2 h-2 bg-neutral-500 rounded-full"></div>
        </div>
        <div class="text-sm text-neutral-500 italic flex items-center h-10">Gemini is thinking...</div>
    </div>`
  );
  c.scrollTop = c.scrollHeight;
}

function removeGeminiTyping() {
  document.getElementById("gemini-typing")?.remove();
}

async function handleChatSubmit() {
  const input = document.getElementById("gemini-prompt");
  const message = input.value.trim();
  if (!message) return;

  appendUserMessage(message);
  input.value = "";
  input.style.height = "52px";

  appendGeminiTyping();

  try {
    const res = await fetch("./core/actions/user_gemini.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ prompt: message }),
    });

    removeGeminiTyping();
    const data = await res.json();

    if (!res.ok || data.error) {
      appendGeminiError(data.error || "Gemini failed to respond.");
      return;
    }

    appendGeminiMessage(data.reply);
  } catch (e) {
    removeGeminiTyping();
    appendGeminiError("Unable to connect to Gemini. Please try again later.");
  }
}
