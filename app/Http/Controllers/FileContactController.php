<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;

use App\Models\FilesContact;
use App\Helpers\PhoneValidator;
use App\Helpers\DateValidator;
use App\Helpers\TdcValidator;
use Exception;

class FileContactController extends Controller
{
    //
    function getRequiredFields(){
        $required_fields = array(
            '0' => 'name', 
            '1' => 'date of birth', 
            '2' => 'phone', 
            '3' => 'address', 
            '4' => 'credit card', 
            '5' => 'franchise', 
            '6' =>'email');

        return $required_fields;
    }

    public function listAll()
    {   
        $userid = auth()->user()->id; 
        return FilesContact::where(
            'user_id', $userid
            )->orderBy(
                'status'
            )->get();
    }

    /**
     * Description
     * 
     * @link /upload
     * @param file file CSV file to process
     */
    public function upload(Request $request){
        $data = array();
        $validator = Validator::make(
            $request->all(),
            [
                'file' => 'required|mimes:csv,txt|max:1024'
            ]
        );
        $userid = auth()->user()->id;       
        if($validator->fails()){
            $data['success'] = false;
            $data['error'] = $validator->errors()->first('file');
        }else{
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $path = $request->file('file')->storeAs(
                'files/',
                $filename,
                's3'
            );      
            $defaultStatus = 'on hold';
            $fileToStore = array(
                'user_id' => $userid,
                'name'    => $filename,
                'url'     => $path,
                'status'  => $defaultStatus,
                'errorDetail' => ""
            );
            try{
                FilesContact::create($fileToStore);
                $data['success'] = true;
                $data['message'] = "Upload succesfully!";
                $data['name'] = $path;
            }catch(Exception $e){
                $data['success'] = false;
                $data['error'] = $e->getMessage();
            }
        }
        return response($data,201);
    }

    public function getFiles($status){
        return FilesContact::where('status',$status)->get();
    }

    public function readFile($filename){
        $data = array();
        $content_list = array();
        $filename = 'files/'.$filename;
        if (Storage::disk('s3')->exists($filename)) {
            $csv = Storage::disk('s3')->get($filename);
            foreach(preg_split("/((\r?\n)|(\r\n?))/", $csv) as $line){
                $row = str_getcsv($line,";");
                if(count($row) > 1){
                    $content_list[] = str_getcsv($line,";");
                }
            } 
            $required_fields = $this->getRequiredFields();
            $tmp_headers = array_shift($content_list);
            $headers = array();
            //Validate fiedls
            foreach($required_fields as $key => $valid_fields){
                foreach($tmp_headers as $src_key => $header_name){
                    similar_text($header_name,$valid_fields,$percent);
                    if($percent > 60 && array_key_exists($src_key, $headers)){
                        $headers +=  [$src_key => $valid_fields];
                    }
                }
            }
            $final_content = array();
            foreach($content_list as $val){
                $list = array();
                foreach(array_keys($headers) as $index){                    
                   $list[] = $val[$index];           
                }
                $final_content[] = $list;
            }
            if(count($headers) == count($required_fields)){
                //Update to Processing file status
            }else{
                //Update to Failed status

            }
            $data['success'] = true;
            $data['headers'] = $headers;
            $data['content'] = $final_content;
        }else{
            $data['success'] = false;            
        }
        return $data;
    }


}
