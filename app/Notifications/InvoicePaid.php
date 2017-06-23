<?php

namespace App\Notifications;

use App\Blog;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class InvoicePaid extends Notification
{
    use Queueable;

    private $blog;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        //$this->blog = $blog;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
    * 通知のSlackプレゼンテーションを取得
    *
    * @param  mixed  $notifiable
    * @return SlackMessage
    */
    public function toSlack($notifiable)
    {
        return (new SlackMessage)
                ->content('One of your invoices has been paid!');
    }
        /**
    * 通知のメールプレゼンテーションを取得
    *
    * @param  mixed  $notifiable
    * @return \Illuminate\Notifications\Messages\MailMessage
    */
    public function toMail($notifiable)
    {
        //$url = url('/invoice/'.$this->invoice->id);

        return (new MailMessage)
                ->greeting('Hello!')
                ->line('One of your invoices has been paid!')
                //->action('View Invoice', $url)
                ->line('Thank you for using our application!');
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    // public function toArray($notifiable)
    // {
    //     return [
    //         //
    //     ];
    // }
}
