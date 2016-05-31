<?php
namespace app\config;

use Dotenv\Dotenv;

/**
 * Define the configuration properties here.
 * <p/>
 * <p><a href="config.php.html"><i>View Source</i></a></p>
 *
 * @author <a href="mailto:eduardo.scarello@gmail.com">Eduardo Scarello</a>
 */
class Config {
    
    /**
     * Load the .env configuration file.
     */
    public function __construct() {
        $dotenv = new Dotenv(__DIR__. '/../../');
        $dotenv->load();
    }
    
    public function getRedisHost() {
        return getenv('REDIS_HOST');
    }

    public function getRedisPort() {
        return getenv('REDIS_PORT');
    }

    public function getAllowedDomains() {
        return explode(',', getenv('ALLOWED_DOMAINS'));
    }

    public function getAllowBlankReferrer() {
        return getenv('ALLOW_BLANK_REFERRER') || false;
    }
}
