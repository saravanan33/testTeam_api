<?php 

namespace App\Models\ApiDetails;

use Illuminate\Database\Eloquent\Model;


class ApiDetails extends Model{

    protected $table='APIDetails';

    protected $primaryKey = 'api_details_id';

    protected $fillable = ['api_key','expire_date','expire_time','status','creted_at','update_at'];

}