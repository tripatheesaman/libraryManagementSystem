<?php

namespace Tests\Unit;

use App\Contracts\UserAuthInterface;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class UserAuthInterfaceTest extends TestCase
{
  public function testInterfaceMethods()
  {
    $this->assertTrue(interface_exists(UserAuthInterface::class));
    $interface = new ReflectionClass(UserAuthInterface::class);
    $methods = $interface->getMethods();
    $expectedMethods = [
      'register',
      'login',
      'logout'     
    ];
    $this->assertEquals($expectedMethods, array_map(fn($method) => $method->getName(), $methods));
  }
}
