<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;
use App\Models\UserSubscription;
use Illuminate\Http\Request;

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
        try {
            $sheetData = json_decode(Storage::get($this->filePath), true);
            $columnNames = $sheetData[0]; // Assuming the first row contains column headers
    
            foreach ($sheetData as $k => $row) {
                if ($k != 0) {
                    $usersub = new UserSubscription();
                    $user = new User;
    
                    $firstName = ''; // Initialize at the beginning of each iteration
                    $lastName = '';  // Initialize at the beginning of each iteration
    
                    foreach ($this->datas as $fieldName => $xlsxColumn) {
                        $userColumns = Schema::getColumnListing('users');
                        $XlxsColumnIndex = array_search($xlsxColumn, $columnNames);
    
                        if ($XlxsColumnIndex !== false && in_array($fieldName, $userColumns, true)) {
                            if (isset($row[$XlxsColumnIndex])) {
                                $user->{$fieldName} = $row[$XlxsColumnIndex];
                                if ($fieldName === 'first_name') {
                                    $firstName = $row[$XlxsColumnIndex];
                                } elseif ($fieldName === 'last_name') {
                                    $lastName = $row[$XlxsColumnIndex];
                                }
                            }
                        }
                    }
    
                    $user->name = trim($firstName . ' ' . $lastName);
                    $user->password = ""; // You might want to hash a real password here
                    $user->save();
    
                    $usersub->status = "subscribed";
                    $usersub->user_id = $user->id;
                    $usersub->expire_at = $this->datas['expiry_date'] ?? null; // Assuming 'expiry_date' is in $datas
                    $usersub->subscription_plan_id = 0;
                    $usersub->pay_by = 0;
                    $usersub->save();
                }
            }
        } catch (\Exception $e) {
            Log::error('Error in ImportIbDataJob: ' . $e->getMessage());
            // Optionally, rethrow the exception or handle it as needed
        }
    }
}    