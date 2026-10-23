<?php

namespace App\Notifications;

use App\Models\BuyerInquiry;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BuyerInquiryReceived extends Notification
{
    public function __construct(public BuyerInquiry $inquiry)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New buyer inquiry for '.$this->inquiry->artwork->title)
            ->greeting('You have a new buyer inquiry')
            ->line($this->inquiry->buyer_name.' is interested in “'.$this->inquiry->artwork->title.'”.')
            ->line('Message: '.$this->inquiry->message)
            ->line('Buyer email: '.$this->inquiry->buyer_email)
            ->action('View your artwork listings', route('seller.artworks.index'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'inquiry_id' => $this->inquiry->id,
            'artwork_id' => $this->inquiry->artwork_id,
            'artwork_title' => $this->inquiry->artwork->title,
            'buyer_name' => $this->inquiry->buyer_name,
            'buyer_email' => $this->inquiry->buyer_email,
            'message' => $this->inquiry->message,
        ];
    }
}
