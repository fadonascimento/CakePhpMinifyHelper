CakePhpMinifyHelper
===================

Helper CakePHP para minificar arquivos em Css e/ou JavaScript


  Baseado no Plugin Easy Compressor 
  Glauco Custódio (@glauco_dsc) <glauco.custodio@gmail.com>     
  https://github.com/glaucocustodio/easy-compressor-plugin
  http://blog.glaucocustodio.com - http://glaucocustodio.com
  http://blog.glaucocustodio.com/2012/09/28/compressor-de-javascript-e-css-para-cakephp-easy-compressor

O Helper utiliza bibliotecas JsMin and CSSMin  para comprimir os arquivos.

Para instalar e usar

1- Download do Helper para  app/View/Helper/

2- Download da ultima versao do "jsmin" (https://github.com/rgrove/jsmin-php/blob/master/jsmin.php) e do "cssmin" (http://code.google.com/p/cssmin/downloads/list) adicionar as bibliotecas na pastas app/Vendor/jsmin/ e app/Vendor/cssmin/ respectivamente

3- Adicionar o Heper em app/Controller/AppController como abaixo:
  public $helpers = array('Html', 'Text', 'Form', 'Minify');

5- Os metodos para minificar os arquivos sao os mesmos do HtmlHelper conforme abaixo:

  echo $this->Minify->script(array('jquery','plugin.jquery','custom'));
  echo $this->Minify->css(array('bootstrap','bootstrap-responsive','custom'));
  
  Caso queira podera incluir arquivos separados em seu layout
  
  echo $this->Minify->css(array('bootstrap'));

6- Setar debug para 0 em app/Config/core.php ou adicionar Configure::write('Minify.enabled', true);
  
  O Helper ira criar um arquivo unico minificado com todos os arquivos do array() com o nome de css.min_hash, caso esteja desalilitado o debug o Helper os arquivos retornaram separados e nao minificados,
  o hash e formado pela soma do tempo de modificação e os nomes de todos os arquivos que vai ser comprimido.
  Caso altere algum dos arquivos ou retire algum do array de arquivos, um novo arquivo e gerado.

