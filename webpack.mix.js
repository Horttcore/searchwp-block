let mix = require("laravel-mix");

mix
  .react(
    "assets/js/index.js",
    "./dist/js/searchwp-block.js"
  )
  .sourceMaps();
