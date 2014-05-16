<?
class RedtubeModel
{
   protected $api;
   protected $app;

   public function __construct(Pimple $di) {
      $this->api = $di['Api'];
      $this->app = $di['app'];
   }

   public function find($id) {
      return $this->api->findUser($id);
   }

   public function all() {
      return $this->api->allUsers();
   }

   public function count() {
      return $this->api->countUser();
   }
}