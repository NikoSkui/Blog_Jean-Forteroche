<?php

namespace System\Session;

class PHPSession
{

  public function get($key, $default = null)
  {
    $this->ensureStarted();
    if (array_key_exists($key, $_SESSION)) {
      return $_SESSION[$key];
    }
    return $default;
  }

  public function set($key, $value)
  {
    $this->ensureStarted();
    $_SESSION[$key] = $value;
  }

  public function delete($key)
  {
    $this->ensureStarted();
    unset($_SESSION[$key]);
  }

	public function isLogged(){
		return isset($_SESSION['User']->role);
	}

  private function ensureStarted(){
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
  }
}
