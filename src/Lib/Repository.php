<?php

namespace Laravelcity\SeoChecker\Lib;

class Repository
{
    protected $checker;
    protected $config;

    public function __construct ()
    {
        $this->checker = new seoChecker(); //set category model
        $this->config = config('seochecker');
    }

    public function addModel ($model , $model_id = null)
    {
        if (!config("seochecker.models." . $model)) {
            throw new seoCheckerException("Model $model not found");
        } else {
            $this->checker->addModel($model , $model_id); //set category model
            return $this->checker;
        }

    }

    /**'set data
     * @param array $array
     */
    public function addElementsId ($array = [])
    {
        $this->checker->addElementsId($array);
    }

    /**
     * process seo
     */
    public function process ()
    {
        $this->checker->seoProcess();
    }

    /**
     * return messages
     * @return array
     */
    public function messages ()
    {
        return $this->checker->messages();
    }

    /**
     * return soo checked details
     * @return string
     */
    public function view ()
    {
        return $this->checker->view();
    }

    /**
     * return checked details point
     * @return string
     */
    public function checkPoints ()
    {
        return $this->checker->checkPoints();
    }

    /**
     * set data for process
     * @param $title
     * @param $slug
     * @param $content
     * @param $description
     * @param $focal_keyword
     * @param $seoTitle
     * @return seoChecker
     */
    public function setData ($title , $slug , $content , $description , $focal_keyword , $seoTitle)
    {
        $this->checker->setTitle($title);
        $this->checker->setSlug($slug);
        $this->checker->setContent($content);
        $this->checker->setDescription($description);
        $this->checker->setFocalKeyword($focal_keyword);
        $this->checker->setSeoTitle($seoTitle);
        return $this->checker;
    }
}