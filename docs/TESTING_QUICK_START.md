# Quick Start: Testing Sustainability Settings

## Method 1: Using the Admin Interface (Easiest) ⭐

1. **Go to WordPress Admin**
   - Navigate to: `Sustainable theme` → `Sustainability` in your WordPress admin menu

2. **Scroll to the bottom**
   - You'll see a new "Test Settings" panel

3. **Click "Run Tests"**
   - The tests will run automatically
   - You'll see a summary with:
     - Total tests
     - Passed (green)
     - Partial (yellow) 
     - Not tested (gray)
     - Success rate percentage

4. **View Detailed Results**
   - Click "View Detailed Results" to see each setting's status
   - Green = Working correctly
   - Yellow = Partially working (may need implementation)
   - Gray = Not enabled/not tested

## Method 2: Using Browser Console

1. **Open your WordPress admin page**
2. **Open Browser DevTools** (F12 or Cmd+Option+I)
3. **Go to Console tab**
4. **Run this command**:

```javascript
fetch('/wp-json/sustainable-theme/v1/test-settings', {
  headers: {
    'X-WP-Nonce': wpApiSettings.nonce
  }
})
.then(r => r.json())
.then(data => {
  console.log('Test Summary:', data.summary);
  console.log('Results:', data.results);
  return data;
});
```

## Method 3: Using cURL (Terminal)

1. **Get your WordPress nonce**:
   - Open WordPress admin in browser
   - Open DevTools → Console
   - Type: `wpApiSettings.nonce`
   - Copy the value

2. **Run the test**:

```bash
curl -X GET "https://yoursite.com/wp-json/sustainable-theme/v1/test-settings" \
  -H "X-WP-Nonce: YOUR_NONCE_HERE" \
  -H "Content-Type: application/json"
```

3. **Pretty print JSON** (optional):

```bash
curl -X GET "https://yoursite.com/wp-json/sustainable-theme/v1/test-settings" \
  -H "X-WP-Nonce: YOUR_NONCE_HERE" \
  -H "Content-Type: application/json" | jq .
```

## Method 4: Direct Browser URL

1. **Get your nonce** (see Method 3, step 1)
2. **Open this URL in your browser** (replace YOUR_NONCE):

```
https://yoursite.com/wp-json/sustainable-theme/v1/test-settings
```

3. **Add the nonce header** using a browser extension like:
   - ModHeader (Chrome)
   - Header Editor (Firefox)

   Set header: `X-WP-Nonce` = `YOUR_NONCE`

## Understanding Test Results

### Status Types:

- **✅ pass** (Green): Setting is enabled and working correctly
- **⚠️ partial** (Yellow): Setting is enabled but may not be fully implemented
- **⚪ not_tested** (Gray): Setting is not enabled, so it wasn't tested

### What Gets Tested:

The automated tester checks:
- ✅ Settings are saved correctly
- ✅ WordPress hooks/actions are registered/removed
- ✅ Filters are properly applied  
- ✅ Scripts/styles are deregistered
- ✅ Constants are set correctly

### What Doesn't Get Tested:

The automated tester **cannot** verify:
- ❌ Frontend HTML output (use manual testing)
- ❌ Network requests (use browser DevTools)
- ❌ Visual changes (use manual inspection)
- ❌ Performance impact (use PageSpeed tools)

## Next Steps After Testing

1. **If you see "partial" results**: 
   - Check `docs/TESTING.md` for manual verification steps
   - Some settings may need backend implementation

2. **If you see "not_tested"**:
   - Enable the setting in the admin panel
   - Run tests again

3. **For frontend verification**:
   - Use browser DevTools to inspect page source
   - Check Network tab for removed scripts/styles
   - See `docs/TESTING.md` for detailed manual tests

## Troubleshooting

### "Failed to run tests" error
- Check that you're logged in as admin
- Verify the nonce is correct
- Check browser console for errors

### Tests show "partial" for everything
- Some settings may not be fully implemented yet
- Check `includes/class-sustainability-optimizer.php`
- See `docs/TESTING.md` for implementation status

### Can't find the test button
- Make sure you're on the Sustainability page
- Clear browser cache
- Rebuild the theme: `bun run build`

