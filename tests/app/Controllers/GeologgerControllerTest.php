<?php
namespace Tests\App\Controllers;

use PHPUnit\Framework\TestCase;
use App\Controllers\GeologgerController;
use App\Models\GeoLink;
use App\Models\GeoLog;
use App\Config\App;

class GeologgerControllerTest extends TestCase
{
    private $geoLinkMock;
    private $geoLogMock;
    private $controller;

    protected function setUp(): void
    {
        parent::setUp();

        // Create mocks for the models
        $this->geoLinkMock = $this->createMock(GeoLink::class);
        $this->geoLogMock = $this->createMock(GeoLog::class);

        // Use getMockBuilder to mock only specific methods of the controller
        $this->controller = $this->getMockBuilder(GeologgerController::class)
            ->onlyMethods(['render', 'renderJson', 'isPost', 'getPost', 'getGet', 'validateCSRF', 'logError', 'generateCSRFToken', 'isAjax', 'getGeolocationData'])
            ->disableOriginalConstructor()
            ->getMock();

        // Manually inject mocks into the controller using reflection
        $reflection = new \ReflectionClass(GeologgerController::class);

        $geoLinkProperty = $reflection->getProperty('geoLink');
        $geoLinkProperty->setAccessible(true);
        $geoLinkProperty->setValue($this->controller, $this->geoLinkMock);

        $geoLogProperty = $reflection->getProperty('geoLog');
        $geoLogProperty->setAccessible(true);
        $geoLogProperty->setValue($this->controller, $this->geoLogMock);
    }

    public function testCreateGetRequest()
    {
        $this->controller->method('isPost')->willReturn(false);
        $this->controller->method('generateCSRFToken')->willReturn('test_csrf_token');

        $this->controller->expects($this->once())
            ->method('render')
            ->with(
                'geologger/create',
                $this->callback(function ($data) {
                    return $data['title'] === 'Create Tracking Link - ' . App::APP_NAME &&
                           $data['csrf_token'] === 'test_csrf_token';
                })
            );

        $this->controller->create();
    }

    public function testCreatePostSuccess()
    {
        $this->controller->method('isPost')->willReturn(true);
        $this->controller->method('getPost')->will($this->returnValueMap([
            ['original_url', null, 'https://example.com'],
            ['expires_at', null, ''],
            ['no_expiration', null, '1'],
            ['click_limit', null, '100'],
        ]));
        $this->controller->method('generateCSRFToken')->willReturn('new_csrf_token');

        $this->geoLinkMock->method('generateShortCode')->willReturn('short123');
        $this->geoLinkMock->method('create')->willReturn(1);
        $this->geoLinkMock->method('getTrackingUrl')->willReturn('http://track.url/short123');
        $this->geoLinkMock->method('getQRCodeUrl')->willReturn('http://qr.code/short123');

        $this->controller->expects($this->once())->method('validateCSRF');
        $this->controller->expects($this->once())
            ->method('render')
            ->with(
                'geologger/create',
                $this->callback(function ($data) {
                    return $data['success'] === true &&
                           $data['link']['short_code'] === 'short123' &&
                           $data['link']['original_url'] === 'https://example.com';
                })
            );

        $this->controller->create();
    }
    
    public function testCreatePostValidationError()
    {
        $this->controller->method('isPost')->willReturn(true);
        $this->controller->method('getPost')->will($this->returnValueMap([
            ['original_url', null, ''],
        ]));
        $this->controller->method('generateCSRFToken')->willReturn('new_csrf_token');

        $this->controller->expects($this->once())
            ->method('render')
            ->with(
                'geologger/create',
                $this->callback(function ($data) {
                    return !empty($data['errors']) &&
                           isset($data['form_data']);
                })
            );

        $this->controller->create();
    }

    public function testLogs()
    {
        $this->controller->method('getGet')->with('page', 1)->willReturn(1);
        $this->geoLogMock->method('getAll')->willReturn([['id' => 1, 'ip_address' => '127.0.0.1']]);
        $this->geoLogMock->method('getStats')->willReturn(['total_clicks' => 10]);
        $this->geoLogMock->method('getHeatmapData')->willReturn([['lat' => 1, 'lng' => 1]]);
        $this->geoLogMock->method('getTotalLogs')->willReturn(1);

        $this->controller->expects($this->once())
            ->method('render')
            ->with(
                'geologger/logs',
                $this->callback(function ($data) {
                    return !empty($data['logs']) &&
                           !empty($data['stats']) &&
                           !empty($data['heatmapData']);
                })
            );

        $this->controller->logs();
    }

    public function testMyLinks()
    {
        $this->controller->method('getGet')->with('page', 1)->willReturn(1);
        $this->geoLinkMock->method('getAllWithStats')->willReturn([['id' => 1, 'original_url' => 'https://example.com']]);
        $this->geoLinkMock->method('getStats')->willReturn(['total_links' => 5]);
        $this->geoLinkMock->method('getTotalLinks')->willReturn(1);

        $this->controller->expects($this->once())
            ->method('render')
            ->with(
                'geologger/my_links',
                $this->callback(function ($data) {
                    return !empty($data['links']) &&
                           !empty($data['stats']);
                })
            );

        $this->controller->myLinks();
    }

    public function testPreciseTrackLinkNotFound()
    {
        $this->controller->method('getGet')->with('code')->willReturn('invalidCode');
        $this->geoLinkMock->method('findByCode')->with('invalidCode')->willReturn(null);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Link not found');

        $this->controller->preciseTrack();
    }

    public function testSavePreciseLocationSuccess()
    {
        $_SERVER['HTTP_USER_AGENT'] = 'Test Agent';
        $_SERVER['HTTP_REFERER'] = 'http://example.com';

        $this->controller->method('isAjax')->willReturn(true);
        $this->controller->method('getPost')->will($this->returnValueMap([
            ['code', null, 'validCode'],
            ['latitude', null, '12.34'],
            ['longitude', null, '56.78'],
            ['accuracy', null, '10'],
            ['location_type', 'GPS', 'GPS'],
        ]));

        $linkData = ['id' => 1, 'original_url' => 'https://example.com'];
        $this->geoLinkMock->method('findByCode')->with('validCode')->willReturn($linkData);
        $this->controller->method('getGeolocationData')->willReturn(['country' => 'Testland']);
        $this->geoLogMock->method('create')->willReturn(123);

        $this->controller->expects($this->once())
            ->method('renderJson')
            ->with($this->callback(function ($data) {
                return $data['success'] === true &&
                       $data['log_id'] === 123;
            }));

        $this->controller->savePreciseLocation();
    }
    
    public function testSavePreciseLocationLinkNotFound()
    {
        $this->controller->method('isAjax')->willReturn(true);
        $this->controller->method('getPost')->with('code')->willReturn('invalidCode');
        $this->geoLinkMock->method('findByCode')->with('invalidCode')->willReturn(null);

        $this->controller->expects($this->once())
            ->method('renderJson')
            ->with($this->callback(function ($data) {
                return $data['success'] === false &&
                       $data['error'] === 'Link not found';
            }));
        
        $this->controller->savePreciseLocation();
    }
}
