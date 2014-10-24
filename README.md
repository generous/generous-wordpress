# [Generous](https://genero.us) Wordpress Plugin

The Generous Wordpress plugin repository.

The official [Generous](https://genero.us) plugin that allows you to easily generate a store.

*Requires a [Generous](https://genero.us) account.*

## Installation

1. Copy or upload the `generous` plugin folder into your `wp-content/plugins` directory.
2. Activate the Generous plugin via the plugins admin page.

## Usage

Within the plugin settings page, specify your Generous username, the permalink where the store should generate, and save.

### Shortcodes

Display Generous content from a Wordpress post or page.

- `[generous store]` Outputs a store
- `[generous categories]` Outputs a list of categories
- `[generous category=<id>]` Outputs slider of the specified category

### Templates

To modify the templates, create a folder called `generous-templates` within your theme, and copy over the templates that you'd like to customize.

*Pages*

- `page-default.php` Displays a list of categories, and sliders of the featured category
- `page-category.php` A page of sliders of a specified category
- `page-slider.php` A page of an individual slider

*Shortcodes*

- `shortcode-categories.php` [generous categories]
- `shortcode-category.php` [generous category=id]
- `shortcode-store.php` [generous store]

*Partials*

- `partials/categories-item.php` The category item *(Used by: shortcode-categories.php)*
- `partials/slider-item.php` The category item *(Used by: page-default.php, page-category.php, shortcode-category.php)*
- `partials/slider.php` The single slider item *(Used by: page-slider.php)*

### Filters

Filters allow you to output requested data within your templates.

*slider-item.php*

- `[slider_id]` The ID of the slider
- `[title]` Title
- `[cover_photo]` Cover photo
- `[additional_info]` Description
- `[suggested_price]` Suggested price decimal - *(10.00)*
- `[suggested_price_whole]` Suggested price whole - *(10)*
- `[minimum_price]` Minimum price decimal - *(10.00)*
- `[minimum_price_whole]` Minimum price whole - *(10)*
- `[currency_symbol]` Currency symbol - *($)*
- `[charity_percentage]` Percentage going to charity
- `[item_total]` Total number of items
- `[item_total_label]` Item label - *(Items or Item)*
- `[short_url]` Short url
- `[button_slider_overlay]` Link that generates overlay

*category-item.php*

- `[title]` - Title