<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
 */

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateRecurringEventCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $daynames = [
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
            'saturday',
            'sunday',
        ];

        $insert = 'INSERT IGNORE INTO event';

        foreach ($daynames as $index => $dayname) {
            if ($index > 0) {
                $insert .= ' UNION ';
            }

            $insert .= "(SELECT NULL,
	event.user_id,
	event.id as parent_id,
	event.category_id,
	event.privacy,
	event.place_id,
	event.name,
	event.location,
	event.level,
	event.description,
	CONCAT(IF((@date := DATE(SYSDATE() + INTERVAL {$index} - WEEKDAY(SYSDATE()) DAY)) > event.start, @date, (@date := DATE(SYSDATE() + INTERVAL 7 + {$index} - WEEKDAY(SYSDATE()) DAY))), ' ', event_recurring.start),
	CONCAT(@date, ' ', event_recurring.end),
	IF(event.deadline IS NULL, event.deadline, DATE_SUB(CONCAT(@date, ' ', event_recurring.start), INTERVAL TIME_TO_SEC(TIMEDIFF(event.start, event.deadline)) SECOND)),
	event.registration_limit,
	event.timezone_id,
	SYSDATE(),
	SYSDATE(),
	event.deleted_at
FROM event_recurring
JOIN event ON event.id = event_id
WHERE event.deleted_at IS NULL
      AND event.parent_id IS NULL
      AND event_recurring.{$dayname} = 1)\n";
        }

        DB::insert($insert);

        return 0;
    }
}
