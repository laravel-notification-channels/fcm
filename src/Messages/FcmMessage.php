<?php

namespace NotificationChannels\Fcm\Messages;

class FcmMessage
{
    /**
     * @var string Optional
     *
     * This parameter specifies a logical expression of conditions that determine the message target.
     * Supported condition: Topic, formatted as "'yourTopic' in topics". This value is case-insensitive.
     * Supported operators: &&, ||. Maximum two operators per topic message supported.
     */
    protected $condition;

    /**
     * @var string Optional
     *
     * This parameter identifies a group of messages (e.g., with collapse_key: "Updates Available") that can be collapsed, so that only the last message gets
     * sent when delivery can be resumed. This is intended to avoid sending too many of the same messages when the device comes back online or becomes active.
     * Note that there is no guarantee of the order in which messages get sent.
     * Note: A maximum of 4 different collapse keys is allowed at any given time. This means a FCM connection server can simultaneously store 4 different
     * send-to-sync messages per client app. If you exceed this number, there is no guarantee which 4 collapse keys the FCM connection server will keep.
     */
    protected $collapseKey;

    /**
     * @var string Optional
     *
     * Sets the priority of the message. Valid values are "normal" and "high." On iOS, these correspond to APNs priorities 5 and 10.
     * By default, notification messages are sent with high priority, and data messages are sent with normal priority. Normal priority optimizes the client
     * app's battery consumption and should be used unless immediate delivery is required. For messages with normal priority, the app may receive the message
     * with unspecified delay.
     * When a message is sent with high priority, it is sent immediately, and the app can wake a sleeping device and open a network connection to your server.
     */
    protected $priority;

    /**
     * @var integer
     *
     * This parameter specifies how long (in seconds) the message should be kept in FCM storage if the device is offline. The maximum time to live supported is
     * 4 weeks, and the default value is 4 weeks.
     */
    protected $timeToLive;

    /**
     * @var bool
     *
     * This parameter, when set to true, allows developers to test a request without actually sending a message.
     */
    protected $dryRun = false;

    /**
     * @var object
     *
     * This parameter specifies the custom key-value pairs of the message's payload.
     * For example, with data:{"score":"3x1"}:
     * On iOS, if the message is sent via APNS, it represents the custom data fields. If it is sent via FCM connection server, it would be represented as key
     * value dictionary in AppDelegate application:didReceiveRemoteNotification:.
     * On Android, this would result in an intent extra named score with the string value 3x1.
     * The key should not be a reserved word ("from" or any word starting with "google" or "gcm"). Do not use any of the words defined in this table (such as
     * collapse_key).
     * Values in string types are recommended. You have to convert values in objects or other non-string data types (e.g., integers or booleans) to string.
     */
    protected $data;
}
