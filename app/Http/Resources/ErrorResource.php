<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    protected $code;
    protected $message;
    protected $errors;

    public function __construct($code, $message = "Failed operation", $error = "")
    {
        $this->code = $code;
        $this->message = $message;
        $this->setError($error);
    }

    public function toArray($request)
    {
        return [
            "message" => $this->message,
            "errors" => $this->errors,
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->code);
    }

    private function setError($error){
        //here $error is passed as an array or not passed
        $this->errors = $error;
        
        //if $error is passed to the resource as string (but not empty string) target is the default key name of errors
        if($error != "" && is_array($error) == false) {
            $this->errors = ["target" => $error];
        }
    }
}
