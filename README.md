# SyliusNotificationPlugin
Twilio Notification Channel Adapter

### Table of Content
- [Overview](#overview)
- [Installation](#installation)
- [Usage](#usage)

### Overview
This package is an adapter for the [SyliusNotificationPlugin](https://github.com/8lines/SyliusNotificationsPlugin) that allows you to send notifications to [Twilio](https://www.twilio.com).

### Installation
To install the adapter you need to run the following command:
```bash
composer require 8lines/slack-notification-plugin-twilio-adapter
```
Then configure [Twilio Notifier](https://github.com/symfony/twilio-notifier) and add the following variable to your `.env` file:
```dotenv
TWILIO_DSN=twilio://SID:TOKEN@default?from=FROM
```
And finally, add the following configuration to your `config/packages/notifier.yaml` file:
```yaml
framework:
  notifier:
    texter_transports:
      twilio: '%env(TWILIO_DSN)%'
```

### Usage
After the installation, you can use the **Twilio Notification Channel** in your application.
There are one additional option that you can specify during the notification creation:
- `phone number from` - the phone number from which the notification will be sent.
