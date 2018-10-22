{{trans("SeoChecker::seoChecker.seo-status")}} ::
<div class=" label
@if($seo_status==\Laravelcity\SeoChecker\Lib\SeoStatus::BAD) label-danger
@elseif($seo_status==\Laravelcity\SeoChecker\Lib\SeoStatus::NORMAL) label-warning
@else label-success
@endif
        ">{{trans("SeoChecker::seoChecker.$seo_status")}}</div>
<hr>
@if(isset($title))
<div style="    background: #fff;
    border-bottom: 2px solid #eee;
    padding: 10px;
    direction: ltr;
    font-size: 12px;
    margin-bottom: 14px;
    margin-top: -10px;">
    <p id="g_seo_title" style="color: blue;font-weight: bold">{{@$title}}</p>
    <a href="{{@$url}}" style="color: green;margin-top: -10px;display: block">{{$url}}</a>
    <p id="g_seo_description" style="color: #aaa;font-size: 10px">{{@$description}}</p>
</div>
@endif
@foreach($messages as $mesage=>$keys)
    <p style="font-size: 12px;"><span style="display: inline-block;width: 10px;height: 10px;margin-left: 5px;border-radius: 50%"  class="label label-{{$keys['label']}}">&nbsp;</span>
        {{$keys['msg']}}
    </p>
@endforeach
