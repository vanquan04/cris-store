<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $code = $this->data['code_bill'] ?? 'Khách hàng';
        return $this->view('client.mails.OrderStatusUpdated')
            ->subject("[CRIS STORE] Cập nhật trạng thái đơn hàng: {$code}")
            ->with($this->data);
    }
}
