# Replace Gravity Forms Buttons with Block Buttons

Replace Gravity Forms button markup with actual WordPress block buttons rendered through Gutenberg for seamless block theme integration.

> **Part of the Groundworx Snippets collection** - Professional WordPress code for developers who value quality and maintainability. Created by Johanne Courtright at [Groundworx](https://groundworx.dev).

## Overview

This PHP class intercepts Gravity Forms button output and replaces it with real WordPress block button markup that gets rendered through `do_blocks()`. The result is true Gutenberg buttons that inherit all your theme's block button styles, variations, and customizations - not just CSS classes applied to form buttons.

## Key Features

- **🎨 Real Block Buttons** - Uses `do_blocks()` to render actual WordPress buttons, not just styled inputs
- **🎯 Theme Integration** - Buttons automatically inherit your theme's button styles
- **🔧 Configurable** - Easy customization of button styles via configuration array
- **⚡ Modern WordPress** - Uses WP_HTML_Processor for safe HTML manipulation
- **🎭 Flexible** - Separate styling for primary (submit/next) and secondary (previous) actions

## What Gets Replaced

### Before (Gravity Forms default)
```html
<input type="submit" class="button gform-button" value="Submit">
```

### After (Block button)
```html
<!-- wp:button -->
<div class="wp-block-button">
    <button class="wp-block-button__link wp-element-button" type="submit">Submit</button>
</div>
<!-- /wp:button -->
```

The button is now a real WordPress block that gets all your theme's button styling automatically.

## Requirements

- Gravity Forms 2.5+
- WordPress 6.4+ (for WP_HTML_Processor)
- PHP 7.4+

## Installation

### Option 1: Add to Theme

Add to your theme's `functions.php`:

```php
<?php
// Copy the entire class code here
namespace Groundworx\Snippets;

class GravityForms_Block_Buttons {
    // ... class code ...
}

// Initialize with default settings
GravityForms_Block_Buttons::init();
```

### Option 2: Create a Plugin

Create a simple plugin file:

```php
<?php
/**
 * Plugin Name: Gravity Forms Block Buttons
 * Description: Replaces Gravity Forms buttons with WordPress block buttons
 * Version: 1.0.0
 * Requires PHP: 7.4
 * Requires at least: 6.4
 */

// Copy the class code here
namespace Groundworx\Snippets;

class GravityForms_Block_Buttons {
    // ... class code ...
}

// Initialize
GravityForms_Block_Buttons::init();
```

### Option 3: Code Snippets Plugin

If using a code snippets plugin (WPCode, Code Snippets, etc.), paste the entire class code including the namespace.

## Configuration

### Default Usage

```php
// Uses default settings:
// - Submit/Next buttons: No special style (inherits theme default)
// - Previous buttons: Outline style
GravityForms_Block_Buttons::init();
```

### Custom Configuration

```php
GravityForms_Block_Buttons::init( [
    'primary_style' => 'is-style-fill',
    'secondary_style' => 'is-style-outline',
    'primary_classes' => 'my-custom-class',
    'secondary_classes' => 'another-class'
] );
```

### Available Button Styles

Common WordPress block button styles (depends on your theme):
- `''` - Default/fill (empty string)
- `'is-style-outline'` - Outline style
- `'is-style-fill'` - Explicitly filled
- Custom styles defined by your theme

## Button Types

### Primary Actions (Submit & Next)
Forward-moving actions that advance the form:
- Submit button (final form submission)
- Next button (multi-page forms)

**Default style:** None (inherits theme default)

### Secondary Actions (Previous)
Backward-moving actions:
- Previous button (multi-page forms)

**Default style:** `is-style-outline`

This creates a visual hierarchy where forward actions are prominent and backward actions are secondary.

## Advanced Usage

### Per-Form Customization

Use Gravity Forms hooks to customize specific forms:

```php
// Different styles for different forms
add_action( 'gform_pre_render', function( $form ) {
    if ( $form['id'] === 5 ) {
        // Contact form gets filled buttons
        GravityForms_Block_Buttons::init( [
            'primary_style' => 'is-style-fill',
            'secondary_style' => 'is-style-outline',
        ] );
    }
    return $form;
} );
```

### Conditional Styling

```php
// Use different styles based on conditions
$button_config = is_user_logged_in() 
    ? [ 'primary_style' => 'is-style-fill' ]
    : [ 'primary_style' => 'is-style-outline' ];

GravityForms_Block_Buttons::init( $button_config );
```

## How It Works

### The Replacement Process

1. **Intercept** - Hooks into Gravity Forms button filters before rendering
2. **Parse** - Uses `WP_HTML_Processor` to safely parse button HTML
3. **Transform** - Extracts attributes and rebuilds as block button markup
4. **Render** - Passes through `do_blocks()` to render as real Gutenberg button
5. **Output** - Returns fully-rendered block button HTML

### Filters Used

- `gform_submit_button` - Submit buttons
- `gform_next_button` - Next buttons (multi-page)
- `gform_previous_button` - Previous buttons (multi-page)
- `gform_get_form_filter` - Form footer wrapper classes

### Footer Wrapper

The class also adds block button wrapper classes to form footers for proper layout:

```php
// Adds these classes to footer divs:
'wp-block-buttons'
'is-layout-flex'
'wp-block-buttons-is-layout-flex'
```

This ensures buttons lay out correctly using block theme spacing and alignment.

## Compatibility

### Works With
- ✅ Block themes
- ✅ Classic themes with block editor support
- ✅ Full Site Editing (FSE)
- ✅ Theme.json configurations
- ✅ Custom block button styles
- ✅ Multi-page forms
- ✅ AJAX-enabled forms

### Preserves
- ✅ All button attributes (id, name, onclick, etc.)
- ✅ Gravity Forms functionality
- ✅ Form validation
- ✅ Conditional logic
- ✅ Custom CSS classes from Gravity Forms
- ✅ Full-width button settings

## Styling

### Theme Integration

Buttons automatically inherit styles from your theme's block button configuration. No additional CSS needed.

**Example theme.json:**
```json
{
  "styles": {
    "blocks": {
      "core/button": {
        "color": {
          "background": "var(--wp--preset--color--primary)",
          "text": "var(--wp--preset--color--base)"
        },
        "border": {
          "radius": "0.5rem"
        }
      }
    }
  }
}
```

Gravity Forms buttons will automatically use these styles.

### Custom CSS

Target buttons with standard WordPress classes:

```css
/* All form buttons */
.gform_wrapper .wp-block-button__link {
    /* Your styles */
}

/* Submit buttons specifically */
.gform_footer .wp-block-button__link {
    /* Submit button styles */
}

/* Previous/Next buttons */
.gform-page-footer .wp-block-button__link {
    /* Navigation button styles */
}
```

## Pair With Block Theme Styles

This snippet pairs perfectly with the [Gravity Forms Block Theme Styles](../styles/) SCSS package for complete form integration:

**Together you get:**
- Block buttons (this snippet) ✅
- Block theme form styling (SCSS package) ✅
- Complete visual integration 🎯

## Troubleshooting

### Buttons not rendering as blocks
- ✅ Verify WordPress 6.4+ (required for WP_HTML_Processor)
- ✅ Check that snippet is loaded (add to functions.php or plugin)
- ✅ Clear all caches (WordPress, page cache, browser)

### Styles not applying
- ✅ Ensure your theme has block button styles defined
- ✅ Check theme.json for button configurations
- ✅ Verify button classes with browser inspector

### Multi-page forms broken
- ✅ Test with AJAX disabled first
- ✅ Check browser console for JavaScript errors
- ✅ Ensure Gravity Forms is up to date

### Conflicts with other plugins
- ✅ Disable other Gravity Forms styling plugins
- ✅ Check for JavaScript that targets `.gform-button`
- ✅ Use higher priority if needed: `init( [], 30 )`

## Performance

- **Minimal overhead** - Only processes button HTML, not entire form
- **No JavaScript** - Pure PHP/HTML solution
- **Cached** - Works with page caching
- **Efficient** - Uses native WordPress HTML processor

## Security

- **Escaping** - All output properly escaped (`esc_html`, `esc_attr`)
- **Safe HTML parsing** - Uses WordPress core HTML processor
- **No eval()** - No dynamic code execution
- **Namespaced** - Prevents conflicts with other code

## Migration

### From Custom Button CSS

If you currently style buttons with custom CSS, this snippet lets you remove that CSS and use your theme's button styles instead.

**Before:**
```css
.gform_button {
    background: #007cba;
    color: white;
    padding: 12px 24px;
    border-radius: 4px;
}
```

**After:**
```php
// Just enable the snippet - buttons use theme styles automatically
GravityForms_Block_Buttons::init();
```

## Examples

### Example 1: Default Setup
```php
// Simple - uses theme defaults
GravityForms_Block_Buttons::init();
```

### Example 2: All Outline Buttons
```php
GravityForms_Block_Buttons::init( [
    'primary_style' => 'is-style-outline',
    'secondary_style' => 'is-style-outline'
] );
```

### Example 3: Custom Classes
```php
GravityForms_Block_Buttons::init( [
    'primary_classes' => 'cta-button',
    'secondary_classes' => 'ghost-button'
] );
```

### Example 4: Full Width Submit
```php
// Gravity Forms already handles full-width setting
// This snippet preserves that functionality
// Just check "Full width" in form button settings
```

## Support & Related Projects

### Need Help?
Visit [Groundworx.dev](https://groundworx.dev) for:
- WordPress block theme development
- Custom Gutenberg blocks
- Gravity Forms integration
- Theme customization

### More Snippets
This is part of the **Groundworx Snippets** collection - professional, production-ready WordPress code snippets. Check out the full collection at [github.com/groundworx/snippets](https://github.com/groundworx-dev/wp-snippets).

## Author

Created by Johanne Courtright  
[Groundworx](https://groundworx.dev)

## License

GPL-2.0-or-later

## Version

1.0.0

---

**Related:** Pair this with [Gravity Forms Block Theme Styles](../styles/) for complete form + button integration with your block theme.
