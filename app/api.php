<?

/***** replace with real db access *****/

class Api
{
   public function __construct(Pimple $di) {
   }

   private function createUser($id) {
      $user = new stdClass();
      $user->id = $id;
      return $user;
   }

   public function findUser($id) {
      return $this->createUser($id);
   }

   public function allUsers() {
      return array($this->createUser(1), $this->createUser(2), $this->createUser(3));
   }

   public function countUser() {
      return rand(1000000,2000000);
   }
}