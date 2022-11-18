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
    public function option_exist($optionname)
    {
        $count = Options::where("option_name",$optionname)->count();
        return ($count != 0) ? "exist" : "notexist";
    }
    public function create_option($optionname,$optionvalue)
    {
        Options::create([
            "option_name"=>$optionname,
            "option_value"=>$optionvalue,
        ]);
    }
    public function update_option($optionname,$optionvalue)
    {
        Options::where("option_name",$optionname)->update([
            "option_name"=>$optionname,
            "option_value"=>$optionvalue,
        ]);
    }

    public function get_portal_setting()
    {
        $options = Options::pluck("option_value","option_name");
        return $options;
    }
    public function updatedisableinspection($optionname,$newvalue,$action)
    {
       $check = $this->option_exist($optionname);
       if($check == "exist")
       {    
            $newarray =  [];
            $currentvalue = $this->get_option($optionname);
            if(!empty($currentvalue))
            {   
                foreach(json_decode($currentvalue,true) as $key=>$value)
                {
                    if($value == $newvalue && $action == "remove")
                    {
                        continue;
                    }   
                    $newarray[] = $value;
                }
                if($action != "remove") 
                { 
                    $newarray[] = $newvalue;
                };
                $this->update_option($optionname,json_encode($newarray));
            }
       }
       else
       {
        $newvalue = array($newvalue);
         $this->create_option($optionname,json_encode($newvalue));
       }
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

    public function envUpdate($data=[])
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            foreach($data as $key =>$value){
                    file_put_contents($path, str_ireplace($key.'='.env($key), strtoupper($key).'='.$value,file_get_contents($path)));
          
            }        
        }
    }
}
