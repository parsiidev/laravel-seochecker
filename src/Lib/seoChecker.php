<?php

namespace Laravelcity\SeoChecker\Lib;

class seoChecker
{
    protected $focal_keyword = ''; // number  1 or 0
    protected $focal_keyword_field;
    protected $primary_key;
    protected $model_name;
    protected $model_id = 0;
    protected $seo_title = ''; // number  1 between 5
    protected $title = ''; // number  1 between 5
    protected $content = ''; // number  1 between 5
    protected $url = ''; // number  1 between 5
    protected $slug = ''; // number  1 between 5
    protected $description = ''; // number  1 between 5
    protected $post = '';
    protected $seoInfo = [];
    protected $messages = [];
    protected $elements = [];
    protected $emtiaz_counter = 1;
    protected $emtiaz;
    protected $model;

    protected $config_seo;

    /**
     * add model
     * @param $model
     * @param null $model_id
     * @return $this
     */
    public function addModel ($model , $model_id = null)
    {
        $mod = config('seochecker.models.' . $model);
        $this->model_name = $model;
        $this->model_id = $model_id;
        $this->model = $mod['class'];
        $this->focal_keyword_field = $mod['focal_keyword_field'];
        $this->primary_key = $mod['primary_key'];
        if ($model_id)
            $this->getModelData();

        $this->config_seo = config('seochecker.seo');

        return $this;
    }

    /**
     * set data for process
     * @param array $array
     * @return $this
     */
    public function addElementsId ($array = [])
    {

        foreach ($array as $item => $value) {
            $this->elements[$item] = $value;
        }
        return $this;
    }

    public function setTitle ($title = '')
    {
        $this->title = $title;
        return $this;
    }

    public function setSlug ($slug = '')
    {
        $this->slug = str_replace('-' , ' ' , $slug);
        $this->setUrl($this->slug);
        return $this;
    }

    public function setContent ($content = '')
    {
        $this->content = $content;
        return $this;
    }

    public function setUrl ($url = '')
    {
        $this->url = str_replace('-' , ' ' , $url);
        return $this;
    }

    public function setDescription ($description = '')
    {
        $this->description = $description;
        return $this;
    }

    public function setFocalKeyword ($focal_keyword = '')
    {
        $this->focal_keyword = $focal_keyword;
        return $this;
    }

    public function setSeoTitle ($seo_title = '')
    {
        $this->seo_title = $seo_title;
        return $this;
    }

    public function setTags ($tags = '')
    {
        if (is_array($tags))
            $tags = implode(' ' , $tags);

        $tags = str_replace(',' , ' ' , $tags);
        $this->tags = $tags;
        return $this;
    }

    public function setModelIs ($id)
    {
        $this->model_id = $id;
        return $this;
    }

    //check data

    public function checkFocalKeyword ()
    {
        if ($this->focal_keyword == '') {
            $this->messages[] = [
                'label' => 'danger' ,
                'msg' => trans('SeoChecker::seoChecker.focal-keyword-notfound') ,
                'point' => -10
            ];
        } else {
            if (app($this->model)->where($this->focal_keyword_field , $this->focal_keyword)->where($this->primary_key , '<>' , $this->model_id)->count() > 0)
                $this->messages[] = [
                    'label' => 'warning' ,
                    'msg' => trans('SeoChecker::seoChecker.focal-keyword-already-exist') ,
                    'point' => 5
                ];
            else
                $this->messages[] = [
                    'label' => 'success' ,
                    'msg' => trans('SeoChecker::seoChecker.focal-keyword-not-used') ,
                    'point' => 10
                ];
        }
    } //ok

