<?php


namespace Core\Response;


final class ResponseJson extends Response
{

    public function sendResponse()
    {
        echo json_encode($this->data);
    }

    public function setContentType()
    {
        $this->contentType = "application/json";
    }

}
