<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Product;
class AvailabilityCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Availability:cron';


    protected $yesterday;
    protected $tenhours;
    protected $ThirtyMinutes;
    protected $today;
    protected $EVENT_TIME;
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reopen Closed Items';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->yesterday    = date("Y-m-d",strtotime("-1 days"));
        $this->tenhours     = date("Y-m-d H:i:s",strtotime("-10 hours"));     
        $this->ThirtyMinutes= date("Y-m-d H:i:s",strtotime("-30 minutes"));  
        $this->today        = date("Y-m-d");
        $this->EVENT_TIME   = date("Y-m-d H:i:s");
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // <	    
	    Product::where('available','OFF')->where('open_at','<',$this->EVENT_TIME)->update(['available' => 'ON','open_at'=>null]);
  	    #$reopen_items = DB::select( DB::raw(" update products SET available='ON',open_at = NULL  WHERE available='OFF' AND open_ats > '".$this->EVENT_TIME. "'" ));
	    \Log::info("Cron worked at ". $this->EVENT_TIME." where time less Than ".$this->ThirtyMinutes );
     
        /*
           Write your database logic we bellow:
           Item::create(['name'=>'hello new']);
        */
      
        $this->info('Availability:Cron Cummand Run successfully!');
    }
}

