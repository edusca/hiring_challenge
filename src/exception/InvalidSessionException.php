<?php
namespace app\exception;

/**
 * Use this exception if the session or cookies are invalid.
 * <p/>
 * <p><a href="InvalidSessionException.php.html"><i>View Source</i></a></p>
 *
 * @author <a href="mailto:eduardo.scarello@gmail.com">Eduardo Scarello</a>
 */
class InvalidSessionException extends \Exception {
    
    public function __construct($message = "Not a valid session.", $code = 0, 
            \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
