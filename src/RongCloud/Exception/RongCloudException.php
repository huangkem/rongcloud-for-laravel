<?php
namespace RongCloud\Exception;

class RongCloudException extends \Exception {
    /**
     * @var int
     */
    public $httpStatusCode = 500;

    /**
     * @param string $message
     */
    public function __construct($message) {
        parent::__construct($message);
    }
}
