@extends('layouts.default', ['page' => 'home'])

@section('main')

    <header class="article-running home-header">
      <div class="container">
        <div class="row">
          <div class="logo">
            {{ require_image( "assets/images/favicons/favicon.svg" ) }}
          </div>
          <div class="text">
            <h1>What is {{ env('SITE_NAME') }}?</h1>
            <p>{{ env('SITE_NAME') }} is a tool to escape linkbaits, trolls, idiots and asshats.</p>
          </div>
          <div class="donate">
            @include('partials.liberapay')
          </div>
        </div>
      </div>
    </header>

    <div class="container">
      <div class="row">
        <div class="col-md-10 col-lg-8">
          <p>This tool tries to capture the content of an article or blog post without passing on your visit as a page view. {{ env('SITE_NAME') }} also reads and displays (some) news articles otherwise only visible to "subscribers". Effectively this means that you're not paying with your attention or money, so you can <strong>read and share</strong> the idiocy that it contains.</p>

          <h2>FAQ</h2>
          <dl>
            <dt>Is this legal?</dt><dd>¯\_(ツ)_/¯</dd>
            <dt>Does it work with any website?</dt><dd>Certainly not.</dd>
            <dt>Do we track you?</dt><dd>Only through Google Analytics (and only if you approve).</dd>
            <dt>Is it open source?</dt><dd><a href="{{ env('GITHUB_URL') }}">Yes.</a></dd>
          </dl>

          <p>Enjoy literally not feeding the trolls!</p>

          <h2>Usage</h2>
          <p>Drag this button to your bookmarks bar to {{ env('SITE_NAME') }}ify any page:</p>
          <p><a href="javascript:window.location.href%3D%27{{ env('SITE_URL') }}%27%2Blocation.href%3B" class="btn btn-primary">{{ env('SITE_NAME') }} this!</a></p>

          <p class="manual-usage">Or just put <span class="thisurl">{{ env('SITE_URL') }}</span> in front of <span class="thaturl">http://</span>, like this:<br />
            <span class="thisurl">{{ env('SITE_URL') }}</span><span class="thaturl">http://idiot.blog.tro/ll</span></p>

          <h2>Top 5 URLs not visited</h2>
          @include('partials.urllist', ['list' => $topURLs])

          <h2>5 latest URLs not visited</h2>
          @include('partials.urllist', ['list' => $latestURLs])
        </div>
      </div>
    </div>
@stop
