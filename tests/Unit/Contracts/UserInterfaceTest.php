<?php

namespace Tests\Unit;

use App\Contracts\UserInterface;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class UserInterfaceTest extends TestCase
{
  public function testInterfaceMethods()
  {
    $this->assertTrue(interface_exists(UserInterface::class));
    $interface = new ReflectionClass(UserInterface::class);
    $methods = $interface->getMethods();
    $expectedMethods = [
      'createUser',
      'getAllUsers',
      'getUserByEmail',
      'updateUser'      
    ];
    $this->assertEquals($expectedMethods, array_map(fn($method) => $method->getName(), $methods));
  }
}
