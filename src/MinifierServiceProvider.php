<?php namespace Turkeybone\Minifier;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class MinifierServiceProvider extends MinifyServiceProvider {

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
