# Laravel FCM (Firebase Cloud Messaging) Notification Channel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/fcm.svg?style=flat-square)](https://packagist.org/packages/coreproc/laravel-notification-channel-fcm)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![StyleCI](https://styleci.io/repos/209406724/shield)](https://styleci.io/repos/209406724)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/fcm.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/fcm)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/fcm.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/fcm)

This package makes it easy to send notifications using [Firebase Cloud Messaging](https://firebase.google.com/docs/cloud-messaging/) (FCM) with Laravel 5.5+, 6.x, 7.x and 8.x.

## Version 2 Released (March 4, 2020)

V2.0.0 has been released and FCM API calls has been migrated from legacy HTTP to HTTP v1 (docs from Firebase 
[here](https://firebase.google.com/docs/cloud-messaging/migrate-v1)). This is a breaking change so notifications using
v1.x should not upgrade to v2.x of this package unless you plan on migrating your notification classes.

## Contents

- [Installation](#installation)
	- [Setting up the Fcm service](#setting-up-the-Fcm-service)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

Install this package with Composer:

```bash
composer require laravel-notification-channels/fcm:~2.0
```

### Setting up the FCM service

This package now uses the [laravel-firebase](https://github.com/kreait/laravel-firebase) library to authenticate and 
make the API calls to Firebase. Follow the [configuration](https://github.com/kreait/laravel-firebase#configuration)
steps specified in their readme before using this.

After following their configuration steps, make sure that you've specified your `FIREBASE_CREDENTIALS` in your .env 
file. 

## Usage

After setting up your Firebase credentials, you can now send notifications via FCM by a Notification class and sending
it via the `FcmChannel::class`. Here is an example:

```php
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;

class AccountActivated extends Notification
{
    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setData(['data1' => 'value', 'data2' => 'value2'])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle('Account Activated')
                ->setBody('Your account has been activated.')
                ->setImage('http://example.com/url-to-image-here.png'))
            ->setAndroid(
                AndroidConfig::create()
                    ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
                    ->setNotification(AndroidNotification::create()->setColor('#0A0A0A'))
            )->setApns(
                ApnsConfig::create()
                    ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios')));
    }

    // optional method when using kreait/laravel-firebase:^3.0, this method can be omitted, defaults to the default project
    public function fcmProject($notifiable, $message)
    {
        // $message is what is returned by `toFcm`
        return 'app'; // name of the firebase project to use
    }
}
```

You will have to set a `routeNotificationForFcm()` method in your notifiable model. For example:

```php
class User extends Authenticatable
{
    use Notifiable;

    ....

    /**
     * Specifies the user's FCM token
     *
     * @return string|array
     */
    public function routeNotificationForFcm()
    {
        return $this->fcm_token;
    }
}
```

You can also return an array of tokens to send notifications via multicast to different user devices.

```php
class User extends Authenticatable
{
    use Notifiable;

    ....

    /**
     * Specifies the user's FCM tokens
     *
     * @return string|array
     */
    public function routeNotificationForFcm()
    {
        return $this->getDeviceTokens();
    }
}
```

Once you have that in place, you can simply send a notification to the user by doing the following:

```php
$user->notify(new AccountActivated);
```

### Available Message methods

The `FcmMessage` class contains the following methods for defining the payload. All these methods correspond to the 
available payload defined in the 
[FCM API documentation](https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages). Refer to this link to
find all the available data you can set in your FCM notification.

```php
setName(string $name)
```

```php
setData(array $data)
```

```php
setNotification(\NotificationChannels\Fcm\Resources\Notification $notification)
```

```php
setAndroid(NotificationChannels\Fcm\Resources\AndroidConfig $androidConfig)
```

```php
setApns(NotificationChannels\Fcm\Resources\ApnsConfig $apnsConfig)
```

```php
setWebpush(NotificationChannels\Fcm\Resources\WebpushConfig $webpushConfig)
```

```php
setFcmOptions(NotificationChannels\Fcm\Resources\FcmOptions $fcmOptions)
```

```php
setTopic(string $topic)
```

```php
setCondition(string $condition)
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email chrisbjr@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Chris Bautista](https://github.com/chrisbjr)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
