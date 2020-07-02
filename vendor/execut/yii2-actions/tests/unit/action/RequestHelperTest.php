<?php
/**
 */

namespace execut\actions\action;


use execut\actions\TestCase;

class RequestHelperTest extends TestCase
{
    public function setUp(): void
    {
        $this->markTestSkipped('Need repair');
        parent::setUp();
    }

    public function testGetPost() {
        $request = $this->getMock('\yii\web\Request', ['post']);

        $request->expects($this->any())
            ->method('post')
            ->will($this->returnValue([
                'postKey' => 'postValue',
            ]));
        \Yii::$app->set('request', $request);

        $helper = new RequestHelper();
        $this->assertEquals([
            'postKey' => 'postValue',
        ], $helper->getPost());
    }

    public function testGetGet() {
        $helper = new RequestHelper();
        $get = [
            'getKey' => 'getValue',
        ];
        $_GET = $get;

        $this->assertEquals($get, $helper->getGet());
    }

    public function testGetFiles() {
        $helper = new RequestHelper();
        $files = [
            'fileKey' => 'fileValue',
        ];
        $_FILES = $files;

        $this->assertEquals($files, $helper->getFiles());
    }

    public function testGetIsAjax() {
        $helper = new RequestHelper();
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';

        $this->assertTrue($helper->isAjax());
    }

    public function testGetIsPjax() {
        $helper = new RequestHelper();

        $request = $this->getMock('\yii\web\Request', ['getIsPjax']);
        $request->expects($this->any())
            ->method('getIsPjax')
            ->will($this->returnValue(true));
        \Yii::$app->set('request', $request);

        $this->assertTrue($helper->isPjax());
    }
}