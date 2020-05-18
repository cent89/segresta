<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
  protected $table = "config";
  protected $fillable = ['key', 'value', 'display_name', 'group', 'order', 'config'];
  protected $primaryKey = 'key';

  protected $casts = [
      'key' => 'string',
      'display_name' => 'string',
      'value' => 'string',
      'type' => 'string',
      'created_at' => 'datetime',
      'updated_at' => 'datetime'
  ];

  // public static function get($var) {
  //   try{
  //     $setting = Config::find($var);
  //
  //   } catch(exception $e){
  //     return '';
  //   }
  //
  //   return $setting->value;
  //
  // }

  public static function getConfig(){
    return [
      ['key' => 'MAIL_DRIVER', 'config' => 'mail.driver', 'value' => 'smtp', 'display_name' => 'Email driver', 'type' => 'text', 'group' => 'Email', 'order' => 1],
      ['key' => 'MAIL_ENCRYPTION', 'config' => 'mail.encryption', 'value' => 'ssl', 'display_name' => 'Email Encryption', 'type' => 'text', 'group' => 'Email', 'order' => 2],
      ['key' => 'MAIL_FROM_ADDRESS', 'config' => 'mail.from.address', 'value' => '', 'display_name' => 'Indirizzo email con il quale inviare i messaggi', 'type' => 'text', 'group' => 'Email', 'order' => 3],
      ['key' => 'MAIL_FROM_NAME', 'config' => 'mail.from.name', 'value' => '', 'display_name' => 'Nome con il quale inviare i messaggi', 'type' => 'text', 'group' => 'Email', 'order' => 4],
      ['key' => 'MAIL_HOST', 'config' => 'mail.host', 'value' => '', 'display_name' => 'Host Email', 'type' => 'text', 'group' => 'Email', 'order' => 5],
      ['key' => 'MAIL_PORT', 'config' => 'mail.port', 'value' => 465, 'display_name' => 'Porta Email', 'type' => 'text', 'group' => 'Email', 'order' => 6],
      ['key' => 'MAIL_USERNAME', 'config' => 'mail.username', 'value' => '', 'display_name' => 'Username', 'type' => 'text', 'group' => 'Email', 'order' => 7],
      ['key' => 'MAIL_PASSWORD', 'config' => 'mail.password', 'value' => '', 'display_name' => 'Password', 'type' => 'text', 'group' => 'Email', 'order' => 8],
      ['key' => 'ENABLE_BACKUP', 'config' => 'backup.enable', 'value' => 1, 'display_name' => 'Abilita backup su Dropbox', 'type' => 'boolean', 'group' => 'Backup', 'order' => 9],
      ['key' => 'DROPBOX_AUTH_TOKEN', 'config' => 'filesystems.disks.dropbox.authorization_token', 'value' => '', 'display_name' => 'Dropbox Auth Token', 'type' => 'text', 'group' => 'Backup', 'order' => 10],
    ];
  }


}
