<?php
namespace app\exception;

/**
 * If the configuration values are disallowed use this exception.
 * <p/>
 * <p><a href="InvalidConfigurationException.php.html"><i>View Source</i></a></p>
 *
 * @author <a href="mailto:eduardo.scarello@gmail.com">Eduardo Scarello</a>
 */
class InvalidConfigurationException extends \Exception {
    
    public function __construct($message = "Server error, invalid configuration.",
            $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
