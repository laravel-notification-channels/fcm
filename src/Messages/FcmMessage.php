<?php

namespace NotificationChannels\Fcm\Messages;

use NotificationChannels\Fcm\Notifications\FcmNotification;

class FcmMessage
{
    /**
     * @var string
     */
    protected $to;

    /**
     * @var array
     */
    protected $registrationIds;

    /**
     * @var string
     */
    protected $condition;

    /**
     * @var string
     */
    protected $collapseKey;

    /**
     * @var string
     */
    protected $priority;

    /**
     * @var integer
     */
    protected $timeToLive = 2419200;

    /**
     * @var bool
     */
    protected $dryRun = false;

    /**
     * @var object
     */
    protected $data;

    /**
     * @var FcmNotification
     */
    protected $notification;

    /**
     * This parameter specifies the recipient of a message.
     * The value can be a device's registration token, a device group's notification key, or a single topic (prefixed with /topics/). To send to multiple
     * topics, use the condition parameter.
     *
     * @param string $to
     * @return $this
     */
    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * This parameter specifies the recipient of a multicast message, a message sent to more than one registration token.
     * The value should be an array of registration tokens to which to send the multicast message. The array must contain at least 1 and at most 1000
     * registration tokens. To send a message to a single device, use the to parameter.
     * Multicast messages are only allowed using the HTTP JSON format.
     *
     * @param array $registrationIds
     * @return $this
     */
    public function setRegistrationIds($registrationIds)
    {
        $this->registrationIds = $registrationIds;

        return $this;
    }

    /**
     * [Optional] This parameter specifies a logical expression of conditions that determine the message target.
     * Supported condition: Topic, formatted as "'yourTopic' in topics". This value is case-insensitive.
     * Supported operators: &&, ||. Maximum two operators per topic message supported.
     *
     * @param string $condition
     * @return $this
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;

        return $this;
    }

    /**
     * [Optional] This parameter identifies a group of messages (e.g., with collapse_key: "Updates Available") that can be collapsed, so that only the last
     * message gets sent when delivery can be resumed. This is intended to avoid sending too many of the same messages when the device comes back online or
     * becomes active.
     * Note that there is no guarantee of the order in which messages get sent.
     * Note: A maximum of 4 different collapse keys is allowed at any given time. This means a FCM connection server can simultaneously store 4 different
     * send-to-sync messages per client app. If you exceed this number, there is no guarantee which 4 collapse keys the FCM connection server will keep.
     *
     * @param string $collapseKey
     * @return $this
     */
    public function setCollapseKey($collapseKey)
    {
        $this->collapseKey = $collapseKey;

        return $this;
    }

    /**
     * [Optional] Sets the priority of the message. Valid values are "normal" and "high." On iOS, these correspond to APNs priorities 5 and 10.
     * By default, notification messages are sent with high priority, and data messages are sent with normal priority. Normal priority optimizes the client
     * app's battery consumption and should be used unless immediate delivery is required. For messages with normal priority, the app may receive the message
     * with unspecified delay.
     * When a message is sent with high priority, it is sent immediately, and the app can wake a sleeping device and open a network connection to your server.
     *
     * @param string $priority
     * @return $this
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * This parameter specifies how long (in seconds) the message should be kept in FCM storage if the device is offline. The maximum time to live
     * supported is 4 weeks, and the default value is 4 weeks.
     *
     * @param int $timeToLive
     * @return $this
     */
    public function setTimeToLive($timeToLive)
    {
        $this->timeToLive = $timeToLive;

        return $this;
    }

    /**
     * This parameter, when set to true, allows developers to test a request without actually sending a message.
     *
     * @param bool $dryRun
     * @return $this
     */
    public function setDryRun($dryRun)
    {
        $this->dryRun = $dryRun;

        return $this;
    }

    /**
     * [Optional] This parameter specifies the custom key-value pairs of the message's payload.
     * For example, with data:{"score":"3x1"}:
     * On iOS, if the message is sent via APNS, it represents the custom data fields. If it is sent via FCM connection server, it would be represented as key
     * value dictionary in AppDelegate application:didReceiveRemoteNotification:.
     * On Android, this would result in an intent extra named score with the string value 3x1.
     * The key should not be a reserved word ("from" or any word starting with "google" or "gcm"). Do not use any of the words defined in this table (such as
     * collapse_key).
     * Values in string types are recommended. You have to convert values in objects or other non-string data types (e.g., integers or booleans) to string.
     *
     * @param object $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * [Optional] This parameter specifies the predefined, user-visible key-value pairs of the notification payload.
     *
     * @param FcmNotification $notification
     * @return $this
     */
    public function setNotification($notification)
    {
        $this->notification = $notification;

        return $this;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @return array
     */
    public function getRegistrationIds()
    {
        return $this->registrationIds;
    }

    /**
     * @return string
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @return string
     */
    public function getCollapseKey()
    {
        return $this->collapseKey;
    }

    /**
     * @return string
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @return int
     */
    public function getTimeToLive()
    {
        return $this->timeToLive;
    }

    /**
     * @return bool
     */
    public function isDryRun()
    {
        return $this->dryRun;
    }

    /**
     * @return object
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return FcmNotification
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'to'               => $this->to,
            'registration_ids' => $this->registrationIds,
            'condition'        => $this->condition,
            'collapse_key'     => $this->collapseKey,
            'priority'         => $this->priority,
            'time_to_live'     => $this->timeToLive,
            'dry_run'          => $this->dryRun,
            'data'             => $this->data,
            'notification'     => $this->notification->toArray(),
        ];
    }
}
