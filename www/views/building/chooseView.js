var maps = ::JSMaps::;

function fillBuildingSelect()
{
	var buildings = [];
		for (var key in maps)
	{
		if (jQuery.inArray(maps[key].name, buildings) < 0)
		{
			buildings.push(maps[key].name);
		}
	}
		for (var key in buildings)
	{
		$('#buildingSelect').append('<option value="' + buildings[key] + 
			'">Budynek ' + buildings[key] + '</option>');
	
	}
		onBuildingSelectChange();
}

function onBuildingSelectChange()
{
	$('#floorSelect').empty();
	var value = $('#buildingSelect').val();
		for (var key in maps)
	{
		if (maps[key].name == value)
		{
			$('#floorSelect').append('<option value="' + maps[key].floor + 
				'">' + maps[key].floor + '</option>');
		}
	}
}

window.onload = fillBuildingSelect;