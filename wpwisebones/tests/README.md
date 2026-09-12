# WPWiseBones integration tests

Small, dependency-free integration tests that run the theme against a real
WordPress install. There is no PHPUnit and no Composer step.

## Running

```
npm test
```

or directly:

```
php tests/run.php
WPWISEBONES_TEST_WP=/path/to/wordpress php tests/run.php
```

`run.php` looks for a WordPress root in this order:

1. `WPWISEBONES_TEST_WP`
2. `C:/Server/wplinkedin/.wp-sandbox` (the local sandbox)
3. three levels up, for when the theme already sits in `wp-content/themes/`

It copies this working copy of the theme into the host install, activates it,
runs each `test-*.php` in its own PHP process, then restores the original
active theme and deletes the copy. Restore is a shutdown function, so it runs
even if a test exits or fatals. Nothing is written to the host database except
the active-theme option.

If a theme directory of the same name already exists in the host install,
the runner refuses to overwrite it and exits.

## What is covered

| File | Covers |
| --- | --- |
| `test-dashboard-widget.php` | The System Info panel describes the theme truthfully. Regression cover for the `WPWISEBONES_LOCAL_ASSETS` bug (1.0.12), where the panel tested a constant the theme never defined and so always claimed `Assets: CDN (jsDelivr)`. Also asserts the render raises no PHP notices and emits valid UTF-8. |
| `test-enqueue.php` | Every enqueued asset resolves to the local `assets/vendor` directory - no external host, no CDN - which is what makes the widget's `Local vendor` label true rather than merely hard-coded. |

## Adding a test

Create `tests/test-<name>.php`:

```php
require_once __DIR__ . '/lib.php';
wpwisebones_test_bootstrap();

wpwisebones_test_group( 'Something' );
wpwisebones_test_check( 'behaves', $actual === $expected );

wpwisebones_test_finish();
```

`wpwisebones_test_bootstrap()` loads WordPress and asserts the theme is active.
`wpwisebones_test_finish()` prints the tally, reports any PHP notice raised
during the run as a failure, and sets the exit code.

`tests/` is excluded from the distributable zip by `.distignore` and skipped by
`scripts/preflight.js`.
