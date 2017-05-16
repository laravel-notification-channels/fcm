# Laravel FCM (Firebase Cloud Messaging) Notification Channel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/fcm.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/fcm)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/fcm/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/fcm)
[![StyleCI](https://styleci.io/repos/91098630/shield)](https://styleci.io/repos/91098630)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/621d780f-fdb7-479d-8fb2-683cbbc3ee4c.svg?style=flat-square)](https://insight.sensiolabs.com/projects/621d780f-fdb7-479d-8fb2-683cbbc3ee4c)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/fcm.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/fcm)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/fcm/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/fcm/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/fcm.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/fcm)

This package makes it easy to send notifications using [Firebase Cloud Messaging](https://firebase.google.com/docs/cloud-messaging/) (FCM) with Laravel 5.3 and 5.4.

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

    composer require coreproc/laravel-notification-channel-fcm
    
Register the ServiceProvider in your config/app.php:

    NotificationChannels\Fcm\FcmServiceProvider::class,

### Setting up the FCM service

You need to register for a server key from Firebase for your application. Start by creating a project here: 
[https://console.firebase.google.com](https://console.firebase.google.com)

Once you've registered and set up your prroject, add the API key to your configuration in `config/broadcasting.php`

    'connections' => [
        ....
        'fcm' => [
            'key' => env('FCM_KEY'),
        ],
        ...
    ]

## Usage

You can now send notifications via FCM by creating an `FcmNotification` and an `FcmMessages`:

```php
class AccountActivated extends Notification
{
    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toFcm($notifiable)
    {
        // The FcmNotification holds the notification parameters
        $fcmNotification = FcmNotification::create()
            ->setTitle('Your account has been activated')
            ->setBody('Thank you for activating your account.');
            
        // The FcmMessage contains other options for the notification
        return FcmMessage::create()
            ->setPriority(FcmMessage::PRIORITY_HIGH)
            ->setTimeToLive(86400)
            ->setNotification($fcmNotification);
    }
}
```

The above example is a generic example of a notification. However, in real-life applications, we have found that we need to define custom parameters for each
platform (Android, iOS, and Web). Thus, we created `Message` and `Notification` objects for each. Here example usages below:

```php
class AccountActivated extends Notification
{
    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toFcm($notifiable)
    {
        switch ($notifiable->fcmToken->os) { // just a made up variable - you'll want to define this in your application
            case 'android':
                $fcmAndroidNotification = FcmAndroidNotification::create()
                    ->setIcon('myicon')
                    ->setSound('bell')
                    ->setTitle('Your account has been activated')
                    ->setBody('Thank you for activating your account.');
                    
                return FcmAndroidMessage::create()
                    ->setPriority(FcmMessage::PRIORITY_HIGH)
                    ->setTimeToLive(86400)
                    ->setNotification($fcmAndroidNotification);
            case 'ios':
               $fcmIosNotification = FcmIosNotification::create()
                   ->setBadge(1)
                   ->setSound('tinkle')
                   ->setTitle('Your account has been activated')
                   ->setBody('Thank you for activating your account.');
                   
               return FcmIosMessage::create()
                   ->setContentAvailable(true)
                   ->setPriority(FcmMessage::PRIORITY_HIGH)
                   ->setTimeToLive(86400)
                   ->setNotification($fcmIosNotification);
            case 'web':
               $fcmWebNotification = FcmWebNotification::create()
                   ->setIcon('http://test.com/test.jpg')
                   ->setTitle('Your account has been activated')
                   ->setBody('Thank you for activating your account.');
                   
               return FcmWebMessage::create()
                   ->setTimeToLive(86400)
                   ->setNotification($fcmWebNotification);
        }
    }
}
```

### Available Message methods

The `Message` object can differ between different operating systems (Android, iOS, and Chrome). In this perspective, a `Message` object is available for each 
platform which extends the `FcmMessage` object.

All the methods below are explained and defined in the Firebase Cloud Messaging documentation found here: 
[https://firebase.google.com/docs/cloud-messaging/http-server-ref](https://firebase.google.com/docs/cloud-messaging/http-server-ref)

#### FcmMessage

```php
setCondition(string $condition)
```

This parameter specifies a logical expression of conditions that determine the message target.
Supported condition: Topic, formatted as "'yourTopic' in topics". This value is case-insensitive.
Supported operators: &&, ||. Maximum two operators per topic message supported.

```php
setCollapseKey(string $collapseKey)
```

This parameter identifies a group of messages (e.g., with collapse_key: "Updates Available") that can be collapsed, so that only the last message gets sent when
 delivery can be resumed. This is intended to avoid sending too many of the same messages when the device comes back online or becomes active.

Note that there is no guarantee of the order in which messages get sent.

Note: A maximum of 4 different collapse keys is allowed at any given time. This means a FCM connection server can simultaneously store 4 different send-to-sync 
messages per client app. If you exceed this number, there is no guarantee which 4 collapse keys the FCM connection server will keep.

```php
setPriority(string $priority)
```

Sets the priority of the message. Valid values are `FcmMessage::PRIORITY_NORMAL` and `FcmMessage::PRIORITY::HIGH`. On iOS, these correspond to APNs priorities 5
and 10.

By default, notification messages are sent with high priority, and data messages are sent with normal priority. Normal priority optimizes the client app's 
battery consumption and should be used unless immediate delivery is required. For messages with normal priority, the app may receive the message with 
unspecified delay.

When a message is sent with high priority, it is sent immediately, and the app can wake a sleeping device and open a network connection to your server.

```php
setTimeToLive($timeToLive)
```

This parameter specifies how long (in seconds) the message should be kept in FCM storage if the device is offline. The maximum time to live supported is 4 
weeks, and the default value is 4 weeks.

```php
setDryRun(bool $dryRun)
```

This parameter, when set to `true`, allows developers to test a request without actually sending a message. Default value is `false`.

```php
setData(string $data)
```

This parameter specifies the custom key-value pairs of the message's payload.

For example, with data:{"score":"3x1"}:
On iOS, if the message is sent via APNS, it represents the custom data fields. If it is sent via FCM connection server, it would be represented as key value 
dictionary in AppDelegate application:didReceiveRemoteNotification:.

On Android, this would result in an intent extra named score with the string value 3x1.

The key should not be a reserved word ("from" or any word starting with "google" or "gcm"). Do not use any of the words defined in this table (such as 
collapse_key).

Values in string types are recommended. You have to convert values in objects or other non-string data types (e.g., integers or booleans) to string.

```php
setNotification(FcmNotification $notification)
```

This parameter specifies the predefined, user-visible key-value pairs of the notification payload.

#### FcmAndroidMessage

The Android `Message` object does not have any differences from the main `FcmMessage` except that it expects an `FcmAndroidNotification` object in the 
`setNotification` method.

```php
setNotification(FcmAndroidNotification $notification)
```

#### FcmIosMessage

There are two additional `Message` methods specifically defined for iOS.

```php
setContentAvailable(bool $contentAvailable)
```

On iOS, use this field to represent content-available in the APNs payload. When a notification or message is sent and this is set to true, an inactive client 
app is awoken.

```php
setMutableContent(bool $mutableContent)
```

Currently for iOS 10+ devices only. On iOS, use this field to represent mutable-content in the APNS payload. When a notification is sent and this is set to 
true, the content of the notification can be modified before it is displayed, using a Notification Service app extension.

```php
setNotification(FcmIosNotification $notification)
```

This method expects the `FcmIosNotfication` object to be passed.

#### FcmWebMessage

The Web (or Chrome) `Message` object does not have any differences from the main `FcmMessage` except that it expects an `FcmWebNotification` object in the 
`setNotification` method.

```php
setNotification(FcmWebNotification $notification)
```

### Available Notification Methods

Each `FcmMessage` object expects an optional `notification` object which holds the content of the notification. A notification object for each platform is
available which extends a main `FcmNotification` object.

#### FcmNotification

```php
setTitle(string $title)
```

The notification's title. This field is not visible on iOS phones and tablets.

```php
setBody(string $body)
```

The notification's body text.

```php
setClickAction(string $clickAction)
```

iOS:
The action associated with a user click on the notification.
Corresponds to category in the APNs payload.

Android:
The action associated with a user click on the notification.
If specified, an activity with a matching intent filter is launched when a user clicks on the notification.

Web:
The action associated with a user click on the notification.
For all URL values, secure HTTPS is required.

#### FcmAndroidNotification

```php
setAndroidChannelId(string $androidChannelId)
```

The notification's channel id (new in Android O).

The app must create a channel with this ID before any notification with this key is received.

If you don't send this key in the request, or if the channel id provided has not yet been created by your app, FCM uses the channel id specified in your app
manifest.

```php
setIcon(string $icon)
```

The notification's icon.

Sets the notification icon to myicon for drawable resource myicon. If you don't send this key in the request, FCM displays the launcher icon specified in
your app manifest.

```php
setSound(string $sound)
```

The sound to play when the device receives the notification.

Supports "default" or the filename of a sound resource bundled in the app. Sound files must reside in `/res/raw/`.

```php
setTag(string $tag)
```

dentifier used to replace existing notifications in the notification drawer.

If not specified, each request creates a new notification.

If specified and a notification with the same tag is already being shown, the new notification replaces the existing one in the notification drawer.

```php
setColor(string $color)
```

The notification's icon color, expressed in `#rrggbb` format.

```php
setBodyLocKey(string $bodyLocKey)
```

The key to the body string in the app's string resources to use to localize the body text to the user's current localization.

```php
setBodyLocArgs(array $bodyLocArgs)
```

The key to the title string in the app's string resources to use to localize the title text to the user's current localization.

```php
setTitleLocKey(string $titleLocKey)
```

Variable string values to be used in place of the format specifiers in body_loc_key to use to localize the body text to the user's current
localization.

```php
setTitleLocArgs(array $titleLocArgs)
```

Variable string values to be used in place of the format specifiers in title_loc_key to use to localize the title text to the user's current
localization.

#### FcmIosNotification

```php
setBadge(string $badge)
```
The value of the badge on the home screen app icon.

If not specified, the badge is not changed.

If set to 0, the badge is removed.

```php
setSound(string $sound)
```

The sound to play when the device receives the notification.

Sound files can be in the main bundle of the client app or in the `Library/Sounds` folder of the app's data container.

```php
setBodyLocKey(string $bodyLocKey)
```

The key to the body string in the app's string resources to use to localize the body text to the user's current localization.
Corresponds to loc-key in the APNs payload.

```php
setBodyLocArgs(array $bodyLocArgs)
```

Variable string values to be used in place of the format specifiers in body_loc_key to use to localize the body text to the user's current localization.
Corresponds to loc-args in the APNs payload.

```php
setTitleLocKey(string $titleLocKey)
```

The key to the title string in the app's string resources to use to localize the title text to the user's current localization.
Corresponds to title-loc-key in the APNs payload.

```php
setTitleLocArgs(array $titleLocArgs)
```

Variable string values to be used in place of the format specifiers in title_loc_key to use to localize the title text to the user's current localization.
Corresponds to title-loc-args in the APNs payload.

#### FcmWebNotification

```php
setIcon(string $icon)
```

The URL to use for the notification's icon.

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
