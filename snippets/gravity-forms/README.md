# Gravity Forms Block Theme Integration

Complete solution for integrating Gravity Forms seamlessly with WordPress block themes.

> **Part of the Groundworx Snippets collection** - Professional WordPress code for developers who value quality and maintainability. Created by Johanne Courtright at [Groundworx](https://groundworx.dev).

## What's Included

### 🔘 [Replace Buttons with Blocks](./replace-buttons-with-blocks/)

PHP class that replaces Gravity Forms button markup with actual WordPress block buttons rendered through Gutenberg.

**What it does:**
- Converts form buttons into real `wp:button` blocks
- Buttons inherit your theme's block button styles automatically
- Configurable primary/secondary button styles
- Uses modern WordPress HTML processor

[Read full documentation →](./replace-buttons-with-blocks/)

---

### 🎨 [Block Theme Styles](./styles/)

Complete SCSS styling system for Gravity Forms using WordPress block theme design tokens.

**What it does:**
- Styles all form elements using `--wp--preset--color--*` tokens
- Scalable em-based design (change one font-size, everything scales)
- Minimal overrides that don't break Gravity Forms functionality
- Customizable via SCSS variables

[Read full documentation →](./styles/)

---

## Use Together or Separately

- **Both together:** Complete block theme integration (recommended)
- **Buttons only:** Keep your current form styles, just get block buttons
- **Styles only:** Keep your current buttons, upgrade form styling

## Requirements

- WordPress 6.4+
- Gravity Forms 2.5+
- PHP 7.4+ (for button replacement)
- SCSS compiler (for styles)

## Support

Visit [Groundworx.dev](https://groundworx.dev) for more information.

Part of the [Groundworx Snippets](https://github.com/groundworx/snippets) collection.