<?php
/**
 * @copyright Sport M4te s.r.o. 2021 - present
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

class EventController extends Controller
{
    /**
     * @var RegisterService
     */
    private $registerService;

    public function __construct(RegisterService $registerService) {
        $this->registerService = $registerService;
    }

    public function me()
    {
        $user = auth()->user();
        $hosting = $user->hosting;
        $hosted = $user->hosted;
        $upcoming = $user->upcoming;
        $going = $user->going;
        $pastEvents = $user->pastEvents;

        return view('events.list-my-events', get_defined_vars());
    }

    public function create()
    {
        $categories = $this->registerService->listSports();
        $levels = Event::LEVELS;
        $event = new Event();
        $readonly = false;

        return view('events.create', get_defined_vars());
    }

    public function index(
        Request $request,
        $sport = null
    ) {
        $eventSearchService = new EventSearchService();
        $eventSearchService->addOption('relations', ['registrations', 'category', 'place.timezone', 'owner']);

        if (!empty($sport)) {
            $sport = Sport::where('slug', $sport)->first();
            if ($sport) {
                $eventSearchService->addOption('category_id', $sport->id);
            }
        } elseif ($request->filled('sport_id')) {
            $eventSearchService->addOption('category_id', $request->get('sport_id'));
        }

        $radius = $request->get('radius');
        if (!empty($radius)) {
            $eventSearchService->addOption('radius_km', $radius);
        }

        $upcoming = $request->get('upcoming');
        if (!empty($upcoming)) {
            $eventSearchService->addOption('upcoming', true);
        }

        $location = $request->get('location');
        if (!empty($location)) {
            $eventSearchService->addOption('location', $location);
        }

        $dates = $request->get('dates', []);
        if (!empty($dates)) {
            $eventSearchService->addOption('dates', $dates);
        }

        $placeId = $request->get('place_id');
        if (!empty($placeId)) {
            $eventSearchService->addOption('place_id', $placeId);
        }

        $gps = $request->get('gps');
        if (!empty($gps['lat']) && !empty($gps['lng'])) {
            $eventSearchService->addOption('gps', new Point($gps['lat'], $gps['lng']));
        }

        $query = $request->get('q');

        if ($query || $request->filled('page')) {
            $eventSearchService->addOption('query', $query);
        }

        $intro = count($eventSearchService->getOptions()) === 1;

        $events = $eventSearchService->query()->paginate();

        $text = $eventSearchService->getOption('text');

        $user = auth()->user();
        $userSports = $user->sports;
        $userSportsTotal = $userSports->count();
        $sports = $this->registerService->getSports();

        return view('events.list', get_defined_vars());
    }

    public function detail(Event $event)
    {
        $event->load(['registrations', 'owner', 'teams']);

        $members = $event->members();

        return view('events.detail', get_defined_vars());
    }

    public function edit(Event $event)
    {
        $categories = $this->registerService->listSports();
        $levels = Event::LEVELS;
        $readonly = $event->passed();

        return view('events.edit', get_defined_vars());
    }
}