    public function checkSeoTitle ()
    {

        if ($this->seo_title != '') {

            if ($this->checkFocalKeywordInItems($this->seo_title) !== false) {
                $mod_focal_keyword = str_replace(' ' , '-' , $this->focal_keyword);
                $seo_title_new = str_replace($this->focal_keyword , $mod_focal_keyword , $this->seo_title);
                $ex = explode(' ' , $seo_title_new);

                if ($this->checkFocalKeywordInItems(str_replace('-' , ' ' , $ex[0])) !== false) {
                    $this->messages[] = [
                        'label' => 'success' ,
                        'msg' => trans('SeoChecker::seoChecker.seo-title-has-focal-keyword-in-begin') ,
                        'point' => 5
                    ];
                } else {
                    $this->messages[] = [
                        'label' => 'warning' ,
                        'msg' => trans('SeoChecker::seoChecker.seo-title-has-focal-keyword-but-not-begin') ,
                        'point' => 5
                    ];
                }
            } else {
                $this->messages[] = [
                    'label' => 'danger' ,
                    'msg' => trans('SeoChecker::seoChecker.seo-title-no-focal-keyword') ,
                    'point' => -5
                ];
            }

            if (mb_strlen($this->seo_title) > $this->config_seo['title-max-length']) {
                $this->messages[] = [
                    'label' => 'warning' ,
                    'msg' => trans('SeoChecker::seoChecker.seo-title-limit-character' , ['number' => $this->config_seo['title-max-length']]) ,
                    'point' => -5
                ];
            }
        } else {
            $this->messages[] = [
                'label' => 'danger' ,
                'msg' => trans('SeoChecker::seoChecker.seo-title-no') ,
                'point' => 0
            ];
        }

    }

    public function checkTitle ()
    {
        if ($this->title == '') {
            $this->messages[] = [
                'label' => 'danger' ,
                'msg' => trans('SeoChecker::seoChecker.title-no') ,
                'point' => 0
            ];
        } else {

            if (mb_strlen($this->title) > $this->config_seo['title-max-length'] || mb_strlen($this->title) < $this->config_seo['title-min-length']) {
                $this->messages[] = [
                    'label' => 'warning' ,
                    'msg' => trans('SeoChecker::seoChecker.title-limit' , ['min' => $this->config_seo['title-min-length'] , 'max' => $this->config_seo['title-max-length']]) ,
                    'point' => 0
                ];
            } elseif (mb_strlen($this->title) >= $this->config_seo['title-min-length'] && mb_strlen($this->title) <= $this->config_seo['title-max-length']) {
                $this->messages[] = [
                    'label' => 'success' ,
                    'msg' => trans('SeoChecker::seoChecker.title-good') ,
                    'point' => 0
                ];
            }
        }
    }

    public function checkUrl ()
    {
        if ($this->url != '') {
            if ($this->checkFocalKeywordInItems($this->url) !== false)

                $this->messages[] = [
                    'label' => 'success' ,
                    'msg' => trans('SeoChecker::seoChecker.url-good') ,
                    'point' => 0
                ];

            else
                $this->messages[] = [
                    'label' => 'warning' ,
                    'msg' => trans('SeoChecker::seoChecker.url-no-focal-keyword') ,
                    'point' => 0
                ];
        }

    }

    public function checkSlug ()
    {
        if (mb_strlen($this->slug) > 40)
            $this->messages[] = [
                'label' => 'warning' ,
                'msg' => trans('SeoChecker::seoChecker.slug-is-long') ,
                'point' => 0
            ];

    }

