<?php

namespace App\View\Components\Dates\Subscription;

use App\Helpers\Date;
use App\Helpers\Person;
use App\Models\Dates\Birth as BirthModel;
use App\Models\Dates\BirthWould as BirthWouldModel;
use App\Models\Dates\Death as DeathModel;
use App\Models\Dates\Events as EventsModel;
use App\Models\Dates\Person as PersonModel;
use App\View\Dates\EventNotification as EventView;
use Illuminate\View\Component;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

final class EventsNotification extends Component
{
    public bool $isEmpty;
    /**
     * @var Collection|EventView[] $past
     */
    public Collection $past;

    /**
     * @var Collection|EventView[] $today
     */
    public Collection $today;

    /**
     * @var Collection|EventView[] $nearest
     */
    public Collection $nearest;

    public function __construct(EventsModel $model, public readonly string $pathPerson)
    {
        $this->initialize($model);
    }

    public function render(): View|Factory
    {
        return view('components.dates.subscription.events-notification');
    }

    private function initialize(EventsModel $model): void
    {
        $this->isEmpty = $model->isEmpty;

        $this->past = collect();
        foreach ($model->pastBirth as $item) {
            $this->past->add(
                $this->getBirth(
                    $item,
                    __("events.birth.fulfilled") . " " . (($item->age === null) ? "" : Date::dateInterval($item->age))
                )
            );
        }
        foreach ($model->pastBirthWould as $item) {
            $this->past->add(
                $this->getBirthWould($item)
            );
        }
        foreach ($model->pastDeath as $item) {
            $this->past->add(
                $this->getDeath($item)
            );
        }

        $this->today = collect();
        foreach ($model->todayBirth as $item) {
            $this->today->add(
                $this->getBirth(
                    $item,
                    ($item->age === null) ? "" : Date::dateInterval($item->age)
                )
            );
        }
        foreach ($model->todayBirthWould as $item) {
            $this->today->add(
                $this->getBirthWould($item)
            );
        }
        foreach ($model->todayDeath as $item) {
            $this->today->add(
                $this->getDeath($item)
            );
        }

        $this->nearest = collect();
        foreach ($model->nearestBirth as $item) {
            $this->nearest->add(
                $this->getBirth(
                    $item,
                    __("events.birth.will_be") . " " . (($item->age === null) ? "" : Date::dateInterval($item->age))
                )
            );
        }
        foreach ($model->nearestBirthWould as $item) {
            $this->nearest->add(
                $this->getBirthWould($item)
            );
        }
        foreach ($model->nearestDeath as $item) {
            $this->nearest->add(
                $this->getDeath($item)
            );
        }
    }

    private function getBirth(BirthModel $event, string $calculate): EventView
    {
        return $this->createView(
            __("events.birth.name"),
            Date::format($event->date->string),
            $event->person,
            $calculate
        );
    }

    private function getBirthWould(BirthWouldModel $event): EventView
    {
        return $this->createView(
            __("events.birth.name"),
            Date::format($event->date->string),
            $event->person,
            Date::dateInterval($event->age) . " " .  __("events.birth.past")
        );
    }

    private function getDeath(DeathModel $event): EventView
    {
        $calculate = "";
        if ($event->age === null) {
            $calculate = __("events.death.passed", [
                "interval" => Date::dateInterval($event->interval)
            ]);
        } else {
            $calculate =  __("events.death.passed_age", [
                "interval" => Date::dateInterval($event->interval),
                "age" => Date::dateInterval($event->age)
            ]);
        }
        return $this->createView(
            __("events.death.name"),
            Date::format($event->date->string),
            $event->person,
            $calculate
        );
    }

    private function createView(
        string $nameEvent,
        string $date,
        PersonModel $person,
        string $calculate
    ): EventView {
        return new EventView(
            $nameEvent,
            $date,
            $person->id,
            $this->personFullName($person),
            "(" . $calculate . ")"
        );
    }

    private function personFullName(PersonModel $person): string
    {
        return Person::surname($person->surname)
            . " "
            . Person::oldSurname($person->oldSurname)
            . (($person->oldSurname !== null && $person->oldSurname->count() > 0) ? " " : "")
            . Person::name($person->name)
            . " "
            . Person::patronymic($person->patronymic);
    }
}
