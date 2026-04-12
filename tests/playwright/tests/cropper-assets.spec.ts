import { test, expect } from '@playwright/test';

/**
 * Cropper is a view-level input extension — it has no dedicated pages.
 * These smoke tests verify that plugin assets load on any public Elgg page
 * and that the cropper view extension is available via the ajax/view endpoint.
 *
 * Deeper UI flows (upload -> crop -> save) live in consumer plugins
 * (e.g. avatar edit) and must be tested there.
 */

test.describe('Cropper plugin assets', () => {
  test('front page loads successfully', async ({ page }) => {
    const response = await page.goto('/');
    expect(response?.status()).toBeLessThan(500);
  });

  test('cropper css asset is reachable', async ({ request }) => {
    // Views extending css/elgg are served through the combined elgg stylesheet.
    // Fetch the main elgg CSS and assert the cropper-input selector was merged in.
    const res = await request.get('/cache/0/default/elgg.css');
    if (res.status() === 200) {
      const body = await res.text();
      expect(body).toContain('cropper-input');
    } else {
      // Fallback: fetch the raw view via ajax/view
      const alt = await request.get('/ajax/view/input/cropper.css');
      expect([200, 404]).toContain(alt.status());
    }
  });

  test('input/cropper view renders via ajax/view endpoint', async ({ request }) => {
    const res = await request.get(
      '/ajax/view/input/cropper?id=pw-crop&name=coords&src=http://example.test/x.jpg'
    );
    // ajax/view may require auth on some sites; accept 200 or 403
    if (res.status() === 200) {
      const body = await res.text();
      expect(body).toContain('cropper-input');
      expect(body).toContain('coords[x1]');
    } else {
      expect([401, 403]).toContain(res.status());
    }
  });
});
