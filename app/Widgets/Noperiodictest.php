<?php

namespace App\Widgets;

use App\Models\Certification;
use App\Models\User as ModelsUser;
use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

class Noperiodictest extends AbstractWidget
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
        $count = Certification::whereStatus('Belum dilakukan uji berkala')->count();
        $string = trans_choice('Status stasiun belum dilakukan uji berkala', $count);

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-backpack',
            'title'  => "{$count} {$string}",
            'text'   => __("$count Stasiun belum dilakukan uji berkala"),
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
