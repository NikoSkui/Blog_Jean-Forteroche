<?php

namespace App\User\controllers;


use App\Entity\User;
use App\Libraries\RouterAware;

use System\Container\DIContainer;
use System\Http\Request;
use System\Router;
use System\Renderer\RendererInterface;
use System\Session\PHPSession;

class UserControlController
{
  /**
   * @var RendererInterface
   */
  private $renderer;

  /**
   * @var Router
   */
  private $router;

  /**
   * @var Session
   */
  private $session;

  /**
   * @var Container
   */
  private $container;

  /**
   * @var string
   */
  protected $viewPath = "@users";

  /**
   * @var string
   */
  protected $prefixName = "User#Control";

  use RouterAware;

  public function __construct(RendererInterface $renderer,Router $router,PHPSession $session , DIContainer $container) 
  {
    // Idratation 
    $this->renderer = $renderer;
    $this->router = $router;
    $this->container = $container;
    $this->session = $session;
  }
   
  public function __invoke (Request $request)
  {
    $route = $request->getAttribute(\System\Router\RouteMatched::class);

    if (preg_match('#logout#i', $route->getPattern())) {
      return $this->logout($request);
    }

    return $this->login($request);
  }

  /**
  * Function for the user to access a secure space
  */
  public function login ($request)
  {
    if ($request->getMethod() === 'POST') {

      $datas = $this->getParams($request);
      $users = $this->container->get('users.login');
      $user = $this->getNewEntity($datas);

      $found_username = array_search($user->username, array_column($users,'username'));
      $found_email = array_search($user->username, array_column($users,'email'));

      // Match -> (Username or Email) and Password Ok
      if (
        (strlen($found_username) > 0) &&
        (password_verify($user->password,$users[$found_username]['password'])) ||
        (strlen($found_email) > 0) && 
        (password_verify($user->password,$users[$found_email]['password'])) 
      ) {
          return $this->openGate($user); 
      }

    }
    $username = '';
    return $this->renderer->render($this->viewPath . '/login', compact('username'));
  }

  /**
  * Function for the user to disconnect from a secure space
  */
  public function logout ()
  {
    $this->session->delete('user');
    return $this->redirect('Front#Base#Index');   
  }



  /**
  * Filter to recover only of the desired keys.
  */
  private function getParams (Request $request)
  {
    // Step 1: Filter
    $datas =  array_filter($request->getParsedBody(), function ($key) {
        return in_array($key, ['username', 'password']);
      }, ARRAY_FILTER_USE_KEY);
    return $datas;
  }

  /**
  * Create entity for user and Session
  */
  private function getNewEntity($datas)
  {
    $user = new User();
    $user->username = htmlentities($datas['username']);
    $user->password = htmlentities($datas['password']);
    $user->role = 'admin';
    return $user;
  }

  /**
  * Redirect to secure space
  */
  private function openGate($user)
  {
    unset($user->password);
    $this->session->set('user',$user);
    return $this->redirect('Admin#Chapters#Read');
  }

  /**
  * Create Hash new users
  */
  private function encrypt($value)
  {
    r(password_hash($value, PASSWORD_BCRYPT));
  }
  

    
}
