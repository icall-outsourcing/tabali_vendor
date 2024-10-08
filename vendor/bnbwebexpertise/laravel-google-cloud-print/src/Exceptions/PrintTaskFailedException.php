<?php
namespace Bnb\GoogleCloudPrint\Exceptions;

class PrintTaskFailedException extends \Exception
{    

    public function error($error){

        return $error;
    }

}