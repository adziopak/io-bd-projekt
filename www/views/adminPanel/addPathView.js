var first_id = 0;
var second_id = 0;

$(".pin").click(function() {
	$("#" + first_id).attr("fill", "red");
	$("#" + second_id).attr("fill", "red");
	first_id = second_id;
	second_id= $(this).attr("id");
	$("#first").val(first_id);
	$("#second").val(second_id);
	$("#" + first_id).attr("fill", "lime");
	$("#" + second_id).attr("fill", "lime");
});