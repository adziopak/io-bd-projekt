$(document).ready(function() {
	$(document).on('click', '#add_floor', function() {
		$('#building_floors').append(`<div>
			<input type="number" value="" name="floor[]">
			<input type="file" value="" multiple name="image[]">
			<input class="remove_floor" type="button" value="Usuń">
			</div>`);
	});

	$(document).on('click', '.remove_floor', function() {
		$(this).parent().remove();
	});
});