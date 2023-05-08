<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use \Carbon\Carbon;
use App\Mail\BookingReminderNotification;
use Mail;

class BoookingReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send customer and coach a booking reminder';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = Carbon::parse(date('Y-m-d'))->addDay();
        echo $date;
        $booking = Booking::where('date', $date)->get();
        foreach ($booking as $value) {
            Mail::to($value->coach->email)->queue(new BookingReminderNotification($value));
            Mail::to($value->customer->email)->queue(new BookingReminderNotification($value));
        }
    }
}
