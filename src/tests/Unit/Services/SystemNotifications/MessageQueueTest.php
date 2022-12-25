<?php

namespace Tests\Unit;

use App\Services\Mvsc\SystemNotifications\MessageQueue;
use PHPUnit\Framework\TestCase;

class MessageQueueTest extends TestCase
{
    /**
     * @covers \App\Services\Mvsc\SystemNotifications\MessageQueue::addMessage
     */
    public function testAddMessage()
    {
        $msgQue = new MessageQueue();
        $msg = 'This is a test of my message system';

        $msgQue->addMessage($msg)
            ->addMessage($msg, 'errors');

        self::assertEquals(true, $msgQue->has('messages'));
        self::assertEquals(true, $msgQue->has('errors'));
    }

    /**
     * @covers \App\Services\Mvsc\SystemNotifications\MessageQueue::clearMessages
     */
    public function testClearAllMessages()
    {
        $msgQue = new MessageQueue();
        $msg = 'This is a test of my message system';
        $msgQue->addMessage($msg)
            ->addMessage($msg, 'errors')
            ->clearMessages();

        self::assertEquals(false, $msgQue->has('messages'));
        self::assertEquals(false, $msgQue->has('errors'));
    }

    /**
     * @covers \App\Services\Mvsc\SystemNotifications\MessageQueue::clearMessages
     */
    public function testClearOneMessageType()
    {
        $msgQue = new MessageQueue();
        $msg = 'This is a test of my message system';
        $msgQue->addMessage($msg)
            ->addMessage($msg, 'errors')
            ->clearMessages('messages');

        self::assertEquals(false, $msgQue->has('messages'));
        self::assertEquals(true, $msgQue->has('errors'));
    }

    /**
     * @covers \App\Services\Mvsc\SystemNotifications\MessageQueue::getMessages
     */
    public function testGetAllMessages()
    {
        $msgQue = new MessageQueue();
        $msg = 'This is a test of my message system';
        $msgQue->addMessage($msg)
            ->addMessage($msg, 'errors');

        $expected = ['messages' => [$msg], 'errors' => [$msg]];
        $actual = $msgQue->getMessages();

        self::assertEquals($expected, $actual);
    }

    /**
     * @covers \App\Services\Mvsc\SystemNotifications\MessageQueue::getMessages
     */
    public function testGetOneMessageType()
    {
        $msgQue = new MessageQueue();
        $msg = 'This is a test of my message system';
        $msgQue->addMessage($msg)
            ->addMessage($msg, 'errors');

        $expected = [$msg];
        $actual = $msgQue->getMessages('messages');

        self::assertEquals($expected, $actual);
    }
}
