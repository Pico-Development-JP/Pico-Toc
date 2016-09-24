<?php
/**
 * Pico Insert TOC Plugin
 * 記事のヘッダより見出しリストを自動生成するプラグイン
 *
 * @author TakamiChie
 * @link http://onpu-tamago.net/
 * @license http://opensource.org/licenses/MIT
 * @version 1.0
 */
class Pico_TOC extends AbstractPicoPlugin {

  protected $enabled = false;
  
	public function onConfigLoaded(&$config)
	{
		$this->headinglevel = isset($config["headerlv"]["level"]) ?
		    $config["headerlv"]["level"] : 3;
	}

  public function onPageRendering(Twig_Environment &$twig, array &$twigVariables, &$templateName)
  {
    $content = $twigVariables["content"];
    $twigVariables["TOC"] = $this->createTOC($content);
    $twigVariables["content"] = $content;
  }

  /**
   * TOCを生成する(テストのため、別メソッドに分離)
   * @ref: http://1bit.mobi/20110106215505.html
   */
  private function createTOC(string &$content)
  {
    $toc = "";
    $idcount = 1;
    $currentLevel = 0;
    $minlevel = 9;
    $check = function(&$currentLevel, $level, &$toc){
      $prevLevel = $currentLevel;
      if($prevLevel == $level) $toc .= '</li>';
      while($currentLevel < $level)
      {
        $toc .= '<ol><li>';
        $currentLevel++;
      }
      while($currentLevel > $level)
      {
        $toc .= '</li></ol>';
        $currentLevel--;
      }
      if($level > 0 && $prevLevel > $level) $toc .= '</li>';
      if($level > 0 && $prevLevel >= $level) $toc .= '<li>';
    };
    $content = preg_replace_callback('|<h([1-6])([^>]*)>(.*)</h\1>|', 
        function($matches) use (&$currentLevel, &$minlevel, &$idcount, &$toc, $check){
          // id払い出し
          $id = "toc_" . $idcount++;
          // TOC処理
          $minlevel = min($minlevel, $matches[1]);
          $check($currentLevel, $matches[1], $toc);
          $toc .= "<a href=\"#$id\">${matches[3]}</a>";
          // return
          return "<h${matches[1]} id=\"$id\"${matches[2]}>${matches[3]}</h${matches[1]}>";
        },
        $content);
    $check($currentLevel, 0, $toc);
    if($minlevel > 1)
    {
      // TOCの余計なolを削除
      $toc = preg_replace(
        '|(</li></ol>){' . $minlevel . '}$|', '\1', 
        preg_replace('|^(<ol><li>){' . $minlevel . '}|', '\1', $toc));
    }
    return $toc;
  }
}

?>
