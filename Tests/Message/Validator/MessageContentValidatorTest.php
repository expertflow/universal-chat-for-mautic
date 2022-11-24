<?php
/*
 * @copyright   2018 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * 
 */

namespace MauticPlugin\MauticActivemqTransportBundle\Tests\Message\Validator;

use MauticPlugin\MauticActivemqTransportBundle\Exception\InvalidMessageArgumentsException;
use MauticPlugin\MauticActivemqTransportBundle\Message\MtMessage;
use MauticPlugin\MauticActivemqTransportBundle\Message\Validator\MessageContentValidator;

class MessageContentValidatorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var MessageContentValidator
     */
    private $validator;

    protected function setUp(): void
    {
        $this->validator = new MessageContentValidator();
        parent::setUp();
    }

    public function testValidate()
    {
        $message = new MtMessage();
        $message->setContent('fjwenifhwewn,khfe,khnwifewe')->setKeyword('aaaa');

        try {
            $this->validator->validate($message);
            $this->assertTrue(true, 'Validation has passed');
        } catch (\Exception $e) {
            $this->fail('Validation of valid message end with no exception, error:  '.$e->getMessage());
        }

        $message->setContent('k,wuerk,eíwšřčěščěš');

        try {
            $message->setContent(str_repeat('.', MessageContentValidator::MAX_CONTENT_LENGTH + 1));
            $this->validator->validate($message);
        } catch (\Exception $e) {
            $this->assertInstanceOf(InvalidMessageArgumentsException::class, $e, get_class($e).' matches InvalidMessageArgumentsException');
        }
    }
}
