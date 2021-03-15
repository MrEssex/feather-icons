<?php

namespace MrEssex\FeatherIcons\Test;

use MrEssex\FeatherIcons\Exceptions\FeatherIconsException;
use MrEssex\FeatherIcons\FeatherIcons;
use PHPUnit\Framework\TestCase;

class FeatherIconsTest extends TestCase
{

  public function testGeneration()
  {
    $icons = FeatherIcons::i();
    $icons->generateResources(__DIR__);
    self::assertTrue(true, $this->doesNotPerformAssertions());
  }

  public function testSettingIcons()
  {
    $icons = FeatherIcons::i();
    $icons->setIcons(['arrow-diagonal']);
    self::assertEquals(['arrow-diagonal'], $icons->getIcons());

    $this->expectExceptionObject(FeatherIconsException::fileDoesnotExist('arrow-diagonal.svg'));
    $icons->generateResources(__DIR__, 'testTwo');
  }

}
