# Unique SVG CSS for Statamic

Avoid one SVG overwriting the CSS of another SVG by adding the `unique_svg_css` modifier to your SVG output.

```
{{ my_svg_url_var | output | unique_svg_css }}
```

Install into your `/site/addons` folder changing the folder name to `UniqueSvgCss`
