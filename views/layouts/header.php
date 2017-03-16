<!DOCTYPE html>
<html>
    <head>
	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	  <title>photogallery</title>
	  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	  <link href="./template/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
	  <link href="./template/css/mCss.css" rel="stylesheet" type="text/css">
	  <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
    		<script type="text/javascript">

				$(function(){

					 $(document).on('change', ':file', function() {
		    			var input = $(this),
		       			 numFiles = input.get(0).files ? input.get(0).files.length : 1,
		        		label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		    			input.trigger('fileselect', [numFiles, label]);
					});

					$(document).on('click', '.photoB', function() {
						var src = $(this).find('img').attr('src');
						$('.bigPhoto').html('<img src="' + src + '">');
						$('.bigPhoto').addClass('is-open');
					})

					$(document).on('click', '.inDescr', function(event) {
						event.stopPropagation();
					})

					/*$(document).on('click', '.sortSub', function(event) {
						event.preventDefault();
						var msg = $('#sort').serialize();
				        $.ajax({
				          type: 'POST',
				          url: '/',
				          data: msg,
				          success: function(data) {
				            alert('zbs');
				          },
				          error:  function(xhr, str){
					   		 alert('Возникла ошибка: ' + xhr.responseCode);
				          }
				        });
					})*/


					$(document).on('click', '.submit', function(event) {
						event.preventDefault();
						event.stopPropagation();
						var formd = $(this).parent();
						var msg = formd.serialize();
						var id = $(this).parent().parent().find('a').attr('data-id');
				        $.ajax({
				          type: 'POST',
				          url: '/gal/editDescr/'+id,
				          data: msg,
				          success: function(data) {
				            $('.alert').html('<div class="alert alert-success alert-dismissible" id="myAlert"><a href="#" class="close">&times;</a><strong>Success!</strong> '+ data +'</div>');
				          },
				          error:  function(xhr, str){
					   		 alert('Возникла ошибка: ' + xhr.responseCode);
				          }
				        });
					})

					$(document).on('click', '.bigPhoto', function() {
						$(this).html('');
						$(this).removeClass('is-open');
					})
				});
    		</script>
          <header>
              <div class="col-md-12 bg-primary">
              	<h1>Photogallery</h1>
              </div>
          </header>