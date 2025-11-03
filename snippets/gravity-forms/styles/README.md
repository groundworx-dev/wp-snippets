# Gravity Forms Block Theme Styles

Professional, scalable SCSS for integrating Gravity Forms into WordPress block themes using native design tokens.

> **Part of the Groundworx Snippets collection** - Professional WordPress code for developers who value quality and maintainability. Created by Johanne Courtright at [Groundworx](https://groundworx.dev).

## Overview

A complete SCSS styling system for theme developers who want to integrate Gravity Forms seamlessly with WordPress block themes. Built on a scalable em-based architecture that uses native WordPress design tokens for consistent, maintainable form styling.

## Key Features

- **🎨 Block Theme Integration** - Uses WordPress `--wp--preset--color--*` design tokens
- **📏 Truly Scalable** - All measurements use `em` units for proportional scaling
- **♿ Accessible** - Proper font sizing, keyboard navigation, screen reader support
- **🎯 Non-Invasive** - Minimal overrides, works alongside Gravity Forms themes
- **🔧 Customizable** - Easy variable-based configuration
- **⚡ Modern CSS** - Uses `color-mix()`, CSS custom properties, and semantic markup

## Who This Is For

**Theme Developers** who want to:
- Integrate Gravity Forms seamlessly into block themes
- Use WordPress design tokens for consistent styling
- Provide clients with forms that match their theme automatically
- Build scalable, maintainable form styling systems

**Not a plugin** - This is SCSS source code for theme developers to integrate into their themes.

## Files

```
styles/
├── _variables.scss                    # Configuration variables
├── _mixins.scss                       # Reusable form styling mixins
├── _forms.scss                        # Universal form element styles
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
            ├── _variables.scss
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
.large-contact-form {
  font-size: 1.5em; // Everything scales: inputs, buttons, spacing, icons
}

// Smaller forms?
.compact-newsletter-form {
  font-size: 0.875em; // Everything scales down proportionally
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

### Option 3: Just the Mixins

Use `_mixins.scss` in your own projects:

```scss
@import 'mixins';

.my-custom-form {
  input[type="text"] {
    @include form-input;
    
    &:focus {
      @include form-input-focus;
    }
  }
  
  input[type="checkbox"] {
    @include form-checkbox-radio;
    @include form-checkbox;
  }
}
```

## Customization

### Method 1: Override Variables (Recommended)

Create a custom file that overrides variables before importing:

```scss
// custom-gravity-forms.scss

// Override variables
$form-input-border-radius: 0.5em;
$form-input-border-width: 2px;
$form-input-focus-border-color: var(--wp--preset--color--accent-2);

// Import the complete styles
@import 'gravity-forms-block-theme';
```

### Method 2: Modify Variables File

Edit `_variables.scss` directly to change defaults.

### Available Variables

#### Form Inputs
```scss
$form-input-color: var(--wp--preset--color--contrast);
$form-input-border-color: color-mix(in srgb, currentColor 65%, transparent);
$form-input-border-width: 0.075em;
$form-input-border-radius: 0%;
$form-input-border-style: solid;
$form-input-padding: 0.35em 0.5em;
$form-input-line-height: 1.5em;
```

#### Focus States
```scss
$form-input-focus-border-color: var(--wp--preset--color--accent-1);
$form-input-focus-box-shadow: 0 0 2px 0 var(--wp--preset--color--accent-1);
```

#### Checkbox & Radio
```scss
$form-checkbox-radio-background: var(--wp--preset--color--base);
$form-checkbox-radio-color: var(--wp--preset--color--contrast);
$form-checkbox-radio-border-color: color-mix(in srgb, currentColor 65%, transparent);
$form-checkbox-radio-checked-background: var(--wp--preset--color--accent-1);
$form-checkbox-radio-checked-border: var(--wp--preset--color--accent-1);
```

#### Icons
```scss
$form-checkbox-icon-color: white;
$form-checkbox-icon-stroke-width: 2.5;
$form-radio-icon-color: white;
$form-select-arrow-color: rgb(76, 76, 76);
```

### WordPress Design Tokens

The styles use your block theme's color palette:

- `--wp--preset--color--contrast` - Text and borders
- `--wp--preset--color--base` - Backgrounds
- `--wp--preset--color--accent-1` - Focus states and checked inputs
- `--wp--preset--color--accent-3` - File upload buttons

These automatically adapt to your theme's colors.

## What Gets Styled

### Form Elements
- Text inputs (text, email, url, password, number, date, etc.)
- Textareas
- Select dropdowns (with custom arrow)
- Checkboxes (with custom checkmark)
- Radio buttons (with custom dot)
- File uploads (with styled button)
- Multi-select fields

### Gravity Forms Specific
- Field labels and descriptions
- List field icons (add/remove buttons)
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
// Done! Forms now use your block theme styles
```

### Custom Accent Color

```scss
$form-input-focus-border-color: var(--wp--preset--color--accent-2);
$form-checkbox-radio-checked-background: var(--wp--preset--color--accent-2);

@import 'gravity-forms-block-theme';
```

### Rounded Inputs

```scss
$form-input-border-radius: 0.5em;

@import 'gravity-forms-block-theme';
```

### Thicker Borders

```scss
$form-input-border-width: 2px;

@import 'gravity-forms-block-theme';
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

### Icons not scaling
- ✅ Verify you have the complete `gravity-forms-block-theme.scss` overrides
- ✅ Check that Gravity Forms list field CSS isn't being overridden

### Colors don't match theme
- ✅ Ensure your theme properly defines `--wp--preset--color--*` variables
- ✅ Override color variables to match your brand

## Browser Support

- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Modern mobile browsers

**Note:** Uses `color-mix()` which requires modern browsers. For older browser support, replace with solid colors.

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
This is part of the **Groundworx Snippets** collection - professional, production-ready WordPress code snippets. Check out the full collection at [github.com/groundworx/snippets](https://github.com/groundworx/snippets).

## Author

Created by Johanne Courtright  
[Groundworx](https://groundworx.dev)

## License

GPL-2.0-or-later

## Version

1.0.0

---

**Pro Tip:** This styling approach works for any form plugin - not just Gravity Forms. The mixins can be adapted to style WPForms, Contact Form 7, or any HTML forms.
