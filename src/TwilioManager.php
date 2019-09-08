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

    /**
     * @var string
     */
    private $verificationSid;

    public function __construct(KernelInterface $kernel, string $sid, string $token, string $fromNumber, string $verificationSid)
    {
        $this->fromNumber = $fromNumber;
        $this->client = new Client($sid, $token);
        $this->phoneUtil = PhoneNumberUtil::getInstance();
        $this->env = $kernel->getEnvironment();
        $this->verificationSid = $verificationSid;
    }

    /**
     * @param string $toPhoneNumber
     * @param string $message
     *
     * @throws \Twilio\Exceptions\TwilioException
     *
     * @return MessageInstance|null
     */
    public function sendSms(string $toPhoneNumber, string $message): ?MessageInstance
    {
        $response = null;

        if ('prod' !== $this->env) {
            return $response;
        }

        try {
            $mobileNumber = $this->getFormattedMobileNumber($toPhoneNumber);

            if (!$mobileNumber) {
                return null;
            }

            $response = $this->client->messages->create($mobileNumber, ['from' => $this->fromNumber, 'body' => $message]);
        } catch (NumberParseException $e) {
            //ignore
        }

        return $response;
    }

    public function sendVerificationCode(string $toPhoneNumber): void
    {
        try {
            $mobileNumber = $this->getFormattedMobileNumber($toPhoneNumber);

            if (!$mobileNumber) {
                return;
            }

            $this->client->verify->v2->services($this->verificationSid)->verifications
                ->create($mobileNumber, 'sms');
        } catch (NumberParseException $e) {
            //ignore
        }
    }

    public function checkVerificationCode(string $toPhoneNumber, string $code): bool
    {
        try {
            $mobileNumber = $this->getFormattedMobileNumber($toPhoneNumber);

            if (!$mobileNumber) {
                return false;
            }

            $verificationCheck = $this->client->verify->v2->services($this->verificationSid)->verificationChecks
                ->create($code, ['to' => $mobileNumber]);

            return 'approved' === $verificationCheck->status;
        } catch (NumberParseException $e) {
            //ignore
        }

        return false;
    }

    /**
     * @param string $phoneNumber
     *
     * @throws NumberParseException
     *
     * @return string|null
     */
    private function getFormattedMobileNumber(string $phoneNumber): ?string
    {
        $phoneNumberProto = $this->phoneUtil->parse($phoneNumber, 'AE');

        if (!$this->phoneUtil->isValidNumberForRegion($phoneNumberProto, 'AE')) { //only send sms to UAE numbers
            return null;
        }

        if (PhoneNumberType::MOBILE !== $this->phoneUtil->getNumberType($phoneNumberProto)) { //only send sms to mobile numbers
            return null;
        }

        return $this->phoneUtil->format($phoneNumberProto, PhoneNumberFormat::INTERNATIONAL);
    }
}
