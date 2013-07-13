<?php
/**
 *  Helper Easy Minify - compress Js and CSS in a easy way and on the fly
 *  Baseado no Plugin Easy Compressor Plugin do
 *    Glauco Custódio (@glauco_dsc) <glauco.custodio@gmail.com>     
 *    https://github.com/glaucocustodio/easy-compressor-plugin
 *    http://blog.glaucocustodio.com - http://glaucocustodio.com
 * 
 */
App::uses('HtmlHelper', 'View/Helper');
class MinifyHelper extends HtmlHelper {
  
  public $helpers = array('Html');
  
  /**
   * Método responsável por gerar hash da soma do tempo de modificação de todos os arquivos 
   * e preparar a string  de arquivos que vai ser comprimido
   * 
   * @param array  $assets os arquivos que vão ser comprimido
   * @param string $type tipo do arquivo css ou js
   * @return hash codificada dos nomes dos arquivos com a data de modificação
   */
  public function getHashFiles($assets = array(), $type = NULL){
    
    $basePath = ($type == 'css')? CSS : JS;
    $modificationTime = 0;
    
    foreach($assets as $c){
      $modificationTime += filemtime($basePath . $c . ".$type");
    }
    
    return sha1($modificationTime . implode(',', $assets));
  }
    
  /**
   * Método responsável por retornar os scripts js minificados
   * 
   * @param  array $arquivos
   * @return tag de script
   */
  public function script($arquivos){
    
    if(Configure::read('debug') == 0 || Configure::read('Minify.enabled')){

      $nomeArquivoJs = 'js.min_'. $this->getHashFiles($arquivos, 'js') . '.js';
     
      if (!file_exists(JS . $nomeArquivoJs)) {
        
        App::import('Vendor', 'jsmin', array('file' => 'jsmin/jsmin.php'));

        //apagar todos os arquivos que começam por js.min_ 
      /*  $pasta = opendir(JS);
        while ($oldJs = readdir($pasta)){
            if ($oldJs != '.' && $oldJs != '..'){
                if(substr($oldJs, 0,7) == 'js.min_')
                  unlink(JS.$oldJs);
            }
        }*/

        $jsFinal = null;
        foreach($arquivos as $c){
          $jsFinal .= JsMin::minify(file_get_contents(JS.$c.'.js')); 
        }
        file_put_contents(JS . $nomeArquivoJs, $jsFinal);     
      }
      return $this->Html->script($nomeArquivoJs);
    }else
      return $this->Html->script($arquivos);
  }
  /**
   *  Método responsável por retornar os scripts css minificados
   * 
   * @param  array $arquivos
   * @return tag de script
   */
  public function css($arquivos){
   
    if(Configure::read('debug') == 0 || Configure::read('Minify.enabled')){

      $nomeArquivo = 'css.min_'. $this->getHashFiles($arquivos, 'css') . '.css';
     
      if (!file_exists(CSS . $nomeArquivo)) {
        App::import('Vendor', 'cssmin', array('file' => 'cssmin/CssMin.php'));
        // apagar todos os arquivos que começam por css.min_
      /* $pasta = opendir(CSS);
        while ($oldCss = readdir($pasta)){
            if ($oldCss != '.' && $oldCss != '..'){
                  if(substr($oldCss, 0,8) == 'css.min_')
                    unlink(CSS.$oldCss);
            }
        }*/
        $final = null;
        foreach($arquivos as $c){
          $final .= CssMin::minify(file_get_contents(CSS.$c.'.css'));
        }
        file_put_contents(CSS . $nomeArquivo, $final);          
      }
      return $this->Html->css($nomeArquivo);
    }else
      return $this->Html->css($arquivos);
  }
}
