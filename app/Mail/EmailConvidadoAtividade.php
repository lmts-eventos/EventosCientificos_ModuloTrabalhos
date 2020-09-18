<?php

namespace App\Mail;

use App\Convidado;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailConvidadoAtividade extends Mailable
{
    use Queueable, SerializesModels;

    public $convidado;
    public $subject;
    public $informacoes;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Convidado $convidado, $subject, $informacoes = "")
    {
        $this->convidado    = $convidado;
        $this->subject      = $subject;
        $this->informacoes  = $informacoes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return  $this->from('lmtsteste@gmail.com', 'Eventos - LMTS')
                    ->subject($this->subject)
                    ->view('emails.convidadoAtividade')
                    ->with([
                        'convidado' => $this->convidado,
                        'info' => $this->informacoes,
                    ]);
    }
}