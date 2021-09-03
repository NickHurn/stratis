$.fn.postcodelookup = function(selectclass,fields) {
	var id = this.attr('id');
	var selid = id + '-sel';
	var lines = [];
	var d = [];
    this.addClass("postcode");
    this.after("<button type='button' id='"+id+"-btn' class='btn btn-sm btn-black mt-2' style='display:inline-block;margin-top:-2px'>Lookup</button><br/><select class='"+selectclass+"' id='"+id+"-sel'  style='display:none'></select>");

	var btnid = '#'+id+'-btn';

	$(btnid).click(function() {
		var selid = this.id.slice(0,-3) + 'sel';
		$('#'+selid).children().remove();
		var opts = '<option value="">Select an address...</option>';
		var house = $('#apply_houseNumber').val() ;
		var pcode = $('.postcode').val() ;

		$.ajax({
			method: "POST",
			url: '/postcode/lookup',
			data: { house: house, pcode: pcode }
		})

			.done(function( data ) {
				if (data.address == 'error'){
					alert ('We were unable to locate that address.');
				}
				d = JSON.parse(data.address);
				if(d.latitude)
				{
					var n = d.addresses.length;
					for (var i=0; i<n; i++)
					{
						lines = d.addresses[i].split(',');
						opts += '<option value="' + i + '">' + lines[0] + ' ' + lines[1] + ', ' + lines[5] + ', ' +lines[6] + '</option>';
					}
					$('#'+selid).append(opts);
					$('#'+selid).show();
					$('#'+selid).focus();
					$('#'+selid).blur(function() {
						$('#'+selid).hide();
					});
				}
			});

		$('#'+selid).change(function() {
			var row = $('#'+selid).val();
			lines = d.addresses[row].split(',');
			if(fields[0]) $('#'+fields[0]).val(lines[0].trim());
			if(fields[1]) $('#'+fields[1]).val(lines[1].trim());
			if(fields[2]) $('#'+fields[2]).val(lines[5].trim());
			if(fields[3]) $('#'+fields[3]).val(lines[6].trim());
			$('#'+selid).hide();
		});
	});
};


