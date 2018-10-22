<?php

namespace Laravelcity\SeoChecker\Lib;


interface  interfaceSeoChecker
{
    //set data
    public function setTitle($title='');
    public function setSlug($slug='');
    public function setUrl($url='');
    public function setContent($url='');
    public function setDescription($description='');
    public function setFocalKeyword($focalKeyword='');
    public function setSeoTitle($seoTitle='');

    //get data
    public function getTitle();
    public function getSlug();
    public function getUrl();
    public function getContent();
    public function getDescription();
    public function getFocalKeyword();
    public function getSeoTitle();

    //check data and return point and messages
    public function checkTitle();
    public function checkSlug();
    public function checkUrl();
    public function checkContent();
    public function checkDescription();
    public function checkFocalKeyword();
    public function checkSeoTitle();

    //
    public function seoProcess();
    public function checkPoints();
    public function checkFocalKeywordInItems($item);
    public function messages();
}