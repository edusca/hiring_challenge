<?php
namespace app\component;
/**
 * Get the data in some request using static methods.
 * <p/>
 * <p><a href="Request.php.html"><i>View Source</i></a></p>
 *
 * @author <a href="mailto:eduardo.scarello@gmail.com">Eduardo Scarello</a>
 */
class Request {

    public function getAppCookie() {
        return $_COOKIE['app'];
    }
    
    public function getHttpOrigin() {
        return $_SERVER['HTTP_ORIGIN'];
    }
}
