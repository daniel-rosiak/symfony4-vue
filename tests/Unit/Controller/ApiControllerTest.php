<?php

namespace App\Tests\Unit\Controller;


use PHPUnit\Framework\TestCase;
use App\Controller\Api\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Util\PHPUnitUtil;

/**
 * Class ApiControllerTest
 * @package App\Controller
 */
class ApiControllerTest extends TestCase
{

    public function test___response()
    {
        $apiControllerStub = $this->getMockForAbstractClass(ApiController::class);

        $method = PHPUnitUtil::getMethod($apiControllerStub, 'response');
        $data = $method->invoke($apiControllerStub, []);

        $this->assertInstanceOf(JsonResponse::class, $data);
    }

    public function test___prepareParameters()
    {
        $apiControllerStub = $this->getMockForAbstractClass(ApiController::class);

        $method = PHPUnitUtil::getMethod($apiControllerStub, 'prepareParameters');
        $data = $method->invoke($apiControllerStub, ['a' => 1, 'b' => 0, 'c'=> '', 'd' => [], 'e' => ['a' => 1]]);

        $this->assertInternalType('array', $data);
        $this->assertEquals(3, count($data));
    }

    public function test___unsetEmptyParameters()
    {
        $apiControllerStub = $this->getMockForAbstractClass(ApiController::class);

        $method = PHPUnitUtil::getMethod($apiControllerStub, 'unsetEmptyParameters');
        $data = $method->invoke($apiControllerStub, ['a' => 1, 'b' => 0, 'c'=> '']);

        $this->assertInternalType('array', $data);
        $this->assertEquals(2, count($data));
    }

}