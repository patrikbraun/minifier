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
        $this->minifiedText .= $minified;

        return $this->put($minified);
    }

    protected function checkExistingFiles()
    {
        $this->buildMinifiedFilename();

        if (file_exists($this->outputDir . $this->filename) && filesize($this->outputDir . $this->filename) > 0)
        {
          $this->minifiedText .= file_get_contents($this->outputDir . $this->filename);

          return true;
        }

        return false;
    }

    /**
       * @return string
       */
      public function rawText() {

        return "<script>" . $this->minifiedText . "</script>";
      }
}