<?php namespace Turkeybone\Minifier;


use Devfactory\Minify\Minify;
use Turkeybone\Minifier\Providers\JavaScriptProvider;
use Turkeybone\Minifier\Providers\StyleSheetProvider;

class Minifier extends Minify
{
  
 /**
   * @var bool
   */
  private $fullUrl = false;

  /**
   * @var bool
   */
  private $onlyUrl = false;


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

/**
   * @return mixed
   */
  protected function render()
  {
    $baseUrl = $this->fullUrl ? $this->getBaseUrl() : '';
    if (!$this->minifyForCurrentEnvironment())
      {
        return $this->provider->tags($baseUrl, $this->attributes);
      }

    if( $this->buildExtension == 'js')
    {
        $buildPath =  isset($this->config['js_url_path']) ? $this->config['js_url_path'] : $this->buildPath;
    }
    else# if( $this->buildExtension == 'css')
    {
        $buildPath =  isset($this->config['css_url_path']) ? $this->config['css_url_path'] : $this->buildPath;        
    }
    
    $filename = $baseUrl . $buildPath  . $this->provider->getFilename();

    if ($this->onlyUrl) {
      return $filename;
    }

    return $this->provider->tag($filename, $this->attributes);
  }

}

