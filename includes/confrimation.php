<script>
	$(document).ready(function () {
		$('.confirmation').on('click', function () {
			return confirm('Are you sure you want do delete this user?');
		})
	})
</script>
<script>
	window.setTimeout(function () {
		$("#updatedAlert, #deletedAlert, #insertedAlert, #errorAlert").fadeTo(500, 0).slideUp(500, function () {
			$(this).remove();
		});
	}, 3000);
</script>