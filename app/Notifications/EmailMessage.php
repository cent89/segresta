<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmailMessage extends Notification implements ShouldQueue
{
  use Queueable, InteractsWithQueue;
  private $oggetto = "";
  private $messaggio = "";
  private $allegato = null;
  private $user = null;

  /**
  * Create a new notification instance.
  *
  * @return void
  */
  public function __construct($oggetto, $messaggio, $allegato = null, $user = null){
    $this->oggetto = $oggetto;
    $this->messaggio = $messaggio;
    $this->allegato = $allegato;
    $this->user = $user;
  }

  /**
  * Get the notification's delivery channels.
  *
  * @param  mixed  $notifiable
  * @return array
  */
  public function via($notifiable)
  {
    return ['mail'];
  }

  /**
  * Get the mail representation of the notification.
  *
  * @param  mixed  $notifiable
  * @return \Illuminate\Notifications\Messages\MailMessage
  */
  public function toMail($notifiable)
  {
    if($this->user != null){
      $this->messaggio = "Messaggio inviato da ".$this->user->full_name."<br>Email: ".$this->user->email." - Tel: ".$this->user->telefono."<br>--------------------<br><br>".$this->messaggio;
    }

    $message = new MailMessage;
    $message->greeting($this->oggetto);
    $message->subject($this->oggetto);
    $message->line($this->messaggio);
    if($this->allegato != null){
      if(is_array($this->allegato)){
        foreach ($this->allegato as $key => $value) {
          $message->attach($value);
        }
      }else{
        $message->attach($this->allegato);
      }
    }

    if($this->user != null){
      $message->replyTo($this->user->email, $this->user->full_name);
    }



    return $message;
  }

  /**
  * Get the array representation of the notification.
  *
  * @param  mixed  $notifiable
  * @return array
  */
  public function toArray($notifiable)
  {
    return [
      //
    ];
  }

  // public function handle()
  // {
  //   Redis::throttle('*')->allow(1)->every(1000)->then(function () {
  //     // send email to subscriber
  //     logger($this->email);
  //   }, function () {
  //     // could not obtain lock, retry this job in 5 seconds.
  //     return $this->release(60);
  //   });
  // }
}
