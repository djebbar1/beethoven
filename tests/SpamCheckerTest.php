<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Music;
use App\SpamChecker;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;


class SpamCheckerTest extends TestCase
{
    public function testSomething(): void
    {
        $title = 'Jul';
        $music = new Music();
        $music->setTitle($title);
        $this->assertNotEmpty($music->getTitle());
    }
}
