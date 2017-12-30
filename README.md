# laravel-xslt 

[![Latest Stable Version](https://poser.pugx.org/krowinski/laravel-xslt/v/stable)](https://packagist.org/packages/krowinski/laravel-xslt) [![Total Downloads](https://poser.pugx.org/krowinski/laravel-xslt/downloads)](https://packagist.org/packages/krowinski/laravel-xslt) [![Latest Unstable Version](https://poser.pugx.org/krowinski/laravel-xslt/v/unstable)](https://packagist.org/packages/krowinski/laravel-xslt) [![License](https://poser.pugx.org/krowinski/laravel-xslt/license)](https://packagist.org/packages/krowinski/laravel-xslt)

XSLT template engine for laravel 5

# Instalation

1. Install using composer in your laravel project

```sh
composer require krowinski/laravel-xslt
```

2. Add this line to app.php at the end of 'providers' array

```php
Krowinski\LaravelXSLT\XSLTServiceProvider::class,
```

3. Create welcome.xsl in resources/views

```html

<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common" xmlns:str="http://exslt.org/strings" xmlns:php="http://php.net/xsl" exclude-result-prefixes="exslt str php">

    <xsl:output encoding="UTF-8" method="xml" omit-xml-declaration="yes" indent="yes"
                doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" cdata-section-elements="script"/>

    <xsl:template match="/">

        <head>
            <title>Laravel</title>

            <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css"/>

            <style>
                html, body {
                height: 100%;
                }

                body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
                }

                .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
                }

                .content {
                text-align: center;
                display: inline-block;
                }

                .title {
                font-size: 96px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="content">
                    <div class="title">Laravel 5 XSLT engine template</div>
                </div>
            </div>
        </body>
    </xsl:template>

</xsl:stylesheet>
```

4. Add data to xml using simple xml functions

```php
/**
 * Show the application welcome screen to the user.
 *
 * @return Response
 */
public function index()
{	
	// adds to main xml /App attributte name template with value  = hello
	\View::addAttribute('name template ', 'hello');
	// create child template to /App with value hello and add aaa and zzz atribute to template.
	\View::addChild('template', 'hello', false)->addAttribute('aaaa', 'zzz');
	// creates parent example and adds childs foo and bar to it 
	\View::addArrayToXmlByChild(['foo', 'bar'], 'example', false); 
	// add to parent App child bar and zzz
	\View::addArrayToXml(['bar', 'zzz'], false);

	return view('welcome');
}
```

#Add your own data using Laravel Events!

Add to EventServiceProvider.php
 
```php
use Krowinski\LaravelXSLT\Engines\XSLTEngine;
```

and to protected $listen array

```php
XSLTEngine::EVENT_NAME => [
    'App\Listeners\XSLTDebugBar'
],
```
             
create file Listeners\XSLTDebugBar.php      
   
create your event handle for example DebugBar (barryvdh/laravel-debugbar) 
   
```php
<?php


namespace App\Listeners;


use DebugBar\DataCollector\MessagesCollector;
use DebugBar\DebugBar;
use Illuminate\Support\Facades\App;
use Krowinski\LaravelXSLT\Events\XSLTEngineEvent;

/**
* Class XSLTDebugBar
* @package App\Listeners
*/
class XSLTDebugBar
{
   /**
    * @param XSLTEngineEvent $event
    */
   public function handle(XSLTEngineEvent $event)
   {
       $dom = new \DOMDocument;
       $dom->preserveWhiteSpace = false;
       $dom->loadXML($event->getExtendedSimpleXMLElement()->saveXML());
       $dom->formatOutput = true;
       $xml_string = $dom->saveXML();

       /** @var DebugBar $debugBar */
       $debugBar = App::make('debugbar');
       if (false === $debugBar->hasCollector('XML'))
       {
           $debugBar->addCollector(new MessagesCollector('XML'));
       }
       /** @var MessagesCollector $collector */
       $collector = $debugBar->getCollector('XML');
       $collector->addMessage($xml_string, 'info', false);
   }
}
```   
               
