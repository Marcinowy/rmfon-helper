<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet" media="screen">
    <title>RMF ON</title>
</head>
<body>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
    <script defer src="script.js" type="text/javascript"></script>
    <div class="center_div">
        <form id="form" class="mb-0">
            <div class="form-group"><h1>RMF ON</h1></div>
            <div class="form-group" id="loader_list"><svg class="circle-loader" width="40" height="40" version="1.1" xmlns="http://www.w3.org/2000/svg"><circle cx="20" cy="20" r="15"></svg></div>
            <div class="form-group"><select id="fm_id" class="hide form-control"><option value="0">Wybierz radio</option></select></div>
            <div class="form-group hide" id="loader_station"><svg class="circle-loader" width="40" height="40" version="1.1" xmlns="http://www.w3.org/2000/svg"><circle cx="20" cy="20" r="15"></svg></div>
            <div class="text-center">
                <audio autoplay="true" id="audio" class="d-none" controls></audio>
            </div>
            <div class="form-group mt-3 mb-0" id="links"></div>
            <div class="text-danger" id="error-container"></div>
        </form>
    </div>
    <div id="window"></div>
</body></html>