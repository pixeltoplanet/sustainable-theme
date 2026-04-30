/**
 * Grid Awareness – minimal frontend interactivity.
 *
 * The heavy lifting (API calls, caching, body classes, bar rendering) is
 * handled server-side by PHP. This script only adds:
 *  - Info panel toggle
 *  - Optional live refresh via the REST endpoint
 */

const REFRESH_INTERVAL_MS = 5 * 60 * 1000; // 5 minutes

declare global {
  interface Window {
    sustainableGridSettings?: {
      enabled: boolean;
      apiUrl: string;
      level: string;
    };
  }
}

function initGridAwareness(): void {
  const bar = document.getElementById("grid-aware-bar");
  if (!bar) return;

  // Info panel toggle
  const infoBtn = bar.querySelector<HTMLButtonElement>(
    "[data-grid-info-toggle]",
  );
  const infoPanel = bar.querySelector<HTMLElement>(
    ".grid-aware-bar__info-panel",
  );

  if (infoBtn && infoPanel) {
    infoBtn.addEventListener("click", () => {
      const isHidden = infoPanel.hasAttribute("hidden");
      if (isHidden) {
        infoPanel.removeAttribute("hidden");
      } else {
        infoPanel.setAttribute("hidden", "");
      }
    });
  }

  // Placeholder "Load image" buttons
  document.addEventListener("click", (e) => {
    const btn = (e.target as HTMLElement).closest<HTMLButtonElement>(
      "[data-grid-load-img]",
    );
    if (!btn) return;

    const placeholder = btn.closest<HTMLElement>(".grid-aware-placeholder");
    if (!placeholder) return;

    const encoded = placeholder.dataset.originalImg;
    if (!encoded) return;

    try {
      const imgHtml = atob(encoded);
      placeholder.insertAdjacentHTML("afterend", imgHtml);
      placeholder.remove();
    } catch {
      placeholder.remove();
    }
  });

  // Blurred images: click to load the full-resolution version
  document.addEventListener("click", (e) => {
    const img = (e.target as HTMLElement).closest<HTMLImageElement>(
      "img.grid-aware-blurred",
    );
    if (!img || img.classList.contains("grid-aware-blurred--loaded")) return;

    const fullSrc = img.dataset.fullSrc;
    if (!fullSrc) return;

    const fullSrcset = img.dataset.fullSrcset;
    const fullSizes = img.dataset.fullSizes;

    if (fullSrcset) {
      img.srcset = fullSrcset;
      delete img.dataset.fullSrcset;
    }
    if (fullSizes) {
      img.sizes = fullSizes;
      delete img.dataset.fullSizes;
    }

    img.src = fullSrc;
    delete img.dataset.fullSrc;
    img.classList.remove("grid-aware-blurred");
    img.classList.add("grid-aware-blurred--loaded");
  });

  // Periodic refresh from REST endpoint (updates the bar text + body class
  // without a full page reload, useful for long-lived tabs).
  const settings = window.sustainableGridSettings;
  if (!settings?.enabled || !settings.apiUrl) return;

  setInterval(async () => {
    try {
      const res = await fetch(settings.apiUrl);
      if (!res.ok) return;

      const json = await res.json();
      if (!json.success || !json.data) return;

      const { level, zone_name, message } = json.data;

      // Update body class
      document.body.classList.remove(
        "grid-intensity-low",
        "grid-intensity-medium",
        "grid-intensity-high",
      );
      document.body.classList.add(`grid-intensity-${level}`);

      // Update bar modifier
      bar.className = `grid-aware-bar grid-aware-bar--${level}`;

      // Update text
      const msgEl = bar.querySelector(".grid-aware-bar__message");
      if (msgEl) msgEl.textContent = message;

      const zoneEl = bar.querySelector(".grid-aware-bar__zone span");
      if (zoneEl) zoneEl.textContent = zone_name;
    } catch {
      // Silently ignore refresh failures
    }
  }, REFRESH_INTERVAL_MS);
}

document.addEventListener("DOMContentLoaded", initGridAwareness);

export { initGridAwareness };
