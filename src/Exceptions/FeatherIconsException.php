<?php
namespace MrEssex\FeatherIcons\Exceptions;

use Exception;

/**
 * Class FeatherIconsException
 *
 * @package MrEssex\FeatherIcons\Exceptions
 */
class FeatherIconsException extends Exception
{

  /**
   * @param string $filename
   *
   * @return FeatherIconsException
   */
  public static function fileDoesnotExist(string $filename): FeatherIconsException
  {
    return new self(
      sprintf(
        "The specified Icon: %s doesn't exists",
        $filename
      ), 500
    );
  }

}
