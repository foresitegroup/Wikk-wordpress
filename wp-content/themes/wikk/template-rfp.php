<?php
/* Template Name: RFP */

get_header();
?>

<div class="site-width">
  <?php
  if ( have_posts() ) :
  	while ( have_posts() ) : the_post();
      the_title('<h1 class="news-title">', '</h2>');
  	endwhile;
  endif;
  ?>
</div>

<div id="rfp-tabs">
  <div id="shadow"></div>

  <div class="site-width">
    <input id="tab-standard" type="radio" name="tabs" checked>
    <label for="tab-standard" class="rfp-tab">Standard RFP</label>
    <input id="tab-bollard" type="radio" name="tabs">
    <label for="tab-bollard" class="rfp-tab">Custom Bollard Request</label>

    <div id="content">
      <div id="content-standard">
        <h4>Thank you for choosing Wikk.</h4>
        Please submit your request for proposal below. If you have any questions, or should you wish to submit another way, do not hesitate to call us at <span class="redtext">877-421-9490</span>.
        
        <div class="content-two-col">
          <form action="<?php echo get_template_directory_uri(); ?>/form-standard.php" method="POST" id="standard" novalidate>
            <div>
              <h3>Contact Info</h3>

              <div class="two-col">
                <label>
                  First Name *<br>
                  <input type="text" name="firstname" placeholder="John" required>
                </label>

                <label>
                  Last Name *<br>
                  <input type="text" name="lastname" placeholder="Smith" required>
                </label>
              </div>

              <label>
                Company *<br>
                <input type="text" name="company" placeholder="Your Company, Inc." required>
              </label>

              <div class="two-col">
                <label>
                  Email *<br>
                  <input type="email" name="email" placeholder="jsmith@company.com" required>
                </label>

                <label>
                  Phone *<br>
                  <input type="tel" name="phone" placeholder="414-555-1212" required>
                </label>
              </div>

              <div class="two-col">
                <label class="address">
                  Street Address *<br>
                  <input type="text" name="address" placeholder="1234 N. Main St." required>
                </label>

                <label class="suite">
                  Suite #<br>
                  <input type="text" name="suite" placeholder="123">
                </label>
              </div>

              <div class="two-col">
                <label class="city">
                  City *<br>
                  <input type="text" name="city" placeholder="Your City" required>
                </label>

                <label class="state">
                  State *<br>
                  <input type="text" name="state" placeholder="Your State" required>
                </label>

                <label class="zip">
                  Zip Code *<br>
                  <input type="text" name="zip" placeholder="12345" required>
                </label>
              </div>

              <label>
                Country *<br>
                <input type="text" name="country" placeholder="Your Country" required>
              </label>

              <br><br>

              <h3>Project Info</h3>
              <label>
                Request Date<br>
                <input type="text" name="requestdate" id="standard-date" placeholder="MM/DD/YYYY">
              </label>

              <label>
                Name of Project<br>
                <input type="text" name="projectname" placeholder="Your Company, Inc.">
              </label>

              <label class="radio">
                Wikk to Respond Via:<br>
                <input type="radio" name="respond" value="Email" id="respond-email" checked>
                <label for="respond-email">Email</label>
                <input type="radio" name="respond" value="Phone" id="respond-phone">
                <label for="respond-phone">Phone</label>
              </label>

              <label class="radio">
                Customer Type:<br>
                <input type="radio" name="custtype" value="Architect" id="custtype-architect" checked>
                <label for="custtype-architect">Architect</label>
                <input type="radio" name="custtype" value="Specifying Engineer" id="custtype-engineer">
                <label for="custtype-engineer">Specifying Engineer</label>
                <input type="radio" name="custtype" value="Distributor" id="custtype-distributor">
                <label for="custtype-distributor">Distributor</label>
                <input type="radio" name="custtype" value="End User" id="custtype-user">
                <label for="custtype-user">End User</label>
                <input type="radio" name="custtype" value="Other" id="custtype-other">
                <label for="custtype-other">Other</label>
              </label>

              <input type="checkbox" name="sendupdates" value="Send updates" id="send-updates" checked>
              <label for="send-updates">Send me periodic updates and innovations from Wikk</label>

              <br>

              <h3>Product Info</h3>
              <label class="radio">
                Item #1<br>
                <input type="radio" name="item1" value="Bollard" id="item1-bollards" checked>
                <label for="item1-bollards">Bollard</label>
                <input type="radio" name="item1" value="INGRESS'R" id="item1-ingressr">
                <label for="item1-ingressr">INGRESS'R</label>
                <input type="radio" name="item1" value="Switch" id="item1-switches">
                <label for="item1-switches">Switch</label>
                <input type="radio" name="item1" value="Transmitter/Receiver" id="item1-transmitters-receivers">
                <label for="item1-transmitters-receivers">Transmitter/Receiver</label>
              </label>

              <label>
                Select Product
                <div class="select">
                  <select name="item1_product"></select>
                </div>
              </label>

              <label>
                Quantity<br>
                <input type="number" name="item1_quantity" placeholder="0">
              </label>

              <label class="radio">
                Item #2<br>
                <input type="radio" name="item2" value="Bollard" id="item2-bollards" checked>
                <label for="item2-bollards">Bollard</label>
                <input type="radio" name="item2" value="INGRESS'R" id="item2-ingressr">
                <label for="item2-ingressr">INGRESS'R</label>
                <input type="radio" name="item2" value="Switch" id="item2-switches">
                <label for="item2-switches">Switch</label>
                <input type="radio" name="item2" value="Transmitter/Receiver" id="item2-transmitters-receivers">
                <label for="item2-transmitters-receivers">Transmitter/Receiver</label>
              </label>

              <label>
                Select Product
                <div class="select">
                  <select name="item2_product"></select>
                </div>
              </label>

              <label>
                Quantity<br>
                <input type="number" name="item2_quantity" placeholder="0">
              </label>

              <label class="radio">
                Item #3<br>
                <input type="radio" name="item3" value="Bollard" id="item3-bollards" checked>
                <label for="item3-bollards">Bollard</label>
                <input type="radio" name="item3" value="INGRESS'R" id="item3-ingressr">
                <label for="item3-ingressr">INGRESS'R</label>
                <input type="radio" name="item3" value="Switch" id="item3-switches">
                <label for="item3-switches">Switch</label>
                <input type="radio" name="item3" value="Transmitter/Receiver" id="item3-transmitters-receivers">
                <label for="item3-transmitters-receivers">Transmitter/Receiver</label>
              </label>

              <label>
                Select Product
                <div class="select">
                  <select name="item3_product"></select>
                </div>
              </label>

              <label>
                Quantity<br>
                <input type="number" name="item3_quantity" placeholder="0">
              </label>

              <input id="item4-toggle" type="checkbox">
              <label for="item4-toggle">Add Another Item</label>
              <div>
                <label class="radio">
                  Item #4<br>
                  <input type="radio" name="item4" value="Bollard" id="item4-bollards" checked>
                  <label for="item4-bollards">Bollard</label>
                  <input type="radio" name="item4" value="INGRESS'R" id="item4-ingressr">
                  <label for="item4-ingressr">INGRESS'R</label>
                  <input type="radio" name="item4" value="Switch" id="item4-switches">
                  <label for="item4-switches">Switch</label>
                  <input type="radio" name="item4" value="Transmitter/Receiver" id="item4-transmitters-receivers">
                  <label for="item4-transmitters-receivers">Transmitter/Receiver</label>
                </label>

                <label>
                  Select Product
                  <div class="select">
                    <select name="item4_product"></select>
                  </div>
                </label>

                <label>
                  Quantity<br>
                  <input type="number" name="item4_quantity" placeholder="0">
                </label>
              </div>

              <input id="item5-toggle" type="checkbox">
              <label for="item5-toggle">Add Another Item</label>
              <div>
                <label class="radio">
                  Item #5<br>
                  <input type="radio" name="item5" value="Bollard" id="item5-bollards" checked>
                  <label for="item5-bollards">Bollard</label>
                  <input type="radio" name="item5" value="INGRESS'R" id="item5-ingressr">
                  <label for="item5-ingressr">INGRESS'R</label>
                  <input type="radio" name="item5" value="Switch" id="item5-switches">
                  <label for="item5-switches">Switch</label>
                  <input type="radio" name="item5" value="Transmitter/Receiver" id="item5-transmitters-receivers">
                  <label for="item5-transmitters-receivers">Transmitter/Receiver</label>
                </label>

                <label>
                  Select Product
                  <div class="select">
                    <select name="item5_product"></select>
                  </div>
                </label>

                <label>
                  Quantity<br>
                  <input type="number" name="item5_quantity" placeholder="0">
                </label>
              </div>

              <input id="item6-toggle" type="checkbox">
              <label for="item6-toggle">Add Another Item</label>
              <div>
                <label class="radio">
                  Item #6<br>
                  <input type="radio" name="item6" value="Bollard" id="item6-bollards" checked>
                  <label for="item6-bollards">Bollard</label>
                  <input type="radio" name="item6" value="INGRESS'R" id="item6-ingressr">
                  <label for="item6-ingressr">INGRESS'R</label>
                  <input type="radio" name="item6" value="Switch" id="item6-switches">
                  <label for="item6-switches">Switch</label>
                  <input type="radio" name="item6" value="Transmitter/Receiver" id="item6-transmitters-receivers">
                  <label for="item6-transmitters-receivers">Transmitter/Receiver</label>
                </label>

                <label>
                  Select Product
                  <div class="select">
                    <select name="item6_product"></select>
                  </div>
                </label>

                <label>
                  Quantity<br>
                  <input type="number" name="item6_quantity" placeholder="0">
                </label>
              </div>

              <br>
              <input type="submit" name="submit" value="Submit">
            </div>
          </form>

          <div class="rfp-sidebar">
            rfp sidebar
          </div>
        </div>
      </div> <!-- #content-standard -->

      <div id="content-bollard">
        <h4>Thank you for choosing Wikk.</h4>
        Please submit your request for proposal below. If you have any questions, or should you wish to submit another way, do not hesitate to call us at <span class="redtext">877-421-9490</span>.
        
        <div class="content-two-col">
          <form action="form-bollard.php" method="POST" id="bollard" novalidate>
            <div>
              <h3>Contact Info</h3>

              <div class="two-col">
                <label>
                  First Name *<br>
                  <input type="text" name="firstname" placeholder="John" required>
                </label>

                <label>
                  Last Name *<br>
                  <input type="text" name="lastname" placeholder="Smith" required>
                </label>
              </div>

              <label>
                Company *<br>
                <input type="text" name="company" placeholder="Your Company, Inc." required>
              </label>

              <div class="two-col">
                <label>
                  Email *<br>
                  <input type="email" name="email" placeholder="jsmith@company.com" required>
                </label>

                <label>
                  Phone *<br>
                  <input type="tel" name="phone" placeholder="414-555-1212" required>
                </label>
              </div>

              <div class="two-col">
                <label class="address">
                  Street Address *<br>
                  <input type="text" name="address" placeholder="1234 N. Main St." required>
                </label>

                <label class="suite">
                  Suite #<br>
                  <input type="text" name="suite" placeholder="123">
                </label>
              </div>

              <div class="two-col">
                <label class="city">
                  City *<br>
                  <input type="text" name="city" placeholder="Your City" required>
                </label>

                <label class="state">
                  State *<br>
                  <input type="text" name="state" placeholder="Your State" required>
                </label>

                <label class="zip">
                  Zip Code *<br>
                  <input type="text" name="zip" placeholder="12345" required>
                </label>
              </div>

              <label>
                Country *<br>
                <input type="text" name="country" placeholder="Your Country" required>
              </label>

              <br><br>

              <h3>Project Info</h3>
              <label>
                Request Date<br>
                <input type="text" name="requestdate" id="standard-date" placeholder="MM/DD/YYYY">
              </label><br>

              <label>
                Name of Project<br>
                <input type="text" name="projectname" placeholder="Your Company, Inc." >
              </label>

              <label class="radio">
                Wikk to Respond Via:<br>
                <input type="radio" name="respond" value="Email" id="respond-email" checked>
                <label for="respond-email">Email</label>
                <input type="radio" name="respond" value="Phone" id="respond-phone">
                <label for="respond-phone">Phone</label>
              </label>

              <label class="radio">
                Customer Type:<br>
                <input type="radio" name="custtype" value="Architect" id="custtype-architect" checked>
                <label for="custtype-architect">Architect</label>
                <input type="radio" name="custtype" value="Specifying Engineer" id="custtype-engineer">
                <label for="custtype-engineer">Specifying Engineer</label>
                <input type="radio" name="custtype" value="Distributor" id="custtype-distributor">
                <label for="custtype-distributor">Distributor</label>
                <input type="radio" name="custtype" value="End User" id="custtype-user">
                <label for="custtype-user">End User</label>
                <input type="radio" name="custtype" value="Other" id="custtype-other">
                <label for="custtype-other">Other</label>
              </label>

              <input type="checkbox" name="sendupdates" value="Send updates" id="send-updates" checked>
              <label for="send-updates">Send me periodic updates and innovations from Wikk</label>

              <br>

              <h3>Bollard Requests</h3>
              
              <input type="submit" name="submit" value="Submit">
            </div>
          </form>

          <div class="rfp-sidebar">
            bollard sidebar
          </div>
        </div>
      </div> <!-- #content-bollard -->
    </div> <!-- #content -->
  </div> <!-- .site-width -->
