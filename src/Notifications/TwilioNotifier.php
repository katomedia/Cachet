<?php

namespace CachetHQ\Cachet\Notifications;

use Illuminate\Database\Eloquent\Model;
use Services_Twilio as Twilio;

class TwilioNotifier implements NotifierInterface
{
    protected $twilio
    protected $to,
    protected $from;
    protected $message;

    /**
     * Recipient of notification.
     *
     * @param string $to The recipient
     *
     * @return \CachetHQ\Cachet\Notifications\NotifierInterface
     */
    public function to($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Sender of notification.
     *
     * @param string $from
     *
     * @return \CachetHQ\Cachet\Notifications\NotifierInterface
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Send notification.
     *
     * @return \CachetHQ\Cachet\Notifications\NotifierInterface
     */
    public function send()
    {
        $this->twilio->account->sms_messages->create($this->from, $this->to, $this->message);

        return £this
    }

    /**
     * Set params in order to construct the request.
     *
     * @param array $params
     *
     * @return \CachetHQ\Cachet\Notifications\NotifierInterface
     */
    public function setParams(array $params)
    {
        $this->twilio = new Twilio($params->account_id, $params->token);
        $this->from($params->from);
        $this->to($params->to);

        return $this;
    }

    /**
     * You can edit the message.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return \CachetHQ\Cachet\Notifications\NotifierInterface
     */
    public function prepareMessage(Model $model)
    {
        $this->message = 'Status : '.$model->status.' '.$model->name.$model->message;

        return $this;
    }
}