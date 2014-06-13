<?

class Api {
   public $redtubeUrl = 'http://api.redtube.com/';
   public $call = '';
   public $memcache_prefix = 'api:redtube:';
   
   public function __construct($app) {
   }

   public function redTubeApiCall($params = array()) {
	$query_string = '?';
        $params['output'] = 'xml';
        ksort($params);
       
        foreach($params as $k=>$v){
            if(is_array($v)) {
                foreach ($v as $v2) {
                    $query_string .= $k.'[]='.$v2.'&';
                }  
            } else {
                $query_string .= $k.'='.$v.'&';
            }
        }
	
        $query_string = rtrim($query_string,'&');
        
        $memcache = new Memcache;
        $mckey = $this->memcache_prefix.$query_string;
        $content = $memcache->get($mckey);
        
        if($content === FALSE || isset($_GET['clearCacheSuperSecret'])) {
            switch ($params['data']) {
                case 'redtube.Videos.getVideoEmbedCode':
                case 'redtube.Videos.getVideoById':
                    $ttl = 86400;
                    break;
                case 'redtube.Videos.searchVideos':
                default:
                    $ttl = 3600 * 6;
                    break;
            }
            
            $content = file_get_contents($this->redtubeUrl.$query_string);
            $content =  Helpers::xmlToArray(new SimpleXMLElement($content));
            $memcache->set($mckey,  $content, $ttl);
        }

        //sd($this->memcache_prefix.$query_string);
        return $content;
    }
 
}