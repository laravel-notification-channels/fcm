# Changelog

All notable changes will be documented in this file

## 4.0.0 - 2023-10-28

This version is a pretty substantial rewrite that removes a lot of complexity from the library, makes some features more consistent and increases test coverage.

* Requires PHP 8.2+, and Laravel 10.x,
* The constructor for `FcmMessage` and `FcmNotification` have changed to use named arguments,
* The custom resource objects have been removed,
* The ability to use a custom client has been standardised.

### Re-write your message

Many of the `set*` methods have been removed and replaced with public properties. The basics you can still use with ease - setting the properties of an `FcmNotification` and setting additional data. If you want to set more explicit options (iOS or Android configuration for example) you will use the `custom` method.

```php
return new FcmMessage(notification: new FcmNotification(
        title: 'Account Activated',
        body: 'Your account has been activated.',
        image: 'http://example.com/url-to-image-here.png'
    ))
    ->data(['data1' => 'value', 'data2' => 'value2'])
    ->custom([
        'android' => [
            'notification' => [
                'color' => '#0A0A0A',
            ],
            'fcm_options' => [
                'analytics_label' => 'analytics',
            ],
        ],
        'apns' => [
            'fcm_options' => [
                'analytics_label' => 'analytics',
            ],
        ],
    ]);
```

### Use a custom client

The way to change the FCM configuration on the fly now requires passing in an instance of `Kreait\Firebase\Contract\Messaging`. Set it up with your credentials and pass it into a message with `usingClient`.

```php
public function toFcm(mixed $notifiable)
{
    $client = app(\Kreait\Firebase\Contract\Messaging::class);

    return FcmMessage::create()->usingClient($client);
}
```

### Handling failures

Listen to the `Illuminate\Notifications\Events\NotificationFailed` event which will include each individual failure for report you to handle as you need.

Please re-review the documentation when upgrading to the latest version and make the changes necessary for your app.