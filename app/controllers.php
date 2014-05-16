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

   public function find($id) {
      //$this->app->render('user.php', array('user' => $this->service->find($id)));
      echo 'Found the user with id = ' . $id . '<br>';
      var_dump($this->model->find($id));
   }

   public function all() {
      //$this->app->render('users.php', array('users' => $this->service->all()));
      echo 'Found all users.<br>';
      var_dump($this->model->all());
   }
}