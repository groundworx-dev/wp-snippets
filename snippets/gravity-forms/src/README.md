# Gutenberg Gravity Forms Block

A custom Gutenberg block that wraps Gravity Forms with full visual color controls and block theme integration.

> **Part of the Groundworx Snippets collection** - Professional WordPress code for developers who value quality and maintainability. Created by Johanne Courtright at [Groundworx](https://groundworx.dev).

## Overview

This block provides a native Gutenberg editing experience for Gravity Forms with comprehensive color controls in the block editor's sidebar. All colors are automatically converted to RGBA values for reliable rendering on both frontend and in the editor.

## Features

- **🎨 9 Color Controls** - Full visual control over form appearance
  - Label text color
  - Required field indicator color
  - Input text color
  - Input background color
  - Input border color
  - Checkbox/radio text (checkmark/dot color)
  - Checkbox/radio background (checked state)
  - Progress bar foreground
  - Progress bar background

- **🔄 Automatic Color Conversion** - All colors converted to RGBA for CSS compatibility
- **🎯 Dynamic Select Arrows** - Dropdown arrows automatically match input text color
- **✨ Full Block Supports** - Typography, spacing, borders, shadows, and more
- **🎭 Editor Preview** - See your styled form directly in the block editor
- **📦 Self-Contained** - All form styling handled through the block

## Requirements

- WordPress 6.4+
- Gravity Forms 2.5+
- Node.js & npm (for building)
- PHP 7.4+

## Installation & Setup

### 1. Copy Block Files

Copy the block source files to your theme or plugin:

```
your-theme/
└── src/
    └── blocks/
        └── gutenberg-gravity-forms/
            ├── block.json
            ├── block.php
            ├── edit.js
            ├── index.js
            ├── save.js
            ├── multi-color-control.js
            ├── utils.js
            ├── editor.scss
            └── style.scss
```

**Block Name:** `groundworx/gutenberg-gravity-forms`

This is the identifier you'll see in the block inserter and used internally by WordPress.

### 2. Build the Block

Install dependencies and build:

```bash
cd your-theme
npm install @wordpress/scripts --save-dev
npm run build
```

This will create a `build/` directory with compiled assets.

### 3. Register the Block

In your theme's `functions.php`:

```php
// Register the Gutenberg Gravity Forms block
require_once get_template_directory() . '/build/blocks/gutenberg-gravity-forms/block.php';
```

The `block.php` file handles block registration and rendering automatically.

### 4. Configure Gravity Forms

**Important:** The block automatically enforces the "Gravity Forms 2.5 Theme" for all forms rendered through it. This is by design.

#### Why Gravity Forms 2.5 Theme?

The block requires the Gravity Forms 2.5 Theme because:
- It provides a clean, minimal baseline for styling
- The Orbital theme (and other custom themes) inject extensive CSS that's difficult to override
- Our color controls and styling work best with the simpler 2.5 theme structure

The block sets `theme: 'gravity-theme'` automatically in the form attributes, so you don't need to configure this per-form when using the block.

#### Global Settings (Optional)

If you want all forms on your site to use this theme (not just in the block):

1. Go to **Forms → Settings → Styles & Layouts**
2. Under **Default Form Theme**, select **"Gravity Forms 2.5 Theme"**

This ensures consistency across your site, whether forms are embedded via block, shortcode, or PHP.

## Usage

### Adding the Block

1. In the block editor, click the **+** icon
2. Search for "Gutenberg Gravity Forms"
3. Add the block to your page
4. Select your Gravity Form from the block settings

### Customizing Colors

1. Select the block
2. In the right sidebar, go to the **Color** section
3. You'll see expandable panels for:
   - **Labels** (text color, required indicator color)
   - **Input** (text, background, border)
   - **Radio and Checkbox** (checkmark/dot color, checked background)
   - **Progress Bar** (foreground, background)

4. Click any color to choose from your theme palette or set a custom color
5. Colors update in real-time in the editor

### Block Supports

The block includes full support for:

- **Typography** - Font size, line height, font family, weight, style
- **Spacing** - Padding, margin, block gap
- **Colors** - Text, background, links, headings
- **Borders** - Width, style, radius, color
- **Shadows** - Box shadow
- **Alignment** - Wide, full width
- **Dimensions** - Min height
- **Position** - Sticky positioning

## How It Works

### Color System

The block uses a three-attribute system for each color:

1. **Preset Color** (e.g., `inputTextColor`) - Stores the theme color slug
2. **Custom Color** (e.g., `customInputTextColor`) - Stores custom hex/rgba values
3. **RGB Color** (e.g., `rgbInputTextColor`) - Auto-generated RGBA for CSS

This approach ensures colors work reliably in both the editor and frontend, regardless of whether users choose theme colors or custom values.

### Dynamic Select Arrows

The block automatically generates SVG arrows for select dropdowns that match your input text color. This is done by:
1. Converting the color to RGBA
2. Encoding it into an inline SVG data URI
3. Setting it as a CSS custom property

### CSS Custom Properties

The block sets CSS custom properties on the wrapper element:

```css
--form--labels
--form--labels--required
--form--input--text
--form--input--background
--form--input--border--color
--form--checkbox-radio--text--selected
--form--checkbox-radio--background--selected
--form--progressbar--foreground
--form--progressbar--background
--form--select--arrow (dynamically generated)
```

These properties are consumed by the form styling mixins.

## File Structure

```
gutenberg-gravity-forms/
├── block.json              # Block configuration and attributes
├── block.php              # Server-side rendering and registration
├── edit.js                # Block editor component with color controls
├── index.js               # Block registration entry point
├── save.js                # Save function (renders null for dynamic block)
├── multi-color-control.js # Custom multi-color picker component
├── utils.js               # Helper functions for color CSS vars
├── editor.scss            # Editor-only styles
└── style.scss             # Frontend styles
```

## Development

### Building for Development

Watch mode for development:

```bash
npm run start
```

### Building for Production

Create optimized production build:

```bash
npm run build
```

### Dependencies

The block uses these WordPress packages (automatically handled by `@wordpress/scripts`):

- `@wordpress/block-editor` - Block editor components
- `@wordpress/blocks` - Block registration
- `@wordpress/components` - UI components
- `@wordpress/element` - React wrapper
- `@wordpress/i18n` - Internationalization
- `colord` - Color manipulation and conversion

## Customization

### Adding More Colors

To add additional color controls:

1. **Update `block.json`** - Add three attributes for your new color:
```json
"myNewColor": { "type": "string" },
"customMyNewColor": { "type": "string" },
"rgbMyNewColor": { "type": "string" }
```

2. **Update `edit.js`** - Add the color to `withColors`:
```javascript
withColors(
    // ... existing colors
    { myNewColor: 'color' }
)
```

3. **Add color control** - Create a new color group in the `InspectorControls`

4. **Add CSS variable** - Update the filter to include your new CSS property

5. **Update `block.php`** - Add the color to the PHP rendering

### Modifying Color Groups

Edit the color group arrays in `edit.js`:

```javascript
const labelColors = [
    { 
        key: 'text', 
        label: __('Text', 'groundworx'), 
        value: labelColor, 
        setValue: setLabelColor 
    },
    // Add more colors to this group
];
```

## Troubleshooting

### Block doesn't appear in editor
- ✅ Verify the block is compiled: check for `build/blocks/gutenberg-gravity-forms/`
- ✅ Ensure `block.php` is required in `functions.php`
- ✅ Check browser console for JavaScript errors

### Colors not showing in editor
- ✅ Clear browser cache
- ✅ Rebuild the block: `npm run build`
- ✅ Check that `colord` is installed: `npm install colord`

### Colors not showing on frontend
- ✅ Verify form is using "Gravity Forms 2.5 Theme"
- ✅ Check that CSS custom properties are being output (view page source)
- ✅ Ensure form styling CSS is enqueued

### Select arrows wrong color
- ✅ Check that `rgbInputTextColor` attribute is being saved
- ✅ Verify the SVG is being generated in `block.php`
- ✅ Check browser console for any encoding errors

## Browser Support

- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Modern mobile browsers

**Note:** Uses CSS `mask-image` for checkbox/radio styling. Requires modern browsers.

## Performance

- **Minimal JavaScript** - Only loads in block editor
- **Efficient Rendering** - Uses WordPress core Gravity Forms block internally
- **CSS Custom Properties** - No JavaScript needed on frontend
- **Small Bundle Size** - ~15KB compiled (editor only)

## Integration with Form Styling

This block works seamlessly with the [Gravity Forms Block Theme Styles](../styles/) from this collection. The block sets CSS custom properties that the form styling mixins consume.

**Using together:**
1. Install and configure the form styling SCSS
2. Install this block
3. Colors set in the block editor override the SCSS defaults
4. Result: Visual control without losing the robust styling system

## Known Limitations

- **Theme enforcement:** Block automatically uses "Gravity Forms 2.5 Theme" - this cannot be changed per-form when using the block
- Colors only apply when using "Gravity Forms 2.5 Theme" (which the block enforces)
- Orbital theme and other custom Gravity Forms themes are not supported (they inject too much CSS to reliably override)
- Requires form styling CSS (SCSS from this collection or custom CSS)
- Block must be rebuilt after any code changes
- Cannot style legacy Gravity Forms themes

## Support & Related Projects

### Need Help?
Visit [Groundworx.dev](https://groundworx.dev) for:
- WordPress block theme development
- Custom Gutenberg blocks
- Form integration and automation

### More Snippets
This is part of the **Groundworx Snippets** collection. Check out the full collection at [github.com/groundworx/snippets](https://github.com/groundworx-dev/wp-snippets).

## Author

Created by Johanne Courtright  
[Groundworx](https://groundworx.dev)

## License

GPL-2.0-or-later

## Version

1.0.0

---

**Pro Tip:** Use this block together with the [Form Styling SCSS](../styles/) for the complete solution - visual editing in Gutenberg plus professional, scalable form styling.
