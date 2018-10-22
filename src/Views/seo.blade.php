<div id="show_seo_analize">
    {!! $seoChecker !!}

</div>

    <script>

        @foreach($elements as $key=>$val)
            @if(is_array($val))
            @else
                document.getElementById("{{$val}}").addEventListener("focusout", sendCheckSeo,false);
            @endif
        @endforeach

        function slugify(text)
        {
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')           // Replace spaces with -
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                .replace(/^-+/, '')             // Trim - from start of text
                .replace(/-+$/, '');            // Trim - from end of text
        }

        function sendCheckSeo() {
            $data='?';
            $data+="model_name={{$model}}&";
            $data+="_token={{csrf_token()}}&";
            $data+="model_id={{$model_id}}&";


            @foreach($elements as $key=>$val)
                    @if(is_array($val))
                        var a=escape({!! $val[1] !!});
                        $data+="{{$key}}="+a+"&";
                    @else
                        @if($key=='slug')
                            $data+="{{$key}}="+window.location.protocol+"//"+window.location.hostname+'/'+slugify(document.getElementById("{{$val}}").value)+"&";
                        @else
                            $data+="{{$key}}="+document.getElementById("{{$val}}").value+"&";
                        @endif

                    @endif
            @endforeach

            document.getElementById("show_seo_analize").innerHTML ='pleas wait ...';
            var xhttp;
            xhttp=new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("show_seo_analize").innerHTML =
                        xhttp.responseText;
                }
            };
            xhttp.open("POST", '{{route('seochecker.ajax')}}'+$data, true);
            xhttp.send($data);
        }

    </script>

