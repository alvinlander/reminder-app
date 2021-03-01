<?php

namespace App\Widgets;

use App\Models\Certification;
use App\Models\User as ModelsUser;
use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

class Station extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = Certification::count();
        $string = trans_choice('Station', $count);

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-backpack',
            'title'  => "{$count} {$string}",
            'text'   => __("$count Station"),
            'button' => [
                'text' => __('View all station'),
                'link' => route('voyager.certifications.index'),
            ],
            'image' => asset('img/kereta.jpeg'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return Auth::user()->can('browse', Voyager::model('User'));
    }
}
