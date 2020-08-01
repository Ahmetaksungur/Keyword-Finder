<?php
/*
Plugin Name: Aks Keyword Finder
Plugin URI: http://ahmetaksungur.com/
Description: Google finds the most search keywords
Version: 1.0
Author: Ahmet Aksungur
Author URI: http://ahmetaksungur.com/
License: MIT
*/
?>
<?php function aks_keyword_box() { $aks_type = ['page', 'post', 'aks_keyword'];
    foreach ($aks_type as $aks) {
        add_meta_box(
            'aks-keyword-box', 
            'Aks Keyword Finder', 
            'aks_keyword_finder_html',
            $aks
        );
    }
}
add_action('add_meta_boxes', 'aks_keyword_box');

function aks_keyword_finder_html($post) { ?>

<div class="aks-form-group">
<label class="aks-form-group-label" for="aks-keyword-finder">Keyword</label>
<input name="aks-keyword-finder" id="aks-keyword-finder" type="text" class="aks-form-group-input" data-keywords="" data-keywords-target=".aks-keyword-finder-output" placeholder="enter keywords" />
<div class="aks-form-group-">
<h3>Keyword output</h3>	
<p class="aks-keyword-finder-output"></p>	
</div>
</div>   

<style>
.aks-form-group {
  margin-bottom: 1.5rem;
}
.aks-form-group .aks-form-group-label {
  margin-bottom: 0.5rem;
  display: inline-block;
  font-size: 16px;
}
.aks-form-group .aks-form-group-input {
  display: block;
  background: transparent;
  border: 2px solid #e2e8f0;
  border-radius: 10px;
  padding: 0.5em 0.7em;
  outline: none;
  width: -webkit-fill-available;
  font-family: "Inter", sans-serif;
  font-size: 1rem;
}
.aks-form-group .aks-form-group-input:focus {
  border: 2px solid #7451ff;
}
	.aks-form-group-{
		    display: block;
    background: transparent;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 1rem 0.7rem;
    outline: none;
    width: -webkit-fill-available;
    font-family: "Inter", sans-serif;
    font-size: 1rem;
    margin-top: 1rem;
	}
	.aks-form-group- h3{
	 margin: 0;
    margin-bottom: .4rem;
	}
.aks-keyword-finder-output {
  font-size:16px;
	margin:0;
}
</style>
<script>
(function () {
  "use strict";
  var jQueryPlugin = (window.jQueryPlugin = function (ident, func) {
    return function (arg) {
      if (this.length > 1) {
        this.each(function () {
          var $this = $(this);

          if (!$this.data(ident)) {
            $this.data(ident, func($this, arg));
          }
        });

        return this;
      } else if (this.length === 1) {
        if (!this.data(ident)) {
          this.data(ident, func(this, arg));
        }

        return this.data(ident);
      }
    };
  });
})();

(function () {
  "use strict";
  function Keywords($root) {
  const element = $root;
  const keywords = $root.first("[data-keywords]");
  const keywords_target = keywords.attr("data-keywords-target");
function keywords_slugify(text) {
  return text
    .toString()
    .toLowerCase()
    .replace(/\s+/g, "+")
    .replace(/\-\-+/g, "+")
    .replace(/[\s_-]+/g, "+");
}

function keywords_output(text) {
  return text
    .toString()
    .toLowerCase()
    .replace(/,/g, ", ")
}	  
	  
keywords.keyup(function () {
    var slug = keywords_slugify($(this).val());
    $.ajax({
    type:"post",
    url:"https://api.bing.com/osjson.aspx?query="+ slug +"&JsonType=callback&JsonCallback=?",
    success: function(data) {	
	var output = keywords_output(data);
	$(keywords_target).text(output);     
     },
     dataType: 'jsonp',  
    });  
  
  })
  .keyup();

  }
  $.fn.Keywords = jQueryPlugin("Keywords", Keywords);
  $("[data-keywords]").Keywords();
})();

</script>
<?php } ?>
