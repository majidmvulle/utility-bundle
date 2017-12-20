<?php

namespace MajidMvulle\Bundle\UtilityBundle;

use JMS\DiExtraBundle\Annotation as DI;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use Symfony\Component\HttpKernel\KernelInterface;
use Twilio\Rest\Client;

/**
 * Class TwilioManager.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
 *
 * @DI\Service("majidmvulle.utility.twilio_manager")
 */
class TwilioManager
{
    /**
     * @var string
     */
    private $fromNumber;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var PhoneNumberUtil
     */
    private $phoneUtil;

    /**
     * @var string
     */
    private $env;

    /**
     * TwilioManager Constructor.
     *
     * @DI\InjectParams({
     * "sid" = @DI\Inject("%majidmvulle.utility.twilio.sid%"),
     * "token" = @DI\Inject("%majidmvulle.utility.twilio.token%"),
     * "fromNumber" = @DI\Inject("%majidmvulle.utility.twilio.from_number%"),
     * "kernel" = @DI\Inject("kernel")
     * })
     *
     * @param $sid
     * @param $token
     * @param $fromNumber
     * @param KernelInterface $kernel
     */
    public function __construct($sid, $token, $fromNumber, KernelInterface $kernel)
    {
        $this->fromNumber = $fromNumber;
        $this->client = new Client($sid, $token);
        $this->phoneUtil = PhoneNumberUtil::getInstance();
        $this->env = $kernel->getEnvironment();
    }

    /**
     * Sends an SMS message.
     *
     * @param $toPhoneNumber
     * @param $message
     *
     * @return \Twilio\Rest\Api\V2010\Account\MessageInstance
     */
    public function sendSms($toPhoneNumber, $message)
    {
        $response = null;

        if ($this->env !== 'prod') {
            return $response;
        }

        try {
            $phoneNumberProto = $this->phoneUtil->parse($toPhoneNumber, 'AE');

            if (!$this->phoneUtil->isValidNumberForRegion($phoneNumberProto, 'AE')) { //only send sms to UAE numbers
                return;
            }

            $phoneNumber = $this->phoneUtil->format($phoneNumberProto, PhoneNumberFormat::INTERNATIONAL);

            $response = $this->client->messages->create($phoneNumber, ['from' => $this->fromNumber, 'body' => $message]);
        } catch (NumberParseException $e) {
            //ignore
        }

        return $response;
    }
}
