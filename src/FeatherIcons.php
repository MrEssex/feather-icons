<?php

namespace MrEssex\FeatherIcons;

use DOMDocument;
use DOMNode;
use Exception;
use MrEssex\FeatherIcons\Exceptions\FeatherIconsException;

/**
 * Class FeatherIcons
 */
class FeatherIcons
{

  protected DOMDocument $_out;
  protected string $_namespace = 'http://www.w3.org/2000/svg';
  protected static ?FeatherIcons $_instance = null;
  /** @var string[] */
  protected array $_icons = [
    'arrow-left',
  ];

  /**
   * @return FeatherIcons
   */
  public static function i(): FeatherIcons
  {
    if(!self::$_instance)
    {
      self::$_instance = new FeatherIcons();
    }

    return self::$_instance;
  }

  /**
   * FeatherIcons constructor.
   */
  public function __construct()
  {
    $this->_out = new DOMDocument();
    $this->_out->formatOutput = true;

    $root = $this->_out->createElementNS($this->_namespace, 'svg');
    $this->_out->appendChild($root);
    $this->_out->documentElement->setAttribute('width', '0');
    $this->_out->documentElement->setAttribute('height', '0');
  }

  /**
   * @param string $filename
   *
   * @throws FeatherIconsException
   */
  protected function _add(string $filename): void
  {
    $file = new DOMDocument();
    $directory = __DIR__;
    try
    {
      $file->load(
        $directory . DIRECTORY_SEPARATOR . '_resources' . DIRECTORY_SEPARATOR
        . 'icons' . DIRECTORY_SEPARATOR . $filename
      );
    }
    catch(Exception $exception)
    {
      throw FeatherIconsException::fileDoesnotExist($filename);
    }

    $src = $file->documentElement;

    $g = $this->_out->createElementNS($this->_namespace, 'symbol');
    $this->_out->documentElement->appendChild($g);
    $g->setAttribute('id', 'icon-left');

    /** @var DOMNode $child */
    foreach($src->childNodes as $child)
    {
      if($child->nodeType === XML_ELEMENT_NODE && $child->tagName !== 'metadata')
      {
        $g->appendChild($this->_out->importNode($child, true));
      }
    }
  }

  /**
   * @param array $icons
   */
  public function setIcons(array $icons): void
  {
    $this->_icons = $icons;
  }

  /**
   * @param string $path
   * @param string $filename
   */
  protected function _generateSVGs(string $path, string $filename): void
  {
    $this->_out->normalizeDocument();
    $this->_out->save($path . DIRECTORY_SEPARATOR . $filename . '.svg');
  }

  /**
   * @param string $path
   * @param string $filename
   *
   * @throws FeatherIconsException
   */
  public function generateResources(string $path, string $filename = 'feather-icons'): void
  {
    foreach($this->getIcons() as $icons)
    {
      $this->_add($icons . '.svg');
    }

    $this->_generateSVGs($path, $filename);
  }

  /**
   * @return string[]
   */
  public function getIcons(): array
  {
    return $this->_icons;
  }

}
