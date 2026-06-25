# Updates & Debugging

The theme checks [GitHub Releases](https://github.com/pixeltoplanet/sustainable-theme/releases) for new versions via `plugin-update-checker`. The release zip **must include `vendor/`** — that directory contains the update library.

## Quick checklist

1. Installed theme folder is named `sustainable-theme`
2. `style.css` shows the expected `Version:` (e.g. `0.1.1`)
3. `vendor/autoload.php` exists on the server
4. Go to **Dashboard → Updates → Check Again**
5. A newer GitHub Release exists with a `sustainable-theme.zip` asset

## Enable debug logging

In `wp-config.php`:

```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

Then visit **Dashboard → Updates** and click **Check Again**. Inspect `wp-content/debug.log` for lines starting with `[Sustainable Theme Updates]`.

With `WP_DEBUG` on, `plugin-update-checker` also logs its own HTTP and version comparison details to the same log.

## Test GitHub API connectivity from the server

Run on the live server (SSH) or via WP-CLI on the site:

### WP-CLI (recommended)

```bash
wp eval '
$response = wp_remote_get("https://api.github.com/repos/pixeltoplanet/sustainable-theme/releases/latest", [
  "timeout" => 15,
  "headers" => ["Accept" => "application/vnd.github+json"],
]);
if (is_wp_error($response)) {
  echo "BLOCKED/FAILED: " . $response->get_error_message() . "\n";
} else {
  echo "HTTP " . wp_remote_retrieve_response_code($response) . "\n";
  $body = json_decode(wp_remote_retrieve_body($response), true);
  echo "Latest tag: " . ($body["tag_name"] ?? "unknown") . "\n";
}
'
```

| Result | Meaning |
| --- | --- |
| `HTTP 200` + tag name | GitHub API is reachable |
| `HTTP 403` | Rate limited (usually fine after cache) or blocked |
| `HTTP 404` | Repo private or wrong slug |
| `cURL error 6/7/28` | DNS, connection, or timeout — likely firewall/host block |

### curl from SSH

```bash
curl -sI "https://api.github.com/repos/pixeltoplanet/sustainable-theme/releases/latest" | head -5
```

Look for `HTTP/2 200`. Connection refused, timeout, or proxy errors indicate blocking.

## Test the installed update checker

```bash
wp eval '
$theme = wp_get_theme("sustainable-theme");
echo "Installed: " . $theme->get("Version") . "\n";
echo "Autoload: " . (is_readable(get_template_directory() . "/vendor/autoload.php") ? "yes" : "NO") . "\n";
delete_site_transient("update_themes");
wp_update_themes();
$updates = get_site_transient("update_themes");
if (!empty($updates->response["sustainable-theme"])) {
  print_r($updates->response["sustainable-theme"]);
} else {
  echo "No update offered.\n";
}
'
```

## Common causes

| Symptom | Likely cause |
| --- | --- |
| No update, autoload missing | Installed from git or a release zip without `vendor/` |
| No update, autoload present | Already on latest version, or cache not refreshed |
| Worked on 0.1.1, broke after 0.1.2 | 0.1.2 zip excluded `vendor/` — update to a release that includes it |
| Intermittent failures | GitHub API rate limit (60 req/hr unauthenticated per IP) |

## Force a fresh check

```bash
wp transient delete update_themes
wp cron event run wp_update_themes
```

Or in the admin: **Dashboard → Updates → Check Again**.
