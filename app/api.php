<?

class Api {
   public $redtubeUrl = 'http://api.redtube.com/';
   public $call = '';
   public $memcache_prefix = 'api:redtube:';
   
   public function __construct(Pimple $di) {
   }

   public function redTubeApiCall($params = array()) {
	$query_string = '?';
        $params['output'] = 'xml';
        ksort($params);
       
        foreach($params as $k=>$v){
            $query_string .= $k.'='.$v.'&';
        }
	
        $query_string = rtrim($query_string,'&');

        $memcache = new Memcache;
        $mckey = $this->memcache_prefix.$query_string;
        $content = $memcache->get($mckey);
        
        if($content === FALSE || isset($_GET['clearCacheSuperSecret'])) {
            $content = file_get_contents($this->redtubeUrl.$query_string);
            $memcache->set($mckey, $content, 3600);
        }

        //sd($this->memcache_prefix.$query_string);
        return $content;
    }
 
}