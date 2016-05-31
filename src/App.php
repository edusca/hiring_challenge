<?php
namespace app;

use app\config\Config;
use app\component\Validation;
use app\component\Response;
use app\component\Request;
use app\exception\InvalidConfigurationException;
use app\exception\InvalidOriginException;
use app\exception\InvalidSessionException;
use app\repository\RedisRepo;

/**
 * Class for call in the main entry point of the application (index.php).
 * <p/>
 * <p><a href="App.php.html"><i>View Source</i></a></p>
 *
 * @author <a href="mailto:eduardo.scarello@gmail.com">Eduardo Scarello</a>
 */
class App {
    private $config;
    private $request;
    
    public function __construct($config, $request) {
        $this->config = $config;
        $this->request = $request;
    }
    
    /**
     * Validation process before process and send a result to the request made
     * by the user.
     */
    public function processValidation() {
        $validation = new Validation($this->config, $this->request);
        
        try {
            $validation->checkConfig();
            $validation->checkCORS();
            $validation->checkSesion();
        } catch (InvalidConfigurationException $ex) {
            (new Response())->sendJson(Response::HTTP_CODE_INTERNAL_SERVER_ERROR, true, $ex->getMessage());
        } catch (InvalidOriginException $ex) {
            (new Response())->sendJson(Response::HTTP_CODE_FORBIDDEN, true, $ex->getMessage());
        } catch (InvalidSessionException $ex) {
            (new Response())->sendJson(Response::HTTP_CODE_FORBIDDEN, true, $ex->getMessage());
        }
    }
    
    /**
     * Using the app cookie as id, return the friend list of a client.
     * @return json with the friends of a client
     */
    public function processFriendList() {
        try {
            $repo = new RedisRepo($this->config, new \Redis());
        } catch (\RedisException $ex) {
            (new Response())->sendJson(Response::HTTP_CODE_INTERNAL_SERVER_ERROR, true, $ex->getMessage());
        }
        
        //get a session by the cookie
        $session = $repo->getSession($this->request->getAppCookie());

        //don't set cookie, let's keep it lean
        header_remove('Set-Cookie');

        if (!empty($session['default']['id'])) {
            $friendsList = $repo->getFriendList($session);
            
            if (!$friendsList) {
                // No friends list yet.
                (new Response())->sendJsonWithData(Response::HTTP_CODE_OK, []);
            }
        } else {
            (new Response())->sendJson(Response::HTTP_CODE_NOT_FOUND, true, 'Friends list not available.');
        }

        $friendUserIds = $friendsList->getUserIds();

        if (!empty($friendUserIds)) {
            $result = $repo->getOnlineFriends($friendUserIds);

            $onlineUsers = array_filter(
                array_combine(
                    $friendUserIds,
                    $result
                )
            );

            if ($onlineUsers) {
                $friendsList->setOnline($onlineUsers);
            }
        }

        (new Response())->sendJsonWithData(Response::HTTP_CODE_OK, $friendsList->toArray());
    }
}