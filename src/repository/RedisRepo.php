<?php
namespace app\repository;

/**
 * Connection to the redis database.
 * <p/>
 * <p><a href="RedisRepo.php.html"><i>View Source</i></a></p>
 *
 * @author <a href="mailto:eduardo.scarello@gmail.com">Eduardo Scarello</a>
 */
class RedisRepo {
    const FRIENDS_CACHE_PREFIX_KEY = 'chat:friends:{:userId}';
    const ONLINE_CACHE_PREFIX_KEY = 'chat:online:{:userId}';
    
    private $redis;
    
    public function __construct($config, $redis) {
        $this->redis = $redis;
        $this->redis->connect($config->getRedisHost(), $config->getRedisPort());
        
        if (!$this->redis->isConnected()) {
            throw new \RedisException('Server error, can\'t connect.');
        }
        
        // Set Redis serialization strategy
        $this->redis->setOption(\Redis::OPT_SERIALIZER, \Redis::SERIALIZER_PHP);
    }
    
    public function getSession($hash) {
        return $this->redis->get(join(':', ['PHPREDIS_SESSION', $hash]));
    }
    
    public function getFriendList($session) {
        return $this->redis->get(
                str_replace('{:userId}', 
                $session['default']['id'], static::FRIENDS_CACHE_PREFIX_KEY)
        );
    }
    
    public function getOnlineFriends($friendUserIds) {
        $keys = array_map(function ($userId) {
                return str_replace('{:userId}', $userId, static::ONLINE_CACHE_PREFIX_KEY);
            }, $friendUserIds);
            
        return $this->redis->mget($keys);
    }
}
