<?php

namespace App\Blog\controllers;

use System\Http\Request;

class AdminBlogController
{

  public function __construct()
  {

  }
   
  public function __invoke (Request $request)
  {
    r('Admin');die();
  }
}