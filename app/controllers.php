<?
abstract class Controller
{
   protected $app;
   protected $model;

   public function __construct($app) {
      $this->app = $app;
      $this->init($app);
   }

   public abstract function init($di);
}

class RedtubeController extends Controller
{
   public function init($app) {
      $this->model = $app->RedtubeModel;
   }
   
   public function getSearchPage ($search, $orientation = '', $options = array()) {
       //query strings
        if(!isset($options['page']) || !is_numeric($options['page']) || $options['page'] < 1) {
            $page = 1;
        } else {
            $page = $options['page'];
        }
        
        if(empty($options['order']) || !in_array($options['order'], array('rating', 'mostviewed'))) {
            $order = 'newest';
        } else {
            $order = $options['order'];
        }

        //params
        $data['params'] = array(
            'page' => $page,
            'search' => str_replace(' ', '+', $search),
            'ordering' => $order,
        );
        //for gay and shemale
        if(in_array($orientation,array('shemale','gay'))) {
             $data['params']['category'] = $orientation;
        }

        //SEO data
        $data['seo']['title'] = 'Elmacanon: Best Free '. $orientation . ' ' . str_replace('+', ' ', $search) . ' Porn Videos';
        if($page == 1 && $order == 'newest') {
            $data['seo']['index'] = true;
        } else {
            $data['seo']['index'] = false;
        }

        //getting video results
        $data['results'] = $this->searchVideo($data['params']);
        //fixing format when only 1 result
        if($data['results']['count'] == 1) {
            $data['results']['videos'] = array($data['results']['videos']);
        }
        
        return $data;
   }

   public function searchVideo($params = array()) {
      $results = $this->model->searchVideo($params);
      $error = '';
      
      if(isset($results['error'])) {
          $error = $results['error'];
          $params['search'] = 'big+dick';
          $params['page'] = 1;
          $results = $this->model->searchVideo($params);
      }
      
      return array(
          'videos' => current($results['root']['videos']),
          'count' => $results['root']['count'],
          'error' => $error,
      );
   }
   
   public function getVideoEmbedCode($params = array()) {
      $results = $this->model->getVideoEmbedCode($params);
      
    /*$data['results']['decoded_embed']
     * <object height="344" width="434">
     *  <param name="allowfullscreen" value="true">
     *  <param name="AllowScriptAccess" value="always">
     *  <param name="movie" value="http://embed.redtube.com/player/?id=759249&style=redtube">
     *  <param name="FlashVars" value="id=759249&style=redtube&autostart=false">
     *  <embed src="http://embed.redtube.com/player/?id=759249&style=redtube" allowfullscreen="true" AllowScriptAccess="always" flashvars="autostart=false" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" height="344" width="434" />
     * </object>"    
     *   
     */
    
      $error = '';
      
      if(isset($results['error'])) {
         $error = $results['error'];
      }
      
      $decoded_embed = base64_decode($results['embed']['code']);
      $decoded_embed = str_replace('width="434"', 'width="634"', $decoded_embed);
      $decoded_embed = str_replace('height="344"', 'height="400"', $decoded_embed);
    
      return array(
          'coded_embed' => $results['embed']['code'],
          'decoded_embed' => $decoded_embed,
          'error' => $error,
      );
   }
   
   public function getVideoDetails($params = array()) {
       //getting embed code
      $results = $this->getVideoEmbedCode($params);
      
      if(!empty($results['error'])) {
          return FALSE;
      }
 
      $response = array(
         'coded_embed' => $results['coded_embed'],
         'decoded_embed' => $results['decoded_embed'],
      );
      //getting additional info
      $results = $this->model->getVideoById($params);
      $response['video_details'] = $results;
      
      return $response;
   }
   
   public function all() {
      //$this->app->render('users.php', array('users' => $this->service->all()));
      echo 'Found all users.<br>';
      var_dump($this->model->all());
   }
}