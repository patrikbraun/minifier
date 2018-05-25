<?php namespace Turkeybone\Minifier\Providers;

use Devfactory\Minify\Providers\JavaScript;
use Devfactory\Minify\Contracts\MinifyInterface;
use JShrink\Minifier;

class JavaScriptProvider extends JavaScript implements MinifyInterface
{
   private $minifiedText;

    /**
     * @return string
     */
    public function minify()
    {
        $minified = Minifier::minify($this->appended);
        $this->minifiedText .= $minified->getMinified();

        return $this->put($minified);
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

        return "<script>" . $this->minifiedText . "</script>";
      }
}

