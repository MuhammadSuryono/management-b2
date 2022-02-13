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
        $this->data=$data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('budiono@mri.com')
                   ->view('email_01')
                   ->with(
                    [
                        'nama' => 'MRI B2',
                        'website' => 'www.mri-research-ind.com',
                    ]);

                    return $this->from('john@webslesson.info')
                    ->subject('New Customer Equiry')
                    ->view('dynamic_email_template')
                    ->with('data', $this->data);

                }
}
