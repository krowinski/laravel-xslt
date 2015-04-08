xslt + xml for laravel 5

USAGE


1. install using composer 
adding 

 "repositories": [
        {
            "type": "git",
            "url":  "https://github.com/krowinski/laravel-xslt.git"
        }
    ],
    
    
    and 
    
     "require": {
                "krowinski/laravel-xslt": "dev-master",
        },


2. create welcome.xsl in resources/views

<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet
        version="1.0"
        xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
        xmlns:exslt="http://exslt.org/common"
        xmlns:str="http://exslt.org/strings"
        exclude-result-prefixes="exslt str">


    <xsl:output encoding="UTF-8" method="xml" omit-xml-declaration="yes" indent="yes"
                doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"
                doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" cdata-section-elements="script"/>

    <xsl:template match="/">
        <h3>test</h3>
    </xsl:template>

</xsl:stylesheet>


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


