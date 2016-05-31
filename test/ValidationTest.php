<?php
namespace test;

use app\component\Validation;

/**
 * TODO add a description for the file.
 * <p/>
 * <p><a href="ValidationTest.php.html"><i>View Source</i></a></p>
 *
 * @author <a href="mailto:eduardo.scarello@gmail.com">Eduardo Scarello</a>
 */
class ValidationTest extends \PHPUnit_Framework_TestCase{
    private $validation;
    
    public function setUp() {
        $config = $this->getMockBuilder('\app\config\Config')
                     ->getMock();
        $request = $this->getMockBuilder('\app\component\Request')
                     ->getMock();
        
        $config->method('getRedisHost')->willReturn('');
        $config->method('getRedisPort')->willReturn('');
        $config->method('getAllowedDomains')->willReturn([]);
        $config->method('getAllowBlankReferrer')->willReturn('');
        
        $request->method('getAppCookie')->willReturn('');
        $request->method('getHttpOrigin')->willReturn('');
        
        $this->validation = new Validation($config, $request);
    }
    
    public function testCheckConfig() {
        $this->setExpectedException('\app\exception\InvalidConfigurationException');
        
        $this->validation->checkConfig();
    }
    
    public function testCheckCORS() {
        $this->setExpectedException('\app\exception\InvalidOriginException');
        
        $this->validation->checkCORS();
    }
    
    public function testCheckSession() {
        $this->setExpectedException('\app\exception\InvalidSessionException');
        
        $this->validation->checkSesion();
    }
}
