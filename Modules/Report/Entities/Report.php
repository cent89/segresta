<?php

namespace Modules\Report\Entities;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = "report";
    protected $fillable = ['id_event', 'report', 'titolo', 'route'];
}
