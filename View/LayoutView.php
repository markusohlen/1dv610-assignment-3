<?php

namespace view;

class LayoutView {
  private static $register = "register";
  
  public function render($isLoggedIn, LoginView $v, DateTimeView $dtv, $lc, $rv) : void {
    $view = $this->decideView($v, $rv);

    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderIsLoggedIn($isLoggedIn) . '
          
          <div class="container">
              ' . $view->response($isLoggedIn) . '
              
              ' . $dtv->show() . '
          </div>
         </body>
      </html>
    ';
  }

  private function decideView($v, $rv) {
    $view = $v;
    
    if (isset($_GET[self::$register])) {
      $view = $rv;
    }

    return $view;
  }
  
  private function renderIsLoggedIn($isLoggedIn) : string {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }
}
