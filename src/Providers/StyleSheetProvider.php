<?php namespace Turkeybone\Minifier\Providers;

use Illuminate\Support\Facades\Log;
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

    protected function checkExistingFiles()
    {
        $this->buildMinifiedFilename();
        return false;
    }

    /**
       * @return string
       */
      public function rawText() {

        return "<style>" . $this->minifiedText . "</style>";
      }

}

