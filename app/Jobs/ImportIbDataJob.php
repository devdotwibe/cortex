<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;
use App\Models\IbImport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use App\Models\User;

class ImportIbDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $datas;
    protected $filePath;
   

 
    public function __construct( $datas,  $filePath )
    {

        $this->datas = $datas;
        $this->filePath = $filePath;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       
        // $data = Excel::toArray([], $this->filePath);

        try {

                $sheetData = json_decode(Storage::get($this->filePath),true);


                $columnNames =$sheetData[0];

                // $excel_data = $this->parsedData;

                foreach ($sheetData as $k=> $row) {
                    
                    if($k!=0){
                        
                    $ib_import = new User;  

                    foreach ($this->datas as $fieldName => $xlsxColumn) {
                    
                        $userColumns = Schema::getColumnListing('ib_imports');

                    
                        $XlxsColumnIndex = array_search($xlsxColumn, $columnNames);

                    
                            if ($XlxsColumnIndex !== false && in_array($fieldName, $userColumns, true)) {

                                if (isset($row[$XlxsColumnIndex])) {
                            
                                  

                                    
                                    

                                        $value = $row[$XlxsColumnIndex];
                                    
                        
                                
                                    if(is_string($value))
                                    {
                                        $value = str_replace('/', ',', $value);
                                    }

                                    
                                    $ib_import->{$fieldName} = $value;
                                }
                              
                            
                        }
                    }
                    
                    $ib_import->save();
                    }
                }
        }
        catch (\Exception $e) {
           
           
    
            // throw $e;
        }

    }

}
