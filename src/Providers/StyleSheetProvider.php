<?php namespace Turkeybone\Minifier\Providers;

use Devfactory\Minify\Providers\StyleSheet;
use Devfactory\Minify\Contracts\MinifyInterface;
use CssMinifier;

class StyleSheetProvider extends StyleSheet implements MinifyInterface
{
    private $minifiedText;

    /**
     * @return string
     */
    public function minify()
    {
        $minified = new CssMinifier($this->appended);
        $this->minifiedText .= $minified->getMinified();

        return $this->put($minified->getMinified());
    }



    /**
       * @return string
       */
      public function rawText() {

        return "<style>" . $this->minifiedText . "</style>";
      }

}