</div> <!-- #rfp-tabs -->

<div id="alert-modal" class="modal"><div></div></div>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/jquery-ui.min.css">
<script src="<?php echo get_template_directory_uri(); ?>/inc/jquery-ui.min.js"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/jquery.modal.css">
<script src="<?php echo get_template_directory_uri(); ?>/inc/jquery.modal.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    function RFPResize() { $('#shadow').css({ "top": $('.rfp-tab').innerHeight() }); }

    RFPResize();

    $(window).resize(function(){ setTimeout(function() { RFPResize(); },100); });

    $("#standard-date, #bollard-date").datepicker().attr("autocomplete", "off");

    var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';

    function LoadProducts(prodname) {
      var prodid = $(prodname).attr('name');

      var data = {
        action: 'get_products_by_ajax',
        prodcat: $(prodname).attr('id').slice(6)
      }

      $.post(ajaxurl, data, function(response) {
        $('select[name="'+prodid+'_product"]').html(response);
      });
    }

    $(document).on('change', 'input[name^="item"]', function() {
      LoadProducts($(this));
    });

    $('input[name^="item"]:checked').each(function(){
      LoadProducts('input[name="'+$(this).attr('name')+'"]');
    });

    $('#standard, #bollard').submit(function(event) {
      event.preventDefault();

      var form = '#'+$(this).attr('id');

      function formValidation() {
        var missing = 'no';

        $(form+' [required]').each(function(){
          if ($(this).val() === "") {
            $(this).addClass('alert').attr("placeholder", "REQUIRED");
            missing = 'yes';
          }
        });

        return (missing == 'no') ? true : false;
      }

      if (formValidation()) {
        $.ajax({
          type: 'POST',
          url: $(form).attr('action'),
          data: $(form).serialize()+'&src=ajax'
        })
        .done(function(response) {
          $('#alert-modal > DIV').html(response);
          $('#alert-modal').modal();

          $(form).find('input[type="text"], input[type="email"], input[type="tel"], input[type="number"], select').val('');
          $('#item1-bollards, #item2-bollards, #item3-bollards, #item4-bollards, #item5-bollards, #item6-bollards').prop('checked', true);
          $('#item4-toggle, #item5-toggle, #item6-toggle').prop('checked', false);
        })
      }
    });
  });
</script>

<?php
$FooterTextClass = "prefooter-hide";

get_footer();
?>