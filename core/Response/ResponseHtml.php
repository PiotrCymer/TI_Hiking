<?php


namespace Core\Response;


final class ResponseHtml extends Response
{

    public function sendResponse()
    {
        $view = $this->data['view'];

        echo $view;
    }

    public function setContentType()
    {
        $this->contentType = "text/html";
    }
}