    public function checkContent ()
    {
        if (mb_strlen($this->content) < $this->config_seo['title-min-length'])
            $this->messages[] = [
                'label' => 'warning' ,
                'msg' => trans('SeoChecker::seoChecker.content-limit-char' , ['number' => mb_strlen($this->content) , 'min' => $this->config_seo['content-min-length']]) ,
                'point' => 0
            ];
        else
            $this->messages[] = [
                'label' => 'success' ,
                'msg' => trans('SeoChecker::seoChecker.content-limit-char-up' , ['number' => mb_strlen($this->content) , 'min' => $this->config_seo['content-min-length']]) ,
                'point' => 0
            ];

        $matched = array();

        $dom = new \DOMDocument();
        @$dom->loadHtml($this->content);

        $length = $dom->getElementsByTagName('a')->length;
        /// tag a لینک
        if ($length == 0) {
            $this->messages[] = [
                'label' => 'warning' ,
                'msg' => trans('SeoChecker::seoChecker.content-no-link') ,
                'point' => 0
            ];
        }
        $nofollow = 0;
        $follow = 0;
        for ($i = 0; $i < $length; $i++) {
            $type = $dom->getElementsByTagName("a")->item($i)->getAttribute("rel");

            if ($type == 'nofollow')
                $nofollow++;
            else
                $follow++;
        }
        if ($follow > 0 || $nofollow > 0) {

            $this->messages[] = [
                'label' => 'success' ,
                'msg' => trans('SeoChecker::seoChecker.content-follow-no-follow' , ['follow' => $follow , 'nofollow' => $nofollow]) ,
                'point' => 0
            ];
        }


        // عکس

        $pic_length = $dom->getElementsByTagName('img')->length;

        if ($pic_length == 0) {
            $this->messages[] = [
                'label' => 'warning' ,
                'msg' => trans('SeoChecker::seoChecker.content-no-photo') ,
                'point' => 0
            ];
        }

        $alt = 0;
        $alt_f_k = 0;
        for ($i = 0; $i < $pic_length; $i++) {
            $type = @$dom->getElementsByTagName("img")->item($i)->getAttribute("alt");
            if (empty($type) || $type == '')
                $alt++;
            $type = utf8_decode($type);
            if ($this->checkFocalKeywordInItems($type) === false)
                $alt_f_k++;
        }
        if ($alt > 0)
            $this->messages[] = [
                'label' => 'warning' ,
                'msg' => trans('SeoChecker::seoChecker.content-photo-no-alt') ,
                'point' => 0
            ];
        if ($alt_f_k > 0)
            $this->messages[] = [
                'label' => 'warning' ,
                'msg' => trans('SeoChecker::seoChecker.content-photo-alt-no-focal-keyword') ,
                'point' => 0
            ];
    }

    public function checkDescription ()
    {
        if ($this->description != '') {

            if ($this->checkFocalKeywordInItems($this->description) !== false) {
                $this->messages[] = [
                    'label' => 'success' ,
                    'msg' => trans('SeoChecker::seoChecker.description-is-focal-keyword') ,
                    'point' => 2
                ];
            } else {
                $this->messages[] = [
                    'label' => 'danger' ,
                    'msg' => trans('SeoChecker::seoChecker.description-no-focal-keyword') ,
                    'point' => 1
                ];
            }

            if (mb_strlen($this->description) < 150 && mb_strlen($this->description) > 120) {
                $this->messages[] = [
                    'label' => 'success' ,
                    'msg' => trans('SeoChecker::seoChecker.description-good-length') ,
                    'point' => 0
                ];
            } else {
                if (mb_strlen($this->description) < $this->config_seo['description-min-length'])
                    $this->messages[] = [
                        'label' => 'warning' ,
                        'msg' => trans('SeoChecker::seoChecker.description-is-low') ,
                        'point' => 0
                    ];
                if (mb_strlen($this->description) > $this->config_seo['description-max-length'])
                    $this->messages[] = [
                        'label' => 'danger' ,
                        'msg' => trans('SeoChecker::seoChecker.description-limit' , ['max' => $this->config_seo['description-max-length']]) ,
                        'point' => 0
                    ];
            }
        } else {
            $this->messages[] = [
                'label' => 'danger' ,
                'msg' => trans('SeoChecker::seoChecker.description-no') ,
                'point' => 0
            ];
        }
    }

    public function checkFocalKeywordInItems ($item)
    {
        if ($item != '')
            return strpos($item , $this->focal_keyword);
        return false;
    }

