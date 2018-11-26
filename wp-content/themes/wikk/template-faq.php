<?php
/* Template Name: FAQ */

get_header();
?>

<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery("dd").hide();

    jQuery("dl dt").click(function(){
      $(this).toggleClass('show');
      jQuery(this).next('dd').slideToggle();
      return false;
    });
  });
</script>

<div class="site-width page-content faq-content">
  <?php
  // if ( have_posts() ) :
  // 	while ( have_posts() ) : the_post();
  //     the_title('<h1 class="page-title">', '</h2>');
  // 		the_content();
  // 	endwhile;
  // endif;
  ?>
  <dl>
  <dt>Can you mount a.....to a bollard?</dt>
  <dd>
    We have been mounting application specific devices to bollards since 1980 and we pride ourselves on the limitless number of solutions we have designed and developed with our customers.  We are confident we can help you with your custom bollard needs and we often provide some expertise along the way to take the risk out of your hands.
  </dd>
</dl>
<dl>
  <dt>What are your lead-times?</dt>
  <dd>
    Our key suppliers are within an hour of our Milwaukee based manufacturing facility and work closely with us to deliver high quality products, on-time, and made with the same attention to detail as we expect.

    <strong>Bollards</strong>
    <ul class="nobullets">
      <li>Standard - ship in 48 hours or less</li>
      <li>Custom - contingent on design complexity, but we will provide <strong>guaranteed</strong> delivery dates once we complete the design together</li>
    </ul>

    <strong>INGRESS'R</strong> - ship in 48 hours or less

    <strong>Switches</strong> - ship in 48 hours or less
  </dd>
</dl>
<dl>
  <dt>How quickly can you provide me with engineering drawings?</dt>
  <dd>
    Our in-house design engineering team can deliver project specific engineered drawings in 48 hours or less.  We also maintain an engineered drawing database of over 100,000 projects that we can reference and customize to your needs.
  </dd>
</dl>
<dl>
  <dt>Who do I contact for technical support?</dt>
  <dd>
    <a href="mailto:engineering@wikk.com">engineering@wikk.com</a> or 877-491-9490
  </dd>
</dl>
<dl>
  <dt>How do I place an order with you?</dt>
  <dd>
    <a href="mailto:customerservice@wikk.com">customerservice@wikk.com</a> or 877-491-9490
  </dd>
</dl>
<dl>
  <dt>Is there a way to get my product faster?</dt>
  <dd>
    We offer an expedite service that includes a minimal fee for solutions required outside of our published lead-time window.
  </dd>
</dl>
<dl>
  <dt>Do all your solutions meet ADA compliance and California code, section 1117B.6?</dt>
  <dd>
    All of our products meet and often exceed compliance requirements for the industry.
  </dd>
</dl>
<dl>
  <dt>Who is my salesperson?</dt>
  <dd>
    [LINK TO CONTACT PAGE -- NEED SOME ACTUAL TEXT TO LINK FROM]
  </dd>
</dl>
<dl>
  <dt>Why should I buy from Wikk?</dt>
  <dd>
    We have been serving the needs of the accessibility industry since 1980, are privately held with solutions designed and manufactured in the USA, and have been an industry leader in innovation with several patents to our name.  Our "customer first" philosophy empowers every member of the company to make decisions immediately.  Give us a chance to show you what we can do.
  </dd>
</dl>
<dl>
  <dt>Who is the president of the company and how can I reach him?</dt>
  <dd>
    [LINK TO CONTACT PAGE -- NEED SOME ACTUAL TEXT TO LINK FROM]
  </dd>
</dl>
</div>

<?php
$FooterTextClass = "faq-prefooter";
$FooterText = "Have other questions?";

get_footer();
?>