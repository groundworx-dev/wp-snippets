# Gravity Forms Block Theme Styles

Professional, scalable SCSS for integrating Gravity Forms into WordPress block themes using native design tokens.

> **Part of the Groundworx Snippets collection** - Professional WordPress code for developers who value quality and maintainability. Created by Johanne Courtright at [Groundworx](https://groundworx.dev).

## Overview

A complete styling system for theme developers who want to integrate Gravity Forms seamlessly with WordPress block themes. Built on a scalable em-based architecture using CSS custom properties for consistent, maintainable form styling.

## Key Features

- **🎨 CSS Custom Properties** - Easy customization via CSS variables
- **📏 Truly Scalable** - All measurements use `em` units for proportional scaling
- **✨ Modern Styling** - Mask-based checkbox/radio for crisp rendering at any size
- **♿ Accessible** - Proper font sizing, keyboard navigation, screen reader support
- **🎯 Non-Invasive** - Minimal overrides, works alongside Gravity Forms themes
- **🔧 Customizable** - Override globally or per-form with CSS variables
- **⚡ Works Out of the Box** - Sensible defaults, no configuration required

## Who This Is For

**Theme Developers** who want to:
- Integrate Gravity Forms seamlessly into block themes
- Use CSS custom properties for flexible, maintainable styling
- Provide clients with forms that work beautifully out of the box
- Build scalable form styling systems with minimal code

**Not a plugin** - This is SCSS source code for theme developers to integrate into their themes.

## Files

```
styles/
├── _mixins.scss                       # Reusable form styling mixins
├── _forms.scss                        # CSS variables and universal form styles
└── gravity-forms-block-theme.scss     # Complete Gravity Forms integration
```

## Requirements

- Gravity Forms 2.5+
- WordPress 6.4+ (block theme with design tokens)
- SCSS compiler (or use compiled CSS)

## Quick Start

### 1. Add to Your Theme

Copy the SCSS files to your theme:

```
your-theme/
└── assets/
    └── scss/
        └── gravity-forms/
            ├── _mixins.scss
            ├── _forms.scss
            └── gravity-forms-block-theme.scss
```

### 2. Compile SCSS

Add to your theme's main SCSS file or compile separately:

```scss
// In your theme's main.scss
@import 'gravity-forms/gravity-forms-block-theme';
```

Or compile as a separate file:

```bash
sass assets/scss/gravity-forms/gravity-forms-block-theme.scss assets/css/gravity-forms.css
```

### 3. Enqueue in Your Theme

```php
// In your theme's functions.php
function my_theme_enqueue_gravity_forms_styles() {
    if ( class_exists( 'GFForms' ) ) {
        wp_enqueue_style(
            'theme-gravity-forms',
            get_stylesheet_directory_uri() . '/assets/css/gravity-forms.css',
            array(),
            wp_get_theme()->get( 'Version' )
        );
    }
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_gravity_forms_styles' );
```

### 4. Configure Gravity Forms

#### Global Settings
1. Go to **Forms → Settings → Styles & Layouts**
2. Under **Default Form Theme**, select **"Gravity Forms 2.5 Theme"**

#### Per-Form Settings
1. Edit your form
2. Go to **Form Settings → Form Styles**
3. Under **Form Theme**, select **"Inherit from default (Gravity Forms 2.5 Theme)"**

## The Scalable Design System

### How It Works

All measurements use `em` units relative to `font-size`, creating a truly scalable system. Change one property, and everything scales proportionally.

```scss
// Want bigger forms?
:root .gform_wrapper.gravity-theme {
  font-size: 1.5rem; // Everything scales: inputs, buttons, spacing, icons
}

// Smaller forms?
:root .gform_wrapper.gravity-theme {
  font-size: 0.875rem; // Everything scales down proportionally
}
```

### What Scales

- Input padding and borders
- Checkbox and radio button sizes
- Icon buttons (+ and - in lists)
- Label and text sizing
- All spacing and margins
- Focus states and shadows

### Why This Matters

- **Responsive by nature** - No breakpoints needed for sizing
- **Context-aware** - Forms adapt to their container
- **Accessible** - Respects user font-size preferences
- **Maintainable** - One variable controls everything

## Usage Options

### Option 1: Complete Gravity Forms Styling (Recommended)

Use `gravity-forms-block-theme.scss` for full integration:

```scss
@import 'gravity-forms-block-theme';
```

Includes:
- Form input styling
- Gravity Forms-specific overrides
- Typography fixes
- Layout improvements

### Option 2: Universal Form Styling

Use `_forms.scss` to style all forms on your site:

```scss
@import 'forms';
```

**Important:** Remove the `*` selector if you only want to target Gravity Forms:

```scss
// In _forms.scss, change this:
:root .gform_wrapper.gravity-theme,
[data-form-theme="gravity-theme"],
* {

// To this:
:root .gform_wrapper.gravity-theme,
[data-form-theme="gravity-theme"] {
```

## Customization

The system works perfectly out of the box with sensible defaults. If you need to customize:

### Method 1: Edit Global Defaults

Edit the CSS custom properties in `_forms.scss`:

```scss
body {
    --form--input--text: #343434;              // Change input text color
    --form--input--background: #ffffff;        // Change input background
    --form--input--border--color: #aaaaaa;     // Change border color
    --form--input--border--radius: 0.5em;      // Add rounded corners
    // ... edit any variable
}
```

### Method 2: Per-Form Overrides

Target specific forms using their CSS class:

```scss
// For a specific form with custom class "contact-form"
:root .gform_wrapper.gravity-theme.contact-form {
    --form--input--text: #ff0000;
    --form--input--background: #f5f5f5;
    --form--input--border--color: #333333;
    --form--input--border--radius: 0.5em;
}

// For a newsletter form
:root .gform_wrapper.gravity-theme.newsletter-form {
    --form--input--text: #0066cc;
    --form--progressbar--foreground: #0066cc;
}
```

### Available CSS Custom Properties

#### Labels
```scss
--form--labels: currentColor;
--form--labels--required: currentColor;
```

#### Input Fields
```scss
--form--input--text: #343434;
--form--input--background: #ffffff;
--form--input--focus--color: #007cba;
--form--input--border--color: #aaaaaa;
--form--input--border--style: solid;
--form--input--border--width: 0.075em;
--form--input--border--radius: 0px;
--form--input--padding-x: 0.35em;
--form--input--padding-y: 0.5em;
--form--input--lineheight: inherit;
```

#### Select Dropdown
```scss
--form--select--arrow: url("data:image/svg+xml...");
--form--select--arrow--width: .95em;
```

#### Checkbox & Radio
```scss
--form--checkbox-radio--text: #ffffff;
--form--checkbox-radio--background: #007cba;
```

#### Progress Bar
```scss
--form--progressbar--background: #cdcdcd;
--form--progressbar--foreground: #007cba;
--form--progressbar--foreground--text: #ffffff;
```

## What Gets Styled

### Form Elements
- Text inputs (text, email, url, password, number, date, etc.)
- Textareas
- Select dropdowns (with custom SVG arrow)
- Checkboxes (with mask-based checkmark for crisp rendering)
- Radio buttons (with mask-based dot for crisp rendering)
- File uploads (with styled button)
- Multi-select fields

### Gravity Forms Specific
- Field labels and descriptions
- Progress bars
- Form field spacing
- Typography adjustments
- Layout fixes

## Compatibility

### Works With
- ✅ Gravity Forms 2.5+ theme framework
- ✅ WordPress block themes
- ✅ Page builders (Gutenberg)
- ✅ Custom themes using design tokens

### Does Not Interfere With
- ✅ Orbital theme (Gravity Forms' custom theme)
- ✅ Legacy form themes
- ✅ Custom CSS you've added
- ✅ Third-party Gravity Forms add-ons

## Examples

### Basic Implementation

```scss
// Compile and enqueue gravity-forms-block-theme.css
// Set Gravity Forms to use "Gravity Forms 2.5 Theme"
// Done! Forms work beautifully out of the box
```

### Custom Brand Colors

```scss
// In _forms.scss or your own CSS
body {
    --form--input--focus--color: #ff6600;
    --form--checkbox-radio--background: #ff6600;
    --form--progressbar--foreground: #ff6600;
}
```

### Rounded Inputs

```scss
body {
    --form--input--border--radius: 0.5em;
}
```

### Thicker Borders

```scss
body {
    --form--input--border--width: 2px;
}
```

### Per-Form Customization

```scss
// Contact form with blue accent
:root .gform_wrapper.gravity-theme.contact-form {
    --form--input--focus--color: #0066cc;
    --form--checkbox-radio--background: #0066cc;
}

// Newsletter form with green accent
:root .gform_wrapper.gravity-theme.newsletter-form {
    --form--input--focus--color: #00cc66;
    --form--checkbox-radio--background: #00cc66;
}
```

### Scale Forms by Context

```scss
// In your theme CSS (after compiling)
.sidebar .gform_wrapper {
  font-size: 0.875em; // Smaller forms in sidebar
}

.hero-section .gform_wrapper {
  font-size: 1.25em; // Larger forms in hero
}
```

## Troubleshooting

### Forms not styled
- ✅ Check that "Gravity Forms 2.5 Theme" is selected in settings
- ✅ Verify CSS file is enqueued and loading
- ✅ Clear browser and WordPress cache

### Styles conflict with theme
- ✅ Check CSS specificity - you may need `!important` in rare cases
- ✅ Ensure your theme isn't overriding form styles
- ✅ Try increasing priority in `wp_enqueue_scripts`

### Checkbox/Radio icons not showing
- ✅ Verify browser supports CSS `mask-image`
- ✅ Check that you have the complete `_mixins.scss` file
- ✅ Ensure no other CSS is overriding the `::before` pseudo-element

### Colors don't look right
- ✅ Check the CSS custom property values in `_forms.scss`
- ✅ Override specific variables for your design

## Browser Support

- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Modern mobile browsers

**Note:** Uses CSS `mask-image` for checkbox/radio styling and `color-mix()` for some color manipulation. Both require modern browsers.

## Performance

- **Minimal CSS** - Only essential overrides
- **No JavaScript** - Pure CSS solution
- **Efficient selectors** - Scoped to Gravity Forms classes
- **Small file size** - ~5KB compiled and minified

## Contributing

Found a bug or have an improvement? Contributions welcome!

## Support & Related Projects

### Need Help?
Visit [Groundworx.dev](https://groundworx.dev) for:
- WordPress block theme development
- Custom Gutenberg blocks
- Form integration and automation
- Sites for home builders, contractors, and real estate professionals

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

**Pro Tip:** This styling approach works for any form plugin - not just Gravity Forms. The mixins can be adapted to style WPForms, Contact Form 7, or any HTML forms.
