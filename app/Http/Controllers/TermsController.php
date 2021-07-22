<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Management\EventSearchService;
use App\Management\RegisterService;
use App\Models\Management\Place;
use App\Models\Management\Sport;
use App\Models\Management\Timezone;
use App\Models\User\Event;
use App\Models\User\EventRecurring;
use App\Models\User\EventRegistration;
use Carbon\Carbon;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TermsController extends Controller
{
    public function terms()
    {
        return view('terms');
    }
}
