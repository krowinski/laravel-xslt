xslt + xml for laravel 5

USAGE


1. install using composer 
2. create welcome.xsl in resources/views
3. write some test function like index in WelcomeController.php
/**
 * Show the application welcome screen to the user.
 *
 * @return Response
 */
public function index()
{
\View::addAttr('template', 'hello');
\View::addTag('template', 'hello')->addAttr('aaaa', 'zzz');
\View::addTag('test', '123');

	return view('welcome');
}


