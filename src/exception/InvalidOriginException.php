<?php
namespace app\exception;

/**
 * If the origin of the HTTP request is disallowed in the application, then
 * use this exception.
 * <p/>
 * <p><a href="InvalidOriginException.php.html"><i>View Source</i></a></p>
 *
 * @author <a href="mailto:eduardo.scarello@gmail.com">Eduardo Scarello</a>
 */
class InvalidOriginException extends \Exception {
    
    public function __construct($message = "Not a valid origin.", $code = 0, 
            \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
