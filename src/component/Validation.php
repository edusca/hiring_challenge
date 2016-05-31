<?php
namespace app\component;

use app\exception\InvalidConfigurationException;
use app\exception\InvalidOriginException;
use app\exception\InvalidSessionException;

/**
 * Validations that must be invoced before process the request of a client.
 * <p/>
 * <p><a href="Validation.php.html"><i>View Source</i></a></p>
 *
 * @author <a href="mailto:eduardo.scarello@gmail.com">Eduardo Scarello</a>
 */
class Validation {
    private $config;
    private $request;
    
    public function __construct($config, $request) {
        $this->config = $config;
        $this->request = $request;
    }
    
    /**
     * Validate that the app configuration is ok.
     * @throws InvalidConfigurationException
     */
    public function checkConfig() {
        if (empty($this->config->getRedisHost()) || 
                empty($this->config->getRedisPort()) || 
                empty($this->config->getAllowedDomains()) ||
                !is_array($this->config->getAllowedDomains())) {
            throw new InvalidConfigurationException();
        }
    }
    
    /**
     * Validate the cross-origin request sharing, allowing only the origins
     * loaded from the configuration.
     * @throws InvalidOriginException
     */
    public function checkCORS() {
        $httpOrigin = 
                !empty($this->request->getHttpOrigin()) ? $this->request->getHttpOrigin() : null;
        
        if ($this->config->getAllowBlankReferrer() || 
                in_array($httpOrigin, $this->config->getAllowedDomains())) {
            
            header('Access-Control-Allow-Credentials: true');
            if ($httpOrigin) {
                header("Access-Control-Allow-Origin: $httpOrigin");
            }
        } else {
            throw new InvalidOriginException();
        }
    }
    
    /**
     * Validate that the app cookie is set.
     * @throws InvalidSessionException
     */
    public function checkSesion() {
        if (empty($this->request->getAppCookie())) {
            throw new InvalidSessionException();
        }
    }
}
