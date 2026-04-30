# cropper — Architecture (Elgg 5.x)

## Plugin Summary

`cropper` is a UI utility plugin that provides an image-cropping form input widget for Elgg 5.x.
It extends the core `input/file` view with a cropper overlay, allowing consumers to accept a file
upload alongside crop coordinates in a single form field.

Other plugins use it by passing `use_cropper => true` (or a config array) to `elgg_view('input/file', [...])`.

## Directory Structure

```
cropper/
├── classes/Cropper/
│   └── Views.php            — Event handler: adds CSS class to file input view vars
├── docker/                  — Per-plugin Elgg 5.x test stack
│   ├── docker-compose.yml
│   ├── Dockerfile           — PHP 8.2 + Elgg ~5.1.0
│   ├── elgg-composer.json   — Site-level composer (includes asset-packagist.org)
│   └── elgg-install.sh      — Install + activate script
├── languages/
│   └── en.php               — English strings (cropper:instructions)
├── tests/
│   ├── phpunit.xml
│   ├── bootstrap.php
│   └── phpunit/integration/Cropper/
│       ├── ViewsTest.php        — Unit tests for the event handler
│       └── ViewExtensionsTest.php — Integration tests for view rendering
├── views/default/
│   ├── elements/input/file/
│   │   └── cropper.php      — File input extension: renders cropper widget when use_cropper is set
│   └── input/
│       ├── cropper.php      — Cropper widget view (image + hidden coord inputs + JS init)
│       └── cropper.css.php  — Vendor CSS (from bower-asset/cropper) + custom layout CSS
├── composer.json
└── elgg-plugin.php
```

## Registered Events

In Elgg 5.x, hooks and events are unified under the `'events'` key. The
`view_vars` event is the 5.x equivalent of the 4.x `view_vars` hook.

| Event | Type | Handler | Description |
|-------|------|---------|-------------|
| `view_vars` | `input/file` | `Cropper\Views::fileInputViewVars` | Adds `file-input-has-cropper` CSS class and ensures the input has an `id` attribute when `use_cropper` is set |

## View Extensions

| Base View | Extension View | Description |
|-----------|---------------|-------------|
| `input/file` | `elements/input/file/cropper` | Injects the cropper widget below the file input |
| `css/elgg` | `input/cropper.css` | Loads cropper vendor CSS + layout styles |

## Views File Mapping (Elgg 5.x)

| View | Source File | Description |
|------|-------------|-------------|
| `js/cropper.js` | `vendor/bower-asset/cropper/dist/cropper.min.js` | Fengyuan Chen's cropper.js 2.1.x AMD module |

## Routes / Actions

None. This is a pure UI utility plugin.

## Dependencies

- `php: >=8.2`
- `elgg/elgg: ^5.0`
- `bower-asset/cropper: ~2.1` via [asset-packagist.org](https://asset-packagist.org)
  - Must be installed with `composer install` in the plugin directory
  - Provides the cropper.js AMD module and vendor CSS

## Consumer API

```php
// Basic usage — adds cropper overlay with default 1:1 ratio
echo elgg_view('input/file', [
    'name'        => 'avatar',
    'id'          => 'avatar-upload',
    'use_cropper' => true,
]);

// With custom ratio and named coord input
echo elgg_view('input/file', [
    'name'        => 'banner',
    'id'          => 'banner-upload',
    'use_cropper' => [
        'ratio' => 16/9,
        'name'  => 'banner_coords',  // output: banner_coords[x1], [y1], [x2], [y2]
    ],
]);
```

## Migration Notes (4.x → 5.x)

- Bumped `composer.json` constraints: `php >=8.2`, `elgg/elgg ^5.0`
- Migrated `'hooks'` → `'events'` key in `elgg-plugin.php` (Elgg 5.x unified
  the hooks and events systems)
- Updated `Cropper\Views::fileInputViewVars()` parameter type hint from
  `\Elgg\Hook` to `\Elgg\Event` and renamed the parameter from `$hook` to
  `$event`
- Updated PHPUnit test mock builder to instantiate `\Elgg\Event` instead of
  `\Elgg\Hook` (with `disableOriginalConstructor` since `\Elgg\Event`
  requires runtime arguments)
- Bumped Docker stack: `php:7.4-apache` → `php:8.2-apache`,
  `mysql:5.7` → `mysql:8.0`, site composer `elgg/elgg 4.3.6` → `~5.1.0`,
  compose project name `${PLUGIN_ID}-elgg4` → `${PLUGIN_ID}-elgg5`

## Migration Notes (3.x → 4.x)

- Removed `start.php` and `autoloader.php`; logic moved to class-based hook handler
- Removed `manifest.xml`; metadata now lives in `elgg-plugin.php` under `'plugin'` key
- Updated `composer.json`: `php >=7.4`, `elgg/elgg ^4.0`, `installer ^2.0`
- Added asset-packagist.org repository for bower-asset support
- Removed `views/default/js/cropper.js.php` (readfile-based); replaced with Elgg 4.x `'views'`
  file-mapping in `elgg-plugin.php` pointing directly to the vendor minified file
- Updated `input/cropper.css.php` to use `__DIR__`-relative path to vendor CSS
- Fixed bug: `$height = $height * $ratio` referenced undefined `$height`; changed to `200 * $ratio`
- Fixed: replaced `md5(serialize($vars))` HTML ID fallback with `uniqid()`
