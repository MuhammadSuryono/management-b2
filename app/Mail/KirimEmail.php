<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KirimEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('admin.web@mri-research-ind.com')
            ->view('email')
            ->with(
                [
                    'status' => $this->data['status'],
                    'task' => $this->data['task'],
                    'date_start' => $this->data['date_start'],
                    'hour_start' =>  $this->data['hour_start'],
                    'date_finish' => $this->data['date_finish'],
                    'hour_finish' => $this->data['hour_finish'],
                    'ket' => $this->data['ket'],
                ]
            );
        // return $this->from('john@webslesson.info')
        //     ->subject('New Customer Equiry')
        //     ->view('dynamic_email_template')
        //     ->with('data', $this->data);
    }
}
