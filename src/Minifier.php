<?php namespace Turkeybone\Minifier;

use Devfactory\Minify\Minify;
use Turkeybone\Minifier\Providers\JavaScriptProvider;
use Turkeybone\Minifier\Providers\StyleSheetProvider;

class Minifier extends Minify
{
  

  /**
   * @param $file
   * @param array $attributes
   * @return string
   */
  public function javascript($file, $attributes = array()) {
    $this->provider = new JavaScriptProvider(public_path(), ['hash_salt' => $this->config['hash_salt'], 'disable_mtime' => $this->config['disable_mtime']]);
    $this->buildPath = $this->config['js_build_path'];
    $this->attributes = $attributes;
    $this->buildExtension = 'js';

    $this->process($file);

    return $this;
  }

  /**
   * @param $file
   * @param array $attributes
   * @return string
   */
  public function stylesheet($file, $attributes = array()) {
    $this->provider = new StyleSheetProvider(public_path(), ['hash_salt' => $this->config['hash_salt'], 'disable_mtime' => $this->config['disable_mtime']]);
    $this->buildPath = $this->config['css_build_path'];
    $this->attributes = $attributes;
    $this->buildExtension = 'css';

    $this->process($file);

    return $this;
  }

  /**
   * @param $dir
   * @param array $attributes
   * @return string
   */
  public function stylesheetDir($dir, $attributes = array()) {
    $this->provider = new StyleSheetProvider(public_path(), ['hash_salt' => $this->config['hash_salt'], 'disable_mtime' => $this->config['disable_mtime']]);
    $this->buildPath = $this->config['css_build_path'];
    $this->attributes = $attributes;
    $this->buildExtension = 'css';

    return $this->assetDirHelper('css', $dir);
  }

  /**
   * @param $dir
   * @param array $attributes
   * @return string
   */
  public function javascriptDir($dir, $attributes = array()) {
    $this->provider = new JavaScriptProvider(public_path(), ['hash_salt' => $this->config['hash_salt'], 'disable_mtime' => $this->config['disable_mtime']]);
    $this->buildPath = $this->config['js_build_path'];
    $this->attributes = $attributes;
    $this->buildExtension = 'js';

    return $this->assetDirHelper('js', $dir);
  }


  public function getInlineBlock()
  {
    return $this->provider->rawText();
  }


  /**
   * @param $file
   */
  private function process($file) {
    $this->provider->add($file);

    if($this->minifyForCurrentEnvironment() && $this->provider->make($this->buildPath))
      {
        $this->provider->minify();
      }

    $this->fullUrl = false;
  }

}

