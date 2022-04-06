<div class="full-screen-loader">
	<div class="loader-container">
		<div class="loader">
			<span class="load load1"></span>
			<span class="load load2"></span>
			<span class="text">Loading</span>
		</div>
	</div>
</div>
<script src="../js/jquery.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/sweetalert.min.js"></script>
<script src="js/script.js"></script>
<script>
    <?php if(isset($deleteData)){ if($deleteData){ ?>
    sAlert("Item has been deleted.", "Deleted", "success");
    <?php } } ?>
</script>