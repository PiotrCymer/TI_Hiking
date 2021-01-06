<?php


namespace Core\Response;


final class ResponseHtml extends Response
{

    public function sendResponse()
    {
        if(empty($this->data['view'])) {
            include($this->data['file']);
        } else {
            $view = $this->data['view'];

            echo $view;
        }
    }

    public function setContentType()
    {
        $this->contentType = "text/html";
    }
}
