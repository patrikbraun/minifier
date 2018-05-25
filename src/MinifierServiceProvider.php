<?php namespace Turkeybone\Minifier;

use Devfactory\Minify\MinifyServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class MinifierServiceProvider extends MinifyServiceProvider {




	/**
   * Register the package services.
   *
   * @return void
   */
  protected function registerServices() {
    $this->app->singleton('minifier', function ($app) {
      return new Minifier(
        array(
          'css_build_path' => config('minify.config.css_build_path'),
          'css_url_path' => config('minify.config.css_url_path'),
          'js_build_path' => config('minify.config.js_build_path'),
          'js_url_path' => config('minify.config.js_url_path'),
          'ignore_environments' => config('minify.config.ignore_environments'),
          'base_url' => config('minify.config.base_url'),
          'reverse_sort' => config('minify.config.reverse_sort'),
          'disable_mtime' => config('minify.config.disable_mtime'),
          'hash_salt' => config('minify.config.hash_salt'),
        ),
        $app->environment()
      );
    });
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides()
  {
    return array('minifier');
  }
}
