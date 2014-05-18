<?
class RedtubeModel
{
   protected $api;
   protected $app;

   public function __construct(Pimple $di) {
      $this->api = $di['Api'];
      $this->app = $di['app'];
   }

   public function searchVideo($params = array()) {
      $params['data'] = 'redtube.Videos.searchVideos';
      
      $redtubeResponse = $this->api->redTubeApiCall($params);
      return Helpers::xmlToArray(new SimpleXMLElement($redtubeResponse));
   }

   public function getVideoById() {
      return $this->api->allUsers();
   }

   public function isVideoActive() {
      return $this->api->countUser();
   }
   
   public function getVideoEmbedCode() {
      return $this->api->countUser();
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