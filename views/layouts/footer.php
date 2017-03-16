		  <footer class="col-md-12 col-sm-12 bg-danger footer">
            Copyright
          </footer>

          <div class="uploadedPhoto">
          </div>
    </body>


    <script type="text/javascript">
    	



    	
    	$(document).ready(function (e) {

    		function convertDate(date){
    			var d = new Date((+date) * 1000);
							date = [
							  d.getFullYear(),
							  ('0' + (d.getMonth() + 1)).slice(-2),
							  ('0' + d.getDate()).slice(-2)
							].join('-');
				return date;
    		}
    			
			$(':file').on('fileselect', function(event, numFiles, label) {
				$('.brows').html(label);
			 });

			$(document).on('click', '.close', function(){
        		$("#myAlert").alert("close");
    		});

		    $('#addPhotoForm').on('submit',(function(e) {
		        e.preventDefault();
		        var formData = new FormData($(this)[0]);
		        window.FFF = formData;
		        $.ajax({
		            type:'POST',
		            url: '/gal/addPhoto',
		            data:formData,
		            cache:false,
		            contentType: false,
		            processData: false,
		            success:function(data){
		            	console.log(data);
		                var dataFromPhp = JSON.parse(data);

		                if(dataFromPhp["error"] == 0){

			                var d = new Date((+dataFromPhp["date"]) * 1000);
							date = [
							  d.getFullYear(),
							  ('0' + (d.getMonth() + 1)).slice(-2),
							  ('0' + d.getDate()).slice(-2)
							].join('-');


			                var str = ':';
			                str += '<a class="btn btn-default el" href="#" title = "Удалить" data-id = "'+ dataFromPhp["id"]+'"><i class="glyphicon glyphicon-remove"></i></a>';
			                str += '<img src="' + dataFromPhp["path"] + '" width="' + dataFromPhp["widthS"] + '" height="' + dataFromPhp["heightS"] +'">';
			                str += '<p class="text-muted"> <ul style="list-style-type: none !important; text-align: left;"><li><b>Date:</b> ' + date + '</li><li><b>Size:</b> ' + dataFromPhp["size"] + ' mB</li></ul></p>';
			                str += '<form class="descr" action="" method="post"><input type="text" name="ida" value="'+ dataFromPhp["id"] +'"  style="display: none;" ><input type="text" name="desc" value="' + dataFromPhp["description"] +'" class = "inDescr"><input type="submit" name="ok" value="edit" class="submit"></form>';

			                var newDiv = $('<div class="photoB">').html(str);
			                $('.alert').html('<div class="alert alert-success alert-dismissible" id="myAlert"><a href="#" class="close">&times;</a><strong>Success!</strong> '+ dataFromPhp["text"]+'</div>');
							$('.allPhotoContainer').append(newDiv);

						}else{
							var error = dataFromPhp;
							$('.alert').html('<div class="alert alert-danger alert-dismissible" id="myAlert"><a href="#" class="close">&times;</a><strong>Error!</strong> '+ error +'</div>');
						}


		            },
		            error: function(data){
		                console.log("error");
		                console.log(data);
		            }
		        });
		    }));


		    $(document).on('click', '.el', function(event) {
				event.stopPropagation();
				event.preventDefault();
				var id = $(this).attr("data-id");
				var path = $(this).parent().find('img').attr('src');
				var lastThis = this;
				$.ajax({
		            type:'POST',
		            url: '/gal/deletePhoto/'+id,
		            data:{path:path},
		            cache:false,
		            success:function(data){
		        		$(lastThis).parent().remove();
		        		$('.alert').html('<div class="alert alert-success alert-dismissible" id="myAlert"><a href="#" class="close">&times;</a><strong>Success!</strong> '+ data +'</div>');
					},
				});
			});

		    $(document).on('click','.pagination li a',function(e){
                    e.preventDefault();
                    var link = $(this).attr("href");
                    var page = link.replace(/\/gal\/page-([0-9]+)/,'$1');
                    var photoContainer = $('.allPhotoContainer');
                    var paginate = $('.paginate');
                    $.ajax({
                        type:'POST',
                        url: "/gal/page-"+page,
                        data:'',
                        cache:false,
                        contentType: false,
                        processData: false,
                        success:function(data){
                            console.log(data);
                            var photos = JSON.parse(data);
                            var str = '<div class="bigPhoto" title="Click to close"></div>';
                            for(i = 0; i < photos['count']; i++){
	                            str += '<div class="photoB">';
				                str += '<a class="btn btn-default el" href="#" title = "Удалить" data-id = "'+ photos[i]["id"]+'"><i class="glyphicon glyphicon-remove"></i></a>';
				                str += '<img src="' + photos[i]["name"] + '" width="' + photos[i]["widthS"] + '" height="' + photos[i]["heightS"] +'">';
				                str += '<p class="text-muted"> <ul style="list-style-type: none !important; text-align: left;"><li><b>Date:</b> ' + photos[i]["date"] + '</li><li><b>Size:</b> ' + photos[i]["size"] + ' mB</li></ul></p>';
				                str += '<form class="descr" action="" method="post"><input type="text" name="ida" value="'+ photos[i]["id"] +'"  style="display: none;" ><input type="text" name="desc" value="' + photos[i]["description"] +'" class = "inDescr"><input type="submit" name="ok" value="edit" class="submit"></form>';
				                str += '</div>'
                            }
                            
                            photoContainer.html(str);
                            paginate.html(photos['paginator']);
                        },
                        error: function(data){
                            console.log("error");
                            console.log(data);
                        }
                    });

                    return false;
                });

	    	return false;
		});



    </script>

</html>