<!--==========================
    Footer
    ============================-->

    <footer id="footer">
      <div class="container">
        <div class="credits" style="margin-top: 1%">
          By Rishi Ezhava
        </div>
      </div>
    </footer>
    <!-- #footer -->


    <!-- modal start -->

    <div class="modal fade" id="tweetModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Tweet</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form name="tweetForm" id="tweetForm" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="form-group">
                <label for="tweetText">Your Tweet</label>
                <textarea maxlength="140" required="" class="form-control" id="tweetText" name="tweetText" rows="4"></textarea>
              </div>
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="tweetImage">Upload Image (Only images and gifs)</label>
                    <input type="file" class="form-control-file" id="tweetImage" name="tweetImage">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card" style="border: unset;align-items: flex-end;">
                    <img class="card-img-top" style="height: 100px;width: 100px;" id="tagertImg" src="<?= base_url('assets/img/no-image.png') ?>" alt="Selected Image">
                  </div>
                </div>
              </div>
              <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- modal start -->


    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="<?= base_url('assets/') ?>lib/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/') ?>lib/jquery/jquery-migrate.min.js"></script>
    <script src="<?= base_url('assets/') ?>lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/') ?>lib/easing/easing.min.js"></script>
    <script src="<?= base_url('assets/') ?>lib/superfish/hoverIntent.js"></script>
    <script src="<?= base_url('assets/') ?>lib/superfish/superfish.min.js"></script>
    <script src="<?= base_url('assets/') ?>lib/wow/wow.min.js"></script>
    <script src="<?= base_url('assets/') ?>lib/waypoints/waypoints.min.js"></script>
    <script src="<?= base_url('assets/') ?>lib/counterup/counterup.min.js"></script>
    <script src="<?= base_url('assets/') ?>lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="<?= base_url('assets/') ?>lib/isotope/isotope.pkgd.min.js"></script>
    <script src="<?= base_url('assets/') ?>lib/lightbox/js/lightbox.min.js"></script>
    <script src="<?= base_url('assets/') ?>lib/touchSwipe/jquery.touchSwipe.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
    <!-- Contact Form JavaScript File -->
    <script src="<?= base_url('assets/') ?>contactform/contactform.js"></script>

    <!-- Template Main Javascript File -->
    <script src="<?= base_url('assets/') ?>js/main.js"></script>
    <script src="<?= base_url('assets/') ?>js/developer.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.5/dist/loadingoverlay.min.js"></script>

    <!-- autocomplete  -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- autocomplete  -->

  </body>
  </html>

  <script>
    $( document ).ready(function() {
      var pdf="pdf";
      var xml="xml";
      $("#searchName").autocomplete({
        source: function (request, response) {
          $.ajax({
            type: 'post',
            url: BASE_URL+"home/searchUser",
            data: {keyword: request.term},
            dataType: "json",
            success: function (data) {
              response($.map(data, function (item)
              {
                return{
                  label: item.screen_name,
                  value: item.name
                }
              }));
            }
          });
        },
        minLength: 2,
        select: function (event, ui) {
          var userName = ui.item.label;
          $('#searchName').val(userName);
          $('ui-id-1').css('display','none');

          $.ajax({
            type: 'post',
            url: BASE_URL+"home/getUserTweets",
            data: {searchedUsername: userName},
            dataType: "json",
            success: function (data) {
              $('#slider-div').html('');
              $('#downloadDiv').html('');
              $sliderCounter=0;      
              var appendingHtml="";
              $.each(data, function( index, value ) {
                var isActive='';
                if(index==0){
                  var isActive='active';
                }
                appendingHtml+= '<div class="carousel-item slider-custom '+isActive+' " >';
                appendingHtml+='<div class="carousel-container"><div class="carousel-content">';
                appendingHtml+='<h2>'+value.username+'</h2>';
                appendingHtml+='<p>'+value.tweet+'</p>';
                if(typeof(value.link) != "undefined" && value.link !== null)
                {
                  appendingHtml+='<a href="'+value.link+'" target="_blank" class="btn-get-started scrollto">Read More</a>';
                }
                appendingHtml+='</div></div></div>';
                $sliderCounter++;
              });
              $('#slider-div').html(appendingHtml);
              // var downloadHtml="<div id='downloadDiv'>";
              var downloadHtml='<div style="text-align:center;color:#fff;"><h4>Download '+userName+'\'s followers in following format</h4></div>';
              downloadHtml+='<div style="text-align:center" class="pb-2">';
              downloadHtml+='<a href="javascript:void(0)" onclick="downloadUserFollowers( \'' + userName + '\' , \'' + pdf + '\')" ><span class="pr-3">PDF</span></a>';
              downloadHtml+='<a href="javascript:void(0)" onclick="downloadUserFollowers( \'' + userName + '\' , \'' + xml + '\')" ><span class="pr-3">XML</span></a>';
              // downloadHtml+='<a href="javascript:void(0)" onclick="downloadUserFollowers( \'' + userName + '\' , \'' + pdf + '\')" ><span class="pr-3">Google sheet</span></a></div>';
              $('#downloadDiv').append(downloadHtml);
            }
          });
        }
      }).autocomplete("instance")._renderItem = function (ul, item) {
        var appendData = "<p>" + item.label + " </p>";

        return $("<li></li>")
        .data("item.autocomplete", item)
        .append(appendData)
        .appendTo(ul);
      };

    });

    
    function downloadUserTweets($name,$type)
    {
      $.ajax({
        type: 'post',
        url: BASE_URL+"home/downloadTweets",
        data: {'type': $type,'username':$name},
        xhrFields: {
          responseType: 'blob'
        },
        beforeSend: function(msg){
          $.LoadingOverlay("show");
        },
        success: function (blob) {
          // debugger; // 
          // console.log('success');
          // console.log(blob.size);
          var link=document.createElement('a');
          link.href=window.URL.createObjectURL(blob);
          link.download=$name+$.now() + "." + $type;
          link.click();
        },
        complete: function(){
          $.LoadingOverlay("hide");
        }
      });
    } 

    function downloadUserFollowers($name,$type)
    {
      $.ajax({
        type: 'post',
        url: BASE_URL+"home/downloadFollowers",
        data: {'type': $type,'username':$name },
        xhrFields: {
          responseType: 'blob'
        },
        beforeSend: function(msg){
          $.LoadingOverlay("show");
        },
        success: function (blob) {
          // console.log(blob);
          var link=document.createElement('a');
          link.href=window.URL.createObjectURL(blob);
          link.download=$name+$.now() + "." + $type;
          link.click();
        },
        complete: function(){
          $.LoadingOverlay("hide");
        }
      });
    }


    $("#tweetImage").change(function() {    
      var ext = $('#tweetImage').val().split('.').pop().toLowerCase();
      if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
        $("#tweetImage").val('');
        alert('invalid extension!');
        return;
      }
      else
      {
        if (this.files && this.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#tagertImg').attr('src', e.target.result);
          }
          reader.readAsDataURL(this.files[0]);
        }
      }
    });

    $( "#tweetForm" ).submit(function( event ) {
      event.preventDefault();
      var txt=$('#tweetText').val();
      var file_data = $('#tweetImage').prop('files')[0];   
      var form_data = new FormData();                  
      form_data.append('tweetImg', file_data);
      form_data.append('txt', txt);
      $.ajax({
       url: BASE_URL + "home/createTweet", 
       type: "POST",             
       data: form_data, 
       contentType: false,       
       cache: false,             
       processData:false,  
       beforeSend: function(msg){
        $.LoadingOverlay("show");
      },      
      success: function(data)   
      {
        data = JSON.parse(data);
				// location.reload(true);
				$('#tweetModal').modal('hide');
        $.alert({
          title: 'Success',
          content: data.msg,
      });
        // alert(data.msg);
				$('#tweetForm')[0].reset();
				$defaultImg=BASE_URL+"assets/img/no-image.png";
				$('#tagertImg').attr('src', $defaultImg);
			},
      complete: function(){
        $.LoadingOverlay("hide");
      }
    });
    });
    
  </script>

  