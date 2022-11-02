<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    use HasFactory;

    protected $fillable = [
        'option_name',
        'option_value',
    ];

    public function get_option($optionname)
    {
        $option = Options::where("option_name",$optionname)->first();
        return (!empty($option)) ? $option["option_value"] : "";

    }

    public function get_portal_setting()
    {
        $options = Options::pluck("option_value","option_name");
        return $options;
    }
    public function updatesetting($settings)
    {
        foreach($settings as $key=>$value)
        {
            if($key != "_token")
            {
                Options::where("option_name",$key)->update([
                    "option_value" => trim($value),
                ]);   
            }
        }
    }
}
