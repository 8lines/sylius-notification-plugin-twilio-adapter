<?php

declare(strict_types=1);

namespace EightLines\SyliusNotificationPlugin\NotificationChannel\Symfony;

use EightLines\SyliusNotificationPlugin\NotificationChannel\NotificationBody;
use EightLines\SyliusNotificationPlugin\NotificationChannel\NotificationChannelInterface;
use EightLines\SyliusNotificationPlugin\NotificationChannel\NotificationContext;
use EightLines\SyliusNotificationPlugin\NotificationChannel\NotificationRecipient;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\TexterInterface;

final class TwilioNotificationChannel implements NotificationChannelInterface
{
    private const TWILIO_TRANSPORT = 'twilio';

    public function __construct(
        private TexterInterface $texter,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(
        ?NotificationRecipient $recipient,
        NotificationBody $body,
        NotificationContext $context,
    ): void {
        $message = $body->getMessage();

        if (null === $message) {
            throw new \InvalidArgumentException('Message cannot be empty.');
        }

        $recipientPhoneNumber = $recipient?->getPhoneNumber();

        if (null === $recipientPhoneNumber) {
            throw new \InvalidArgumentException('Recipient phone number cannot be empty.');
        }

        $configuration = $context->getConfiguration();
        $phoneNumberFrom = $configuration->getCustomValue('phone_number_from');

        if (null === $phoneNumberFrom) {
            throw new \InvalidArgumentException('Phone number from cannot be empty.');
        }

        $smsMessage = new SmsMessage(
            phone: $recipientPhoneNumber,
            subject: $message,
            from: $phoneNumberFrom,
        );

        $smsMessage->transport(self::TWILIO_TRANSPORT);

        $this->texter->send($smsMessage);
    }

    public static function getIdentifier(): string
    {
        return 'twilio';
    }

    public static function supportsUnknownRecipient(): bool
    {
        return false;
    }

    public static function getConfigurationFormType(): ?string
    {
        return TwilioNotificationChannelFormType::class;
    }
}
