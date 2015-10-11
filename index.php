<html>
<title>Where Should I Go?</title>
<head>
    
    <p style="display:inline; float: right;">(Enable pop-up windows)</p>
    <input type="image" src="Capture.PNG" alt="Submit" width="35" height="35" align="RIGHT" onclick="myFunction()"> 
    <script>
function myFunction() {
    alert("Where should I go is a simple and easy to use website that gives you a general idea of interesting landmarks near you. All you have to do is simply type in a location in the search bar or find it by zooming in on the map and the websie will show you markers on interesting sightseeing locations around there. The marks are inputed by people living around so some could be really interesting. Hovering over the mark will give you general info about it and if a picture is avaliable it will be shown to you too");
}
</script><center>
    
    <img src=text.png ></center>
    
    <p></p>
    
    <script src="http://maps.googleapis.com/maps/api/js"></script>
    <script>
    </script>
    <style>
        
        .formi{
            width: 250px;
            border: 1px;
        }
    
        form {
            float: left;
        }
        #googleMap {
            width:86.7%;
            height:810px;
            }
    </style>
</head>

<body background="go6o (2).png">
    
    <script>
				function initMap() {
					var myLatlng = new google.maps.LatLng(42.7340079,25.5881744,8.25);
					var mapOptions = {
					  zoom: 8,
					  center: myLatlng
					};
					
					var mapContainer = document.getElementById('googleMap');
					var map = new google.maps.Map(mapContainer, mapOptions);

					for(var k in db_info) {
						var obj = db_info[k];
						console.log(obj);
						var myLatLong = new google.maps.LatLng(obj.lat, obj.long);
						
						var marker = new google.maps.Marker({
							position: myLatLong,
							title: obj.desc
						});

						// To add the marker to the map, call setMap();
						marker.setMap(map);									
					}
				};
				
				google.maps.event.addDomListener(window, 'load', initMap);

			</script>
                    <form method="post" action="<?php $_PHP_SELF ?>">
                        <table class = "formi" width="10" border="0" cellspacing="1" cellpadding="2">
                        <tr>
                        <td width="250"><b>Longtitude</b></td>
                        </tr>
                        <tr>
                        <td>
                        <input name="log" type="text" id="log" class="input_">
                        </td>
                        </tr>
                        <tr> 
                            <td width="250"><b>Latitude</b></td>
                        </tr>
                        <tr>
                        <td>
                        <input name="lat" type="text" id="lat">
                        </td>
                        </tr>
                        <tr> 
                        <td width="250"><b>Description</b></td>
                        </tr>
                        <tr>
                        <td>
                        <input name="description" type="text" id="description">
                        </td>
                        </tr>
                        <tr>
                        <td width="250"> </td>
                        <td> </td>
                        </tr>
                        <tr>
                        <td width="250"> </td>
                        </tr>
                        <tr>
                        <td>
                            <input name="add" type="submit" id="add" value="Add Object">
                        </td>
                        </tr>
                        </table>
                    </form>
    <div align="right">
	<div id="googleMap"></div>
    </div>
    
    <?php
		$con = mysqli_connect("localhost:3306", "root", "", "objects");
		// Check connection
		if (mysqli_connect_errno())
		{
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

		$sql = "SELECT * FROM objects_position";
		$result = mysqli_query($con,$sql);

		/*
		int i;
		int a[2000];
		int sum = 0
		for (i = 0; i < 100; i++) }
			sum = sum + a[i];
		}
		*/
		/*
		$a = array(
			'orange' => 5,
			'lemon' => 4,
			0 => 7,
		);
		
		a['orange']
		a['lemon']
		a[0]
		*/
		// Associative array
		$db_row = mysqli_fetch_all($result, MYSQL_ASSOC);
		
		$arr = array();
		foreach($db_row as $row) {
			$obj = ['desc' => $row['description'], 'long' => $row['log'], 'lat' => $row['lat']];
			$arr[] = $obj;
		}
		
		$encoded = json_encode($arr);
		//var_dump($encoded);exit;
		// vzima informaciata ot bazata i q prashta na javascript-a
		echo "<script type='text/javascript'> var db_info = $encoded </script>";
 		
		//die();
		
		if(isset($_POST['add']))
			{
	
			if(! get_magic_quotes_gpc() )
			{
			   $log = addslashes ($_POST['log']);
			   $lat = addslashes ($_POST['lat']);
			}
			else
			{
			   $log = $_POST['log'];
			   $lat = $_POST['lat'];
			}
			$description = $_POST['description'];
						
			$sql = "INSERT INTO objects_position ".
				   "(log,lat, description) ".
				   "VALUES ".
				   "('$log','$lat','$description')";
			
			$retval = mysqli_query($con, $sql);
			if(! $retval )
			{
			  die('Could not enter data: ' . mysql_error());
			}
			echo "Entered data successfully\n";
			mysqli_close($con);
			}
			else
			{
			?>
			<?php
			}
			?>
			
</body>
</html>