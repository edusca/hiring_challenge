<?php
namespace app\component;

/**
 * This represents the HTTP response to a client. Here is a good place to put
 * the different responses types that the application can have (JSON, XML, etc.). 
 * <p/>
 * <p><a href="Response.php.html"><i>View Source</i></a></p>
 *
 * @author <a href="mailto:eduardo.scarello@gmail.com">Eduardo Scarello</a>
 */
class Response {
    const HTTP_CODE_OK = 200;
    const HTTP_CODE_INTERNAL_SERVER_ERROR = 500;
    const HTTP_CODE_UNAUTHORIZED = 401;
    const HTTP_CODE_FORBIDDEN = 403;
    const HTTP_CODE_NOT_FOUND = 404;
    
    /**
     * Echo the json response to the client. Use this for errors or generic 
     * responses.
     */
    public function sendJson($code, $error, $message) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($code);
        echo json_encode(
            [
                'error' => $error,
                'message' => $message
            ]
        );
        exit();
    }
    
    /**
     * Echo the json response to the client. This is used for send domain 
     * data inside the json.
     */
    public function sendJsonWithData($code, $data) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($code);
        echo json_encode($data);
        exit();
    }
}
