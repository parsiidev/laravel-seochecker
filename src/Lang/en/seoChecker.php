<?php
return [

    \Laravelcity\SeoChecker\Lib\SeoStatus::NORMAL=>'Normal',
    \Laravelcity\SeoChecker\Lib\SeoStatus::GOOD=>'Good',
    \Laravelcity\SeoChecker\Lib\SeoStatus::BAD=>'Bad',
    'seo-status'=>'Seo status ',
    'focal-keyword-notfound'=>'Focal keyword not found',
    'focal-keyword-already-exist'=>'Focal keyword already exist',
    'focal-keyword-not-used'=>'The focal keyword has not been used before and this is very good',

    //seo title
    'seo-title-no'=>'There is no SEO title',
    'seo-title-no-focal-keyword'=>'There is no focal keyword in the SEO title',
    'seo-title-limit-character'=>'The title should not exceed :number characters',
    'seo-title-has-focal-keyword-in-begin'=>'The title of the SEO contains a focal keyword at the beginning that can improve the ranking.',
    'seo-title-has-focal-keyword-but-not-begin'=>'The title of the keyword contains the focal keyword, but the keyword does not appear at the beginning of the title; try to put it at the top of the title.',

    //title

    'title-no'=>'The page title is blank. To fill this section, use a variety of keywords or proper absorbing words.',
    'title-limit'=>'It should be at least :min and a maximum of max characters',
    'title-good'=>'The page title has a good length',

    'url-good'=>'The main keywords in the URL are displayed for this tab.',
    'url-no-focal-keyword'=>'The focal keyword does not appear at the URL address of this tab. If you decide to rename this URL, make sure you give the old address 301 referrals.',

    //slug

    'slug-is-long'=>'The name of this sheet is a bit tall, think of it short.',

    //content

    'content-limit-char'=>'The text contains :number words. This is much less than the proposed amount of :min words. Add more content related to the topic.',
    'content-limit-char-up'=>'The text contains :number words. This value is greater than or equal to the suggested minimum of :min words.',
    'content-no-link'=>'No internal link will appear in this tab, add a few items as appropriate.',
    'content-follow-no-follow'=>'This page has :nofollow number of nofollowed links and :follow has normal internal link.',
    'content-no-photo'=>'There is no photo in this post. You might want to add a photo.',
    'content-photo-no-alt'=>'Some of the photos in this post do not have the alt attribute',
    'content-photo-alt-no-focal-keyword'=>'Alt attribute Some photos do not have a focal keyword',

    //description

    'description-is-focal-keyword'=>'The meta description contains the focal keyword.',
    'description-no-focal-keyword'=>'The description meta is specified, but does not include the focal keyword.',
    'description-no'=>"Description meta is not specified. Search engines will show part of the page's text instead.",
    'description-good-length'=>'The length of the meta description is sufficient.',
    'description-is-low'=>'Meta description length is low. Please use the text that relates to the content',
    'description-limit'=>'The length of the description meta can not exceed :max characters.'
];