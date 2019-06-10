<?php

namespace Modules\Oratorio\Entities;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
  protected $table = "audits";
  protected $fillable = ['user_type', 'user_id', 'event', 'auditable_type', 'auditable_id', 'old_values', 'new_values', 'url', 'ip_address', 'user_agent'];


}
