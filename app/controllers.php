<?
abstract class Controller
{
   protected $app;
   protected $model;

   public function __construct(Pimple $di) {
      $this->app = $di['app'];
      $this->init($di);
   }

   public abstract function init(Pimple $di);
}

class RedtubeController extends Controller
{
   public function init(Pimple $di) {
      $this->model = $di['RedtubeModel'];
   }

   public function searchVideo($params = array()) {
      $results = $this->model->searchVideo($params);
      $error = '';
      
      if(isset($results['error'])) {
          $error = $results['error'];
          $params['search'] = 'big+dick';
          $results = $this->model->searchVideo($params);
      }
      
      return array(
          'videos' => current($results['root']['videos']),
          'count' => $results['root']['count'],
          'error' => $error,
      );
   }

   public function all() {
      //$this->app->render('users.php', array('users' => $this->service->all()));
      echo 'Found all users.<br>';
      var_dump($this->model->all());
   }
}