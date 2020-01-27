@extends('layouts.default')

@section('main')

      <div class="container">
        <div class="row">
          <div class="col-md-2"><button onclick="javascript:(function(){sq=window.sq=window.sq||{};if(sq.script){sq.again();}else{sq.bookmarkletVersion='0.3.0';sq.iframeQueryParams={host:'//squirt.io',userId:'8a94e519-7e9a-4939-a023-593b24c64a2f',};sq.script=document.createElement('script');sq.script.src=sq.iframeQueryParams.host+'/bookmarklet/frame.outer.js';document.body.appendChild(sq.script);}})();" class="btn btn-sm btn-primary" style="position: relative;top: 20px;" id="squirt">Speed read this</a></div>
          <article id="theContent" class="article col-md-8">
            <h1>{{ $title }}</h1>
            <a href="{{ $permalink }}" class="perma" rel="bookmark">{{ $permalinkWithoutScheme }}</a>
            <hr>
            {!! $body !!}
          </article>
        </div> <!-- .row -->
      </div> <!-- .container -->
@stop

@section('footer')

        <hr>
        <small><em><b>Source:</b> <a href="http://nullrefer.com/?{{ $url }}">{{ $url }}</a></em></small>
        <hr>

        <p class="home"><a href="{{ ROOT_URL }}/" class="btn btn-primary" >What is {{ env('SITE_NAME') }}?</a></p>
@stop