    public function getModelData ()
    {
        if ($model = app($this->model)->where($this->primary_key , $this->model_id)->first()) {
            $this->setTitle($model->title);
            $this->setSlug($model->slug);
            $this->setContent($model->content);
            $this->setDescription($model->description);
            $this->setFocalKeyword($model->seo_focal_keyword);
            $this->setSeoTitle($model->seo_title);

            $this->seoInfo = [
                'title' => $model->full_title ,
                'description' => $model->description ,
                'url' => @$model->url ,
            ];
        }

    }

    public function seoProcess ()
    {
        $this->messages = [];
        $this->checkFocalKeyword();
        $this->checkSeoTitle();
        $this->checkTitle();
        $this->checkSlug();
        $this->checkUrl();
        $this->checkContent();
        $this->checkDescription();
        return $this;
    }

    public function messages ()
    {
        return $this->messages;
    }

    public function checkPoints ()
    {
        $emtiaz = [SeoStatus::GOOD => 0 , SeoStatus::NORMAL => 0 , SeoStatus::BAD => 0];
        foreach ($this->messages() as $key => $value) {
            switch ($value['label']) {
                case 'warning':
                    $emtiaz[SeoStatus::NORMAL]++;
                    break;
                case 'danger':
                    $emtiaz[SeoStatus::BAD]++;
                    break;
                case 'success':
                    $emtiaz[SeoStatus::GOOD]++;
                    break;
            }
        }

        if ($emtiaz[SeoStatus::GOOD] >= $emtiaz[SeoStatus::BAD] && $emtiaz[SeoStatus::GOOD] >= $emtiaz[SeoStatus::NORMAL]) {

            if ($emtiaz[SeoStatus::GOOD] == $emtiaz[SeoStatus::BAD] || $emtiaz[SeoStatus::GOOD] == $emtiaz[SeoStatus::NORMAL]) {

                if ($emtiaz[SeoStatus::NORMAL] >= $emtiaz[SeoStatus::BAD])
                    return SeoStatus::NORMAL;
                else
                    return SeoStatus::BAD;
            } else
                return SeoStatus::GOOD;
        }

        if ($emtiaz[SeoStatus::NORMAL] >= $emtiaz[SeoStatus::BAD] && $emtiaz[SeoStatus::NORMAL] >= $emtiaz[SeoStatus::GOOD]) {

            if ($emtiaz[SeoStatus::NORMAL] == $emtiaz[SeoStatus::BAD] || $emtiaz[SeoStatus::NORMAL] == $emtiaz[SeoStatus::GOOD]) {

                if ($emtiaz[SeoStatus::GOOD] >= $emtiaz[SeoStatus::BAD])
                    return SeoStatus::GOOD;
                else
                    return SeoStatus::BAD;
            } else
                return SeoStatus::NORMAL;
        }

        if ($emtiaz[SeoStatus::BAD] >= $emtiaz[SeoStatus::NORMAL] && $emtiaz[SeoStatus::BAD] >= $emtiaz[SeoStatus::GOOD]) {

            if ($emtiaz[SeoStatus::BAD] == $emtiaz[SeoStatus::BAD] || $emtiaz[SeoStatus::BAD] == $emtiaz[SeoStatus::GOOD]) {
                return SeoStatus::BAD;
            } else {
                if ($emtiaz[SeoStatus::NORMAL] >= $emtiaz[SeoStatus::GOOD])
                    return SeoStatus::NORMAL;
                else
                    return SeoStatus::GOOD;
            }
        }


    }

    public function view ()
    {
        $this->seoProcess();

        $array = $this->seoInfo;
        $array = array_add($array , 'messages' , $this->messages());
        $array = array_add($array , 'seo_status' , $this->checkPoints());

        $view = view('SeoChecker::result')->with($array)->render();

        return view('SeoChecker::seo')->with(['elements' => $this->elements , 'seoChecker' => $view , 'model' => $this->model_name , 'model_id' => $this->model_id])->render();
    }

    public function ajaxAnalayze ()
    {
        return view('SeoChecker::show')->with(['messages' => $this->messages])->render();
    }

}