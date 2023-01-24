<?php 

namespace App\Models\ApiDetails;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ApiDetails extends Model{
    use HasFactory;

    protected $table='APIDetails';

    protected $primaryKey = 'api_details_id';

    protected $fillable = ['api_key','expire_date','expire_time','status','creted_at','update_at'];

}