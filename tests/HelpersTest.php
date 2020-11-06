<?php

namespace Tests;

use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;
use Webpatser\Uuid\Uuid;

class HelpersTest extends TestCase
{
    public array $compressJson = [
        'status' => 200,
        'message' => 'success',
        'data' => [],
    ];
    public int $bytes = 10240;
    public array $cache = ['HelperTest', 'generateCacheKeyName', 'test', 'key'];
    public int $id = 987654321;
    public string $base62 = 'KHc6iHtXW3iD';
    public string $uuid = '4be0643f-1d98-573b-97cd-ca98a65347dd';
    public string $password = 'test';
    public string $key = '0123456789zxcvbn';
    public string $iv = '0123456789abcdef';
    public string $bank_number = '6661333775544230';
    public string $phone = '176138189090';
    public string $china_id = '110101192008297192';
    public string $encrypted_phone = '4633986310737477622';
    public string $encrypted_bank_number = '40456648251653137260';
    public string $encrypted_china_id = '80766759272141449076';

    /** @test */
    public function compressJson()
    {
        $this->assertObjectHasAttribute('zip_json_key', json_decode(compressJson($this->compressJson)));
    }

    /** @test */
    public function extractJson()
    {
        $data = extractJson(compressJson($this->compressJson));
        $this->assertArrayHasKey('status', $data);
    }

    /** @test */
    public function formatBytes()
    {
        $formatBytes = formatBytes($this->bytes);
        $this->assertSame('10 kB', $formatBytes);
    }

    /** @test */
    public function generateCacheKeyName()
    {
        $this->assertSame(
            'HelperTest:generateCacheKeyName:test:key',
            generateCacheKeyName($this->cache)
        );
    }

    /** @test
     * @throws \Exception
     */
    public function carbon()
    {
        $this->assertInstanceOf(Carbon::class, carbon());
        $this->assertEquals(Carbon::parse('Jan 1 2017'), carbon('Jan 1 2017'));
    }

    /** @test */
    public function base62()
    {
        $this->assertSame($this->base62, base62()->encode($this->id));
        $this->assertSame($this->id, (int) base62()->decode(base62()->encode($this->id)));
    }

    /** @test */
    public function str_humanize()
    {
        $this->assertIsString(str_humanize('user_id'));
        $this->assertSame('User id', str_humanize('user_id'));
    }

    /** @test */
    public function number_ordinalize()
    {
        $this->assertIsString(number_ordinalize(0));
        $this->assertSame('0th', number_ordinalize(0));
    }

    /** @test */
    public function number_ordinal()
    {
        $this->assertIsString(number_ordinal(0));
        $this->assertSame('th', number_ordinal(0));
    }

    /** @test */
    public function number_binary()
    {
        $this->assertIsString(number_binary(1024));
        $this->assertSame('1 kB', number_binary(1024));
    }

    /** @test */
    public function uuid()
    {
        $this->assertIsString(uuid(5, 'test', Uuid::NS_DNS)->string);
        $this->assertSame($this->uuid, uuid(5, 'test', Uuid::NS_DNS)->string);
    }

    /** @test */
    public function getSecret()
    {
        $secrets = getSecret(getcwd().'/tests/secrets');
        $this->assertIsObject($secrets);
        $this->assertIsArray($secrets->readAll());
        $this->assertSame($this->password, $secrets->readAll()['password']);
    }

    /** @test */
    public function testEncryptPhone()
    {
        $secret = fpe($this->key)->encrypt($this->phone, 10, false, $this->password, $this->iv);
        $this->assertIsString($secret);
        $this->assertSame($this->encrypted_phone, $secret);
    }

    /** @test */
    public function testEncryptBank()
    {
        $secret = fpe($this->key)->encrypt($this->bank_number, 10, false, $this->password, $this->iv);
        $this->assertIsString($secret);
        $this->assertSame($this->encrypted_bank_number, $secret);
    }

    /** @test */
    public function testEncryptChinaIDNumber()
    {
        $secret = fpe($this->key)->encrypt($this->china_id, 10, false, $this->password, $this->iv);
        $this->assertIsString($secret);
        $this->assertSame($this->encrypted_china_id, $secret);
    }

    /** @test */
    public function testDecryptPhone()
    {
        $plainValue = fpe($this->key)->decrypt($this->encrypted_phone, 10, false, $this->password, $this->iv);
        $this->assertIsString($plainValue);
        $this->assertSame($this->phone, $plainValue);
    }

    /** @test */
    public function testDecryptBank()
    {
        $plainValue = fpe($this->key)->decrypt($this->encrypted_bank_number, 10, false, $this->password, $this->iv);
        $this->assertIsString($plainValue);
        $this->assertSame($this->bank_number, $plainValue);
    }

    /** @test */
    public function testDecryptChinaIDNumber()
    {
        $plainValue = fpe($this->key)->decrypt($this->encrypted_china_id, 10, false, $this->password, $this->iv);
        $this->assertIsString($plainValue);
        $this->assertSame($this->china_id, $plainValue);
    }
}