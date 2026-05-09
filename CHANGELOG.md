# 6.0.0 (2026-05-09)

### Migration: Elgg 5.x → 6.x

- Bumped `composer.json`: `php >=8.1`, `elgg/elgg ~6.1.0`, added `ext-intl`; version `6.0.0`
- Converted `views/default/js/input/cropper.js` from AMD to ES module (`import`/`export default`)
- Replaced inline AMD `require(['input/cropper'], cb)` in `input/cropper.php` with `<script type="module">` ES import
- Docker stack updated to Elgg 6.x (PHPUnit ^10.5)

---

# 5.0.0 (2026-04-30)

### Migration: Elgg 4.x → 5.x

- Bumped `composer.json` constraints: `php >=8.2`, `elgg/elgg ^5.0`
- Migrated `'hooks'` → `'events'` key in `elgg-plugin.php` (Elgg 5.x unified
  the hooks and events systems into a single `'events'` registry)
- Replaced `\Elgg\Hook` parameter type hint with `\Elgg\Event` in
  `Cropper\Views::fileInputViewVars()`
- Updated PHPUnit `ViewsTest` to mock `\Elgg\Event` instead of `\Elgg\Hook`
- Bumped Docker stack: `php:7.4-apache` → `php:8.2-apache`,
  `mysql:5.7` → `mysql:8.0`, site composer `elgg/elgg 4.3.6` → `~5.1.0`

---

# 4.0.0 (2026-04-16)

### Migration: Elgg 3.x → 4.x

- Removed `start.php` / `autoloader.php`; replaced with class-based `Cropper\Views` hook handler
- Removed `manifest.xml`; all plugin metadata now in `elgg-plugin.php` under `'plugin'` key
- Updated `composer.json` to Elgg 4.x constraints (`php >=7.4`, `elgg/elgg ^4.0`, `installer ^2.0`)
- Switched vendor JS asset to Elgg 4.x `'views'` file-mapping (direct path to bower-asset/cropper)
- Removed `js/cropper.js.php` readfile view; JS now served via `elgg-plugin.php` views mapping
- Updated CSS view to use `__DIR__`-relative vendor path
- Fixed: undefined `$height` bug in `input/cropper.php` height calculation
- Fixed: replaced `md5(serialize($vars))` HTML ID fallback with `uniqid()`

---

<a name="1.1.0"></a>
# [1.1.0](https://github.com/hypeJunction/Elgg-cropper/compare/1.0.2...v1.1.0) (2016-01-25)




<a name="1.0.2"></a>
## [1.0.2](https://github.com/hypeJunction/Elgg-cropper/compare/1.0.1...v1.0.2) (2015-12-29)


### Bug Fixes

* **cropper:** set viewMode to avoid subpixel issues in image display ([ecb7b25](https://github.com/hypeJunction/Elgg-cropper/commit/ecb7b25))



<a name="1.0.1"></a>
## [1.0.1](https://github.com/hypeJunction/Elgg-cropper/compare/1.0.0...v1.0.1) (2015-12-29)


### Bug Fixes

* **input:** allow ratio to be empty ([3e7fcc0](https://github.com/hypeJunction/Elgg-cropper/commit/3e7fcc0))



<a name="1.0.0"></a>
# [1.0.0](https://github.com/hypeJunction/Elgg-cropper/compare/1.0.5...v1.0.0) (2015-12-16)


### Features

* **grunt:** improved release automation ([a28549a](https://github.com/hypeJunction/Elgg-cropper/commit/a28549a))
* **support:** support earlier Elgg versions ([552dbdf](https://github.com/hypeJunction/Elgg-cropper/commit/552dbdf))



<a name="1.0.5"></a>
## 1.0.5 (2015-12-04)


### Bug Fixes

* **grunt:** update release process ([780ba7f](https://github.com/hypeJunction/Elgg-cropper/commit/780ba7f))

### Features

* **releases:** initial commit ([54cb3a1](https://github.com/hypeJunction/Elgg-cropper/commit/54cb3a1))



<a name="1.0.4"></a>
## 1.0.4 (2015-12-04)


### Bug Fixes

* **grunt:** update release process ([780ba7f](https://github.com/hypeJunction/cropper/commit/780ba7f))

### Features

* **releases:** initial commit ([54cb3a1](https://github.com/hypeJunction/cropper/commit/54cb3a1))



<a name="1.0.3"></a>
## 1.0.3 (2015-12-04)


### Bug Fixes

* **grunt:** update release process ([780ba7f](https://github.com/hypeJunction/cropper/commit/780ba7f))

### Features

* **releases:** initial commit ([54cb3a1](https://github.com/hypeJunction/cropper/commit/54cb3a1))



