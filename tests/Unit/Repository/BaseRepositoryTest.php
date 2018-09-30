<?php

namespace App\Tests\Unit\Repository;


use PHPUnit\Framework\TestCase;
use App\Util\PHPUnitUtil;
use App\Repository\BaseRepository;

/**
 * Class BaseRepositoryTest
 * @package App\Repository
 */
class BaseRepositoryTest extends TestCase
{
    public function test___query()
    {
        $baseRepositoryStub = $this->getMockForAbstractClass(BaseRepository::class);

        $method = PHPUnitUtil::getMethod($baseRepositoryStub, 'query');

        $data = $method->invoke($baseRepositoryStub, 'users', 'GET');

        $this->assertInternalType('array', $data);
        $this->assertInternalType('object', $data['body']);
        $this->assertInternalType('array', $data['header']);
    }

    public function test___getJsonParameters()
    {
        $baseRepositoryStub = $this->getMockForAbstractClass(BaseRepository::class);

        $method = PHPUnitUtil::getMethod($baseRepositoryStub, 'getJsonParameters');

        $data = $method->invoke($baseRepositoryStub, []);
        $this->assertInternalType('string', $data);
        $this->assertEquals($data, '');

        $testData = ['a' => 1, 'b' => '2'];
        $data = $method->invoke($baseRepositoryStub, $testData);
        $this->assertInternalType('string', $data);
        $this->assertEquals(json_encode($testData), $data);
    }

    public function test___getUrlParameters()
    {
        $baseRepositoryStub = $this->getMockForAbstractClass(BaseRepository::class);

        $method = PHPUnitUtil::getMethod($baseRepositoryStub, 'getUrlParameters');

        $data = $method->invoke($baseRepositoryStub, []);
        $this->assertInternalType('string', $data);
        $this->assertEquals($data, '');

        $testData = ['a' => 1, 'b' => '2'];
        $data = $method->invoke($baseRepositoryStub, $testData);
        $this->assertInternalType('string', $data);
        $this->assertEquals(http_build_query($testData), $data);
    }

    public function test___parseHeadersFromCurlResponse()
    {
        $baseRepositoryStub = $this->getMockForAbstractClass(BaseRepository::class);

        $method = PHPUnitUtil::getMethod($baseRepositoryStub, 'parseHeadersFromCurlResponse');

        $data = $method->invoke($baseRepositoryStub, '');
        $this->assertInternalType('array', $data);

        $testData = 'HTTP/1.1 200 OK
Date: Sun, 30 Sep 2018 17:58:42 GMT
Content-Type: application/json; charset=utf-8
Content-Length: 443
Connection: keep-alive
Set-Cookie: __cfduid=d5df7e851e270030c790120530fd504791538330322; expires=Mon, 30-Sep-19 17:58:42 GMT; path=/; domain=.reqres.in; HttpOnly
X-Powered-By: Express
Access-Control-Allow-Origin: *
ETag: W/"1bb-D+c3sZ5g5u/nmLPQRl1uVo2heAo"
Expect-CT: max-age=604800, report-uri="https://report-uri.cloudflare.com/cdn-cgi/beacon/expect-ct"
Server: cloudflare
CF-RAY: 46289441f989bedf-FRA
';
        $data = $method->invoke($baseRepositoryStub, $testData);

        $this->assertInternalType('array', $data);
        $this->assertEquals(200, $data['code']);
    }


}