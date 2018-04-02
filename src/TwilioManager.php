<?php

declare(strict_types=1);

namespace MajidMvulle\Bundle\UtilityBundle;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;
use Symfony\Component\HttpKernel\KernelInterface;
use Twilio\Rest\Api\V2010\Account\MessageInstance;
use Twilio\Rest\Client;

/**
 * Class TwilioManager.
 *
 * @author Majid Mvulle <majid@majidmvulle.com>
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

    public function __construct(KernelInterface $kernel, $sid, $token, $fromNumber)
    {
        $this->fromNumber = $fromNumber;
        $this->client = new Client($sid, $token);
        $this->phoneUtil = PhoneNumberUtil::getInstance();
        $this->env = $kernel->getEnvironment();
    }

    public function sendSms($toPhoneNumber, $message): ?MessageInstance
    {
        $response = null;

        if ('prod' !== $this->env) {
            return $response;
        }

        try {
            $phoneNumberProto = $this->phoneUtil->parse($toPhoneNumber, 'AE');

            if (!$this->phoneUtil->isValidNumberForRegion($phoneNumberProto, 'AE')) { //only send sms to UAE numbers
                return;
            }

            if (PhoneNumberType::MOBILE !== $this->phoneUtil->getNumberType($phoneNumberProto)) { //only send sms to mobile numbers
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
