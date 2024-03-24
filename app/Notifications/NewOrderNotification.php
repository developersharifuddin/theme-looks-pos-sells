<?php

namespace App\Notifications;

use App\Models\OrderMaster;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    public function __construct(OrderMaster $order)
    {
        $this->order = $order;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        Log::info('Preparing to send the email notification for a new order');
        // Your existing email content setup
        return (new MailMessage)
            ->line('A new order has been placed.')
            ->line('Order ID: ' . $this->order->id)
            ->line('Total Amount: $' . $this->order->payable);
        // Additional information about the order can be added here
        // ->action('View Order', route('orders.show', $this->order));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    // public function toArray(object $notifiable): array
    // {
    //     return [
    //         //
    //     ];
    // }
}
