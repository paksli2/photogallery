<?php include ROOT.'/views/layouts/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-md-3 text" style="background-color:#e3e6e6; padding-bottom: 10px;">
        	<form action="#" method="post" enctype="multipart/form-data" id = "addPhotoForm">
    			<h2>Upload your photo:</h2><br>
                <label class="btn btn-primary btn-file ">
    			     Browse<input type = "file" name="file" style="display: none;" required>
                </label>
                <span class="brows btn btn-default">...</span>
                <br>
                <div calss = "form-group">
                    <label for="description">Description:</label>
        			<textarea class = "form-control" name = "description" required rows = "3" id = "description"></textarea>
                </div><br>
    			<input type="submit" class="btn btn-success" name="photo" value = "Add photo">
    		</form>
        </div>
        <div class="col-xs-12 col-md-7 allPhotoContainer" style="background-color: #d7d7da; padding: 10px;">
        <!-- Big photo container -->
        	<div class="bigPhoto" title="Click to close">
                
            </div>
                <?php foreach($photos as $photo){?>
            		<div class = "photoB">
            			<a class="btn btn-default el" href="#" title = "Удалить" data-id="<?php echo $photo['id'];?>"><i class="glyphicon glyphicon-remove"></i></a>
            			<img src = "<?php echo $photo['name'];?>" width = "<?php echo $photo['widthS']; ?>" height= "<?php echo $photo['heightS']; ?>" >
            			<p class="text-muted">
                            <ul style="list-style-type: none !important; text-align: left;">
                                <li><b>Date:</b> <?php echo $photo['date']; ?></li>
                                <li><b>Size:</b> <?php echo $photo['size']; ?> mB</li>
                            </ul>     
                        </p>
                        <form class="descr" action="" method="post">
            			     <input type="text" name="desc" value="<?php echo $photo['description'];?>" class = "inDescr">
                             <input type="submit" name="ok" value="edit" class="submit">
                        </form>
            		</div>
                <?php }?>
        </div>
        
        <div class="col-xs-12 col-md-2 " style="background-color: #f5f8f9; padding: 10px;">
        	<!-- <form action="" method="post" id = "sort">
                <p><b>Выберите тип сортировки:</b></p>
                <select name="typesort">
                    <option value="date">По дате</option>
                    <option value="size">По размеру</option>
                </select><br><br>
                <input type="submit" name="okSort" value="Сортировать">
            </form> -->
        </div>
        <div class="col-md-3 col-xs-12"></div>
        <div class="col-md-7 col-xs-12 paginate">
            <?php echo $pagination->get(); ?>
        </div>
        <div class="col-md-2 col-xs-12"></div>
    </div>
    <div class="alert col-xs-12 col-md-12">
        
    </div>
</div>
<?php include ROOT.'/views/layouts/footer.php'; ?>