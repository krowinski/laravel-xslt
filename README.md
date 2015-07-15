xslt + xml for laravel 5

USAGE


1 install using composer in your laravel project
```bash
composer require krowinski/laravel-xslt dev-master
```
2 add this line to app.php 'providers' array
```php
'Krowinski\LaravelXSLT\XSLTServiceProvider',
```
3 create welcome.xsl in resources/views
```html
<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:exslt="http://exslt.org/common" xmlns:str="http://exslt.org/strings" xmlns:php="http://php.net/xsl" exclude-result-prefixes="exslt str php">

    <xsl:output encoding="UTF-8" method="xml" omit-xml-declaration="yes" indent="yes"
                doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" cdata-section-elements="script"/>

    <xsl:template match="/">
        <h3>test</h3>
        <!-- u can use php in xslt! -->
        <xsl:value-of select="php:function('strlen', /template)"/>
        <!-- also static method in namespace class -->
        <xsl:if test="'true' = php:function('App\Model::checkTest', string(/template), 'more params')">
        	tada!
        </xsl>
    </xsl:template>

</xsl:stylesheet>
```

4 write some test function like index in WelcomeController.php
```php
/**
 * Show the application welcome screen to the user.
 *
 * @return Response
 */
public function index()
{
\View::addAtribute('template', 'hello');
\View::addChild('template', 'hello')->addAtribute('aaaa', 'zzz');
\View::addChild('test', '123');

	return view('welcome');
}
```

5. TODO
- support for xsltcache lib
- config 
- start usign git taging (soo lazyyy)

