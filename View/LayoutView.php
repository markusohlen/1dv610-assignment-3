<?php

namespace view;

class LayoutView 
{
	private $dtv;
	
	public function __construct(DateTimeView $dtv)
	{
		$this->dtv = $dtv;
	}

    public function render(bool $isLoggedIn, $view) : void 
    {
		echo '<!DOCTYPE html>
			<html>
				<head>
					<meta charset="utf-8">
					<title>Login Example</title>
					<link rel="stylesheet" type="text/css" href="./style/style.css">
				</head>
				<body>
					<h1>Assignment 2</h1>
					' . $this->renderIsLoggedIn($isLoggedIn) . '
					
					<div class="container">
						' . $view->response($isLoggedIn) . '
						
						' . $this->dtv->show() . '
					</div>
				</body>
			</html>
		';
  	}

	public function userWantsToShowRegisterForm() : bool
	{
		if (isset($_GET["register"])) 
		{
			return true;
		}
		return false;
	}

  	private function renderIsLoggedIn(bool $isLoggedIn) : string 
  	{
    	if ($isLoggedIn) 
    	{
      		return '<h2>Logged in</h2>';
    	}
    	else 
    	{
      		return '<h2>Not logged in</h2>';
    	}
  	}
}
