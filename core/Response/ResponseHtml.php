<?php


namespace Core\Response;


final class ResponseHtml extends Response
{

    public function sendResponse()
    {
        $content = $this->data['content'];

        include($this->data['template']);
    }

    public function setContentType()
    {
        $this->contentType = "text/html";
    }
}
