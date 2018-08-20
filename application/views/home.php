<?php $this->load->view('common/header') ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <!--==========================
    Intro Section
    ============================-->
    <section id="intro" style="height: 350px;" class="slider-h" >
      <div class="intro-container" >
        <div id="introCarousel" class="carousel slider-h slide carousel-fade" data-ride="carousel" >

          <ol class="carousel-indicators"></ol>

          <div class="carousel-inner" role="listbox" id="slider-div" >

            <?php
            // echo "<pre>";
            // print_r($homeTweets);die;
            $sliderCounter=0;
            foreach ($homeTweets as $row) {
              ?>
              <div class="carousel-item <?= $sliderCounter == 0?'active':'' ?> slider-custom" >
                <div class="carousel-container">
                  <div class="carousel-content">
                    <h2><?= $row['username'] ?></h2>
                    <p><?= $row['tweet'] ?></p>
                    <?php
                    if(isset($row['link']))
                    {
                      ?>
                      <a href="<?= $row['link'] ?>" target="_blank" class="btn-get-started scrollto">Read More</a>

                      <?php
                    }
                    ?>
                  </div>
                </div>
              </div>
              <?php
              $sliderCounter++;
            }
            ?>
          </div>

          <a class="carousel-control-prev" href="#introCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon ion-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>

          <a class="carousel-control-next" href="#introCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon ion-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>

        </div>
        <div id='downloadDiv' style="height: 100px;">
        </div>
      </div>
    </section><!-- #intro -->

    <main id="main">

    <!--==========================
      Facts Section
      ============================-->
      <section id="facts"  class="wow fadeIn">
        <div class="container">
       
          <div class="row counters">

            <div class="col-lg-4 col-6 text-center">
              <span data-toggle="counter-up"><?= $this->session->tweets; ?></span>
              <p>Tweets</p>
            </div>

            <div class="col-lg-4 col-6 text-center">
              <span data-toggle="counter-up"><?= $this->session->followers; ?></span>
              <p>Followers</p>
            </div>

            <div class="col-lg-4 col-6 text-center">
              <span data-toggle="counter-up"><?= $this->session->following; ?></span>
              <p>Following</p>
            </div>

            <!-- <div class="col-lg-3 col-6 text-center">
              <span data-toggle="counter-up">18</span>
              <p>Hard Workers</p>
            </div> -->

          </div>

        </div>
      </section><!-- #facts -->



    <!--==========================
      Team Section
      ============================-->
      <section id="team">
        <div class="container">
          <div class="section-header wow fadeInUp">
            <h3>Followers</h3>
          </div>

          <div class="row">

            <?php
            foreach ($followers as $row) {
              ?>
              <div class="col-lg-3 col-md-6 wow fadeInUp">
                <div class="member" style="background;background-image: url(<?= $row['profilePic'] ?>);">
                  <div class="member-info">
                    <div class="member-info-content">
                      <h4><?= $row['name'] ?></h4>
                      <span><?= $row['screenName'] ?></span>
                    </div>
                  </div>
                </div>
              </div>
              <?php
            }
            ?>

          </div>
        </div>
      </section>
      <!-- #team -->

    </main>
    <?php $this->load->view('common/footer') ?>
    