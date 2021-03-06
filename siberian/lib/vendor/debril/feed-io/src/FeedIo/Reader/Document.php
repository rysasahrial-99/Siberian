<?php
/*
 * This file is part of the feed-io package.
 *
 * (c) Alexandre Debril <alex.debril@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FeedIo\Reader;

class Document
{

    /**
     * @var string
     */
    protected $content;

    /**
     * @var \DOMDocument
     */
    protected $domDocument;

    /**
     * @var array
     */
    protected $jsonArray;

    /**
     * Document constructor.
     * @param string $content
     */
    public function __construct($content)
    {
        $this->content = trim($content);
    }

    /**
     * @param $character
     * @return bool
     */
    public function startWith($character)
    {
        return substr($this->content, 0, 1) === $character;
    }

    /**
     * @return bool
     */
    public function isJson()
    {
        return $this->startWith('{');
    }

    /**
     * @return bool
     */
    public function isXml()
    {
        return $this->startWith('<');
    }

    /**
     * @return \DOMDocument
     */
    public function getDOMDocument()
    {
        if (is_null($this->domDocument)) {
            $this->domDocument = $this->loadDomDocument();
        }

        return $this->domDocument;
    }

    /**
     * @return array
     */
    public function getJsonAsArray()
    {
        if (is_null($this->jsonArray)) {
            $this->jsonArray = $this->loadJsonAsArray();
        }

        return $this->jsonArray;
    }

    /**
     * @return \DOMDocument
     */
    protected function loadDomDocument()
    {
        if (! $this->isXml()) {
            throw new \LogicException('this document is not a XML stream');
        }

        set_error_handler(

        /**
         * @param string $errno
         */
            function ($errno, $errstr) {
                throw new \InvalidArgumentException("malformed xml string. parsing error : $errstr ($errno)");
            }
        );

        $domDocument = new \DOMDocument();
        $domDocument->loadXML($this->content);
        restore_error_handler();

        return $domDocument;
    }

    /**
     * @return array
     */
    protected function loadJsonAsArray()
    {
        if (! $this->isJson()) {
            throw new \LogicException('this document is not a JSON stream');
        }

        return json_decode($this->content, true);
    }
}
