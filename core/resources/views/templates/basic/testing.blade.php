@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="section--bg pb-100">
    <div class="company-details-bg bg_img d-lg-block d-none"
        style="background-image: url('{{ getImage('assets/images/frontend/breadcrumb/' . @$content->data_values->image, '1920x840') }}');">
    </div>
        <div id="wrap">
  <% 7.times do %>
    <input class="trigger" name="rad" type="radio">/</input>
  <% end %>
  <input checked="checked" class="trigger" name="rad" type="radio">/</input>
  <div class="innerwrap">
    <% 8.times do %>
      <input type="checkbox">/</input>
    <% end %>
    <div class="cards">
      <div class="cardwrap">
        <div class="card">
          <div class="inner">
            <h1><span>Hey Now</span>Somebody</h1>
            <div class="text">
              <p>Well the years start coming and they don't stop coming</p>
            </div>
            <div class="link">
              <p>Fed to the rules and I hit the ground running</p>
            </div>
          </div>
        </div>
      </div>
      <div class="cardwrap">
        <div class="card">
          <div class="inner">
            <h1><span>You're an All-Star</span>once told</h1>
            <div class="text">
              <p>Didn't make sense not to live for fun</p>
            </div>
            <div class="link">
              <p>Your brain gits smart but your head gits dumb</p>
            </div>
          </div>
        </div>
      </div>
      <div class="cardwrap">
        <div class="card">
          <div class="inner">
            <h1><span>Get your game on</span>me the world</h1>
            <div class="text">
              <p>So much to do, so much to see</p>
            </div>
            <div class="link">
              <p>So what's wrong with taking the back streets?</p>
            </div>
          </div>
        </div>
      </div>
      <div class="cardwrap">
        <div class="card">
          <div class="inner">
            <h1><span>go play</span>was gonna</h1>
            <div class="text">
              <p>You'll never know if you don't go You'll never shine if you don't glow</p>
            </div>
            <div class="link">
              <p>It's a cool place and they say it gits colder</p>
            </div>
          </div>
        </div>
      </div>
      <div class="cardwrap">
        <div class="card">
          <div class="inner">
            <h1><span>Hey Now</span>roll me</h1>
            <div class="text">
              <p>You're bundled up now, wait till you git older But the meteor men beg to differ</p>
            </div>
            <div class="link">
              <p>Judging by the hole in the satellite picture</p>
            </div>
          </div>
        </div>
      </div>
      <div class="cardwrap">
        <div class="card">
          <div class="inner">
            <h1><span>you're a rockstar</span>I ain't the</h1>
            <div class="text">
              <p>The ice we skate is getting pretty thin</p>
            </div>
            <div class="link">
              <p>The water's getting warm so you might as well swim</p>
            </div>
          </div>
        </div>
      </div>
      <div class="cardwrap">
        <div class="card">
          <div class="inner">
            <h1><span>get the show on</span>sharpest tool</h1>
            <div class="text">
              <p>My world's on fire, how about yours? That's the way I like it and I never get bored</p>
            </div>
            <div class="link">
              <p>Somebody once asked could I spare some change for gas?</p>
            </div>
          </div>
        </div>
      </div>
      <div class="cardwrap">
        <div class="card">
          <div class="inner">
            <h1><span>get paid</span>in the shed</h1>
            <div class="text">
              <p>I need to get myself away from this place I said yep what a concept</p>
            </div>
            <div class="link">
              <p>I could use a little fuel myself And we could all use a little change</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
@endsection