<?php

namespace Laravelcity\SeoChecker;

use Illuminate\Routing\Controller as BaseController;
use Laravelcity\SeoChecker\Lib\Repository;

class Controller extends BaseController
{
    protected $checker;


    public function __construct ()
    {
        $this->checker = new Repository();
    }


    public function ajaxAnalayze ()
    {

        $this->checker->addModel(request()->input('model_name' , '') , \request()->input('model_id' , 0));

        $this->checker->setData(
            request()->input('title' , '') ,
            request()->input('slug' , '') ,
            request()->input('content' , '') ,
            request()->input('description' , '') ,
            request()->input('focal_keyword' , '') ,
            request()->input('seo_title' , '')
        );

        $title = request()->input('title' , '');
        if (request()->input('seo_title' , '') != '') {
            $title = request()->input('seo_title' , '');
        }
        if ($title == '')
            $title = 'Here is the title of the post';

        $this->checker->process();

        return view('SeoChecker::result')->with([
            'messages' => $this->checker->messages() ,
            'seo_status' => $this->checker->checkPoints() ,
            'title' => $title ,
            'description' => request()->input('description' , '') ,
            'url' => request()->input('slug' , '') ,
        ])->render();
    }
}