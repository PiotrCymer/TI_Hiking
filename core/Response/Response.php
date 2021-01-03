<?php


namespace Core\Response;


abstract class Response
{

    protected int $statusCode;

    protected array $data = [];

    protected string $contentType;


    public function __construct($statusCode, $data)
    {
        $this->setStatusCode($statusCode);
        $this->setData($data);
        $this->setContentType();

        $this->send();
    }

    abstract function sendResponse();

    abstract function setContentType();

    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    protected function setData($data)
    {
        $this->data = $data;
    }

    private function send()
    {
        http_response_code($this->statusCode);
        header('Content-Type: ' . $this->contentType);

        $this->sendResponse();
    }
}
