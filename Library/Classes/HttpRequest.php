<?php

class HttpRequest extends Request
{
    protected $_baseUrl = null;

    public function __construct($params = null)
    {
        $this->_params = $_REQUEST;

        if (is_array($params))
            $this->setParams($params);

        $this->setBaseUrl($_SERVER['REDIRECT_URL']); //добавил $_SERVER['REDIRECT_URL'] для правильного роута, было просто $_SERVER['PHP_SELF']
    }

    public function setBaseUrl($baseUrl)
    {
        $this->_baseUrl = $baseUrl;
    }

    public function getBaseUrl()
    {
        return $this->_baseUrl;
    }
}