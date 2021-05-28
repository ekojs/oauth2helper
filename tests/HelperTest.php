<?php declare(strict_types=1);

namespace EJSHelper\Tests;

use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase {

    /**
     * @group base64
     */
    public function testBase64UrlEncode(): void
    {
        $this->assertEquals("aHR0cHM6Ly93d3cuYmFzZTY0dXJsLmNvbQ",base64url_encode("https://www.base64url.com"));
    }

    /**
     * @group base64
     */
    public function testBase64UrlDecode(): void
    {
        $this->assertEquals("https://www.base64url.com",base64url_decode("aHR0cHM6Ly93d3cuYmFzZTY0dXJsLmNvbQ"));
    }

    /**
     * @group state
     */
    public function testGenerateState(): void
    {
        $this->assertStringMatchesFormat('%x', state());
    }

    /**
     * @group codechal
     */
    public function testGenerateCodeChallenge(): void
    {
        $this->assertIsArray(codeChallenge());
    }

    /**
     * @group codechal
     */
    public function testCodeChallenge(): void
    {
        list($code,$chal) = codeChallenge("dBjftJeZ4CVP-mB92K27uhbUJU1p1r_wW1gFWFOEjXk");
        $this->assertEquals("E9Melhoa2OwvFrEMTJguCHaoeK1t8URWbuGJSstw-cM",$chal);
    }

    /**
     * @group codechal
     */
    public function testFailedCodeChallenge(): void
    {
        $this->assertNull(codeChallenge("dBjftJ@Z4CVP#mB92K27uhbUJU1p1r_wW1gFWFOEjXk"));
    }
}