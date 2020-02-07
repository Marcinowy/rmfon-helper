<html><head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link href="style.css" rel="stylesheet" media="screen">
	<title>RMF ON</title>
</head><body><script src="/jquery-2.1.4.js" type="text/javascript"></script>
<script>
function add(station) {
	$("#fm_id").append("<option value=\""+station.id+"\">"+station.name+"</option>");
}
$(document).ready(function() {
	$.ajax({url: "list.php", success: function(result) {
		result.forEach(add);
		$("#loader_list").addClass("hide");
		$("#fm_id").removeClass("hide");
	},error: function() {
		$("#loader_list").html("Błąd podczas łączenia z serwerem");
	}});
	$("#fm_id").change(function() {
		$("#loader_station").removeClass("hide");
		$("#window").html("");
		$("#links").html("");
		$.ajax({url: "ajax.php?id="+$(this).val(), success: function(result) {
			$("#links").append("<h6>"+result.music+"</h6><h4>Linki do streamów:</h4>");
			for (id in result.streams) $("#links").append("<div><a href=\""+result.streams[id]+"\" target=\"_blank\">"+result.streams[id]+"</a></div>");
			for (id in result.yt) $("#window").append("<div><h2>"+result.yt[id].title+"</h2><img src=\""+result.yt[id].img+"\"><div>Długość: "+result.yt[id].time+"</div><div>"+result.yt[id].count+" wyświetleń</div><div><a href=\""+result.yt[id].url+"\" target=\"_blank\">"+result.yt[id].url+"</a></div>");
		},error: function() {
			$("#window").html("Błąd podczas łączenia z serwerem");
		},complete:function() {
			$("#loader_station").addClass("hide");
		}});
	});
});
</script>
<div class="center_div">
	<form id="form">
		<div class="form-group"><h1>Rmf on</h1></div>
		<div class="form-group" id="loader_list"><svg class="circle-loader" width="40" height="40" version="1.1" xmlns="http://www.w3.org/2000/svg"><circle cx="20" cy="20" r="15"></svg></div>
		<div class="form-group"><select id="fm_id" class="hide form-control"><option value="0">Wybierz radio</option></select></div>
		<div class="form-group hide" id="loader_station"><svg class="circle-loader" width="40" height="40" version="1.1" xmlns="http://www.w3.org/2000/svg"><circle cx="20" cy="20" r="15"></svg></div>
			<div class="form-group" id="links"></div>
	</form>
</div>
<div id="window"></div>
</body></html>