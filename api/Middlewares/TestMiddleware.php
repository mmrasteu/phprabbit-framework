<?php 

namespace Rabbit\Middlewares;

use Rabbit\Http\Response;
use Rabbit\Http\Request;

class TestMiddleware { 


  public function handle(Request $request, Response $response, callable $next) { 
    //var_dump('Middle actuando');
    //die();
  }
}