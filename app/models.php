<?
class RedtubeModel
{
   protected $api;
   protected $app;

   public function __construct($app) {
      $this->api = $app->Api;
      $this->app = $app;
   }

   public function searchVideo($params = array()) {
      $params['data'] = 'redtube.Videos.searchVideos';
      
      $redtubeResponse = $this->api->redTubeApiCall($params);
      return $redtubeResponse;
   }

   public function getVideoById($params = array()) {
      $params['data'] = 'redtube.Videos.getVideoById';
       
      $redtubeResponse = $this->api->redTubeApiCall($params);
      return $redtubeResponse;
   }

   public function isVideoActive() {
      //nothing
   }
   
   public function getVideoEmbedCode($params = array()) {
      $params['data'] = 'redtube.Videos.getVideoEmbedCode';
      
      $redtubeResponse = $this->api->redTubeApiCall($params);
      return $redtubeResponse;
   }
   
   public function getDeletedVideos() {
      return $this->api->countUser();
   }
   
   public function getCategoriesList() {
      return $this->api->countUser();
   }
   
   public function getTagList() {
      return $this->api->countUser();
   }
   
   public function getStarList() {
      return $this->api->countUser();
   }
   
   public function getStarDetailedList() {
      return $this->api->countUser();
   }
}