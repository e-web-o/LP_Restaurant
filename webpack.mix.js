const mix = require('laravel-mix');
const glob = require('glob');

mix.setPublicPath('./')

glob.sync('src/scss/*.scss').map(function(file) {
  mix.sass(file, 'dist/css', {
    sassOptions: {
      outputStyle: 'compressed'
    }
  })
  .options({
    postCss: [
      require('autoprefixer')({
        grid: true
      })
    ]
  });
});

glob.sync('src/js/*.js').map(function(file) {
  mix.js(file, 'dist/js');
});

mix.options({
	processCssUrls: false,
});
