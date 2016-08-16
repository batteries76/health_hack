<?php
class find extends webpage {
	
	public function show_preload(){
		?>
<script>


</script>
		<?php
	}
	
	function distance($lat1, $lon1, $lat2, $lon2) {
	  $theta = $lon1 - $lon2;
	  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	  $dist = acos($dist);
	  $dist = rad2deg($dist);
	  $miles = $dist * 60 * 1.1515;
	  $unit = strtoupper($unit);
	  return ($miles * 1.609344);
	}
	
	public function showrating($score){
		if ($score<0.33)
			echo '<img src="\images\icons\favorite_empty.png" width="16px" height="16px">';
		elseif ($score<0.66)
			echo '<img src="\images\icons\favorite_half.png" width="16px" height="16px">';
		else
			echo '<img src="\images\icons\favorite_full.png" width="16px" height="16px">';
		if ($score<1.33)
			echo '<img src="\images\icons\favorite_empty.png" width="16px" height="16px">';
		elseif ($score<1.66)
			echo '<img src="\images\icons\favorite_half.png" width="16px" height="16px">';
		else
			echo '<img src="\images\icons\favorite_full.png" width="16px" height="16px">';
		if ($score<2.33)
			echo '<img src="\images\icons\favorite_empty.png" width="16px" height="16px">';
		elseif ($score<2.66)
			echo '<img src="\images\icons\favorite_half.png" width="16px" height="16px">';
		else
			echo '<img src="\images\icons\favorite_full.png" width="16px" height="16px">';
		if ($score<3.33)
			echo '<img src="\images\icons\favorite_empty.png" width="16px" height="16px">';
		elseif ($score<3.66)
			echo '<img src="\images\icons\favorite_half.png" width="16px" height="16px">';
		else
			echo '<img src="\images\icons\favorite_full.png" width="16px" height="16px">';
		if ($score<4.33)
			echo '<img src="\images\icons\favorite_empty.png" width="16px" height="16px">';
		elseif ($score<4.66)
			echo '<img src="\images\icons\favorite_half.png" width="16px" height="16px">';
		else
			echo '<img src="\images\icons\favorite_full.png" width="16px" height="16px">';
		
	}
	
	
	private function topBar(){
	}
	/*
	private function rg_spec($level){
		int red = 255; //i.e. FF
		int green = 0;
		int stepSize = 5;
		while(green < 255)
		{
			green += stepSize;
			if(green > 255) { green = 255; }
			output(red, green, 0); //assume output is function that takes RGB
		}
		while(red > 0)
		{
			red -= stepSize;
			if(red < 0) { red = 0; }
			output(red, green, 0); //assume output is function that takes RGB
		}
	}
	*/
	
	private function showAvalibility($spec_id){
		$avail[0] = 1;
		echo '<table>';
			echo '<tr>';
			echo '<td rowspan="2" style="padding-left:40px;">Availiblity (weeks) </td>';
			echo '<td style="width:32px;text-align:center;font-size:8px;">0-2</td>';
			echo '<td style="width:32px;text-align:center;font-size:8px;">2-4</td>';
			echo '<td style="width:32px;text-align:center;font-size:8px;">4-6</td>';
			echo '</tr>';
			echo '<tr>';
			
			echo '<td style="width:32px;height:16px;text-align:center;background-color:#FF0000;color:#fff">0</td>';
			echo '<td style="width:32px;height:16px;text-align:center;background-color:#669900;color:#fff">29</td>';
			echo '<td style="width:32px;height:16px;text-align:center;background-color:#00FF00;color:#fff">102</td>';
			echo '</tr>';
			echo '</table>';
	}
	
	
	private function sideBar(){
		echo  '<div class="nav">';
		echo '<div class="sidemenuheader">Search</div>';
		echo '<div class="sidemenu">';
		echo '<form method="POST">';
		$val ="";
		if (isset($_REQUEST['speciality']))
				$val = $_REQUEST['speciality'];
		echo '<input type="text" name="speciality" placeholder="Speciality" value="'.$val.'" style="width:258px;margin-bottom:12px;">';
		$val ="";
		if (isset($_REQUEST['location'])){
			$val = $_REQUEST['location'];
			$ta = explode(',',$val);
			$suburb = $this->db->get('postcode',array('suburb'=>$ta[0],'state'=>trim($ta[1])),true);
			if (isset($suburb['_id']))
				$val = ucwords(strtolower($suburb['suburb'])).', '.$suburb['state'];
		}
		echo '<input type="text" name="location" placeholder="Your Location" value="'.$val.'" style="width:258px;margin-bottom:12px;">';
		echo '<select name="distance"  placeholder="Distance" style="width:262px;margin-bottom:12px;">';
			echo '<option>Distance</option>';
			$options = $this->db->get('data_set',array('data_set'=>'DIST'));
			foreach ($options as $option)
				echo '<option value="'.$option['alt'].'">'.$option['display'].'</option>';
			echo '</select>';
		echo '<div style="margin-bottom:12px;">Ratings:</div>';
		echo '<table style="margin-left:12px;margin-bottom:12px;">';
		echo '<tr><td style="padding-right:24px;">Overall </td>';
			echo '<td><img onmouseover="startHoverStarRating(4,1)" onmouseout="stopHoverStarRating(4,1)" onclick="clickStarRating(4,1)" id="starRating_4_1" src="\images\icons\favorite_empty.png" width="16px" height="16px"></td>';
			echo '<td><img onmouseover="startHoverStarRating(4,2)" onmouseout="stopHoverStarRating(4,2)" onclick="clickStarRating(4,2)" id="starRating_4_2"  src="\images\icons\favorite_empty.png" width="16px" height="16px"></td>';
			echo '<td><img onmouseover="startHoverStarRating(4,3)" onmouseout="stopHoverStarRating(4,3)" onclick="clickStarRating(4,3)" id="starRating_4_3"  src="\images\icons\favorite_empty.png" width="16px" height="16px"></td>';
			echo '<td><img onmouseover="startHoverStarRating(4,4)" onmouseout="stopHoverStarRating(4,4)" onclick="clickStarRating(4,4)" id="starRating_4_4"  src="\images\icons\favorite_empty.png" width="16px" height="16px"></td>';
			echo '<td><img onmouseover="startHoverStarRating(4,5)" onmouseout="stopHoverStarRating(4,5)" onclick="clickStarRating(4,5)" id="starRating_4_5"  src="\images\icons\favorite_empty.png" width="16px" height="16px"></td>';
			echo '</tr>';
		echo '<tr><td style="padding-right:24px;">Bedside Manner </td>';
			echo '<td><img onmouseover="startHoverStarRating(1,1)" onmouseout="stopHoverStarRating(1,1)" onclick="clickStarRating(1,1)" id="starRating_1_1" src="\images\icons\favorite_empty.png" width="16px" height="16px"></td>';
			echo '<td><img onmouseover="startHoverStarRating(1,2)" onmouseout="stopHoverStarRating(1,2)" onclick="clickStarRating(1,2)" id="starRating_1_2"  src="\images\icons\favorite_empty.png" width="16px" height="16px"></td>';
			echo '<td><img onmouseover="startHoverStarRating(1,3)" onmouseout="stopHoverStarRating(1,3)" onclick="clickStarRating(1,3)" id="starRating_1_3"  src="\images\icons\favorite_empty.png" width="16px" height="16px"></td>';
			echo '<td><img onmouseover="startHoverStarRating(1,4)" onmouseout="stopHoverStarRating(1,4)" onclick="clickStarRating(1,4)" id="starRating_1_4"  src="\images\icons\favorite_empty.png" width="16px" height="16px"></td>';
			echo '<td><img onmouseover="startHoverStarRating(1,5)" onmouseout="stopHoverStarRating(1,5)" onclick="clickStarRating(1,5)" id="starRating_1_5"  src="\images\icons\favorite_empty.png" width="16px" height="16px"></td>';
			echo '</tr>';
		
		echo '<tr><td style="padding-right:24px;">Understandable Outcome </td>';
			echo '<td><img onmouseover="startHoverStarRating(2,1)" onmouseout="stopHoverStarRating(2,1)" onclick="clickStarRating(2,1)" id="starRating_2_1" src="\images\icons\favorite_empty.png" width="16px" height="16px"></td>';
			echo '<td><img onmouseover="startHoverStarRating(2,2)" onmouseout="stopHoverStarRating(2,2)" onclick="clickStarRating(2,2)" id="starRating_2_2"  src="\images\icons\favorite_empty.png" width="16px" height="16px"></td>';
			echo '<td><img onmouseover="startHoverStarRating(2,3)" onmouseout="stopHoverStarRating(2,3)" onclick="clickStarRating(2,3)" id="starRating_2_3"  src="\images\icons\favorite_empty.png" width="16px" height="16px"></td>';
			echo '<td><img onmouseover="startHoverStarRating(2,4)" onmouseout="stopHoverStarRating(2,4)" onclick="clickStarRating(2,4)" id="starRating_2_4"  src="\images\icons\favorite_empty.png" width="16px" height="16px"></td>';
			echo '<td><img onmouseover="startHoverStarRating(2,5)" onmouseout="stopHoverStarRating(2,5)" onclick="clickStarRating(2,5)" id="starRating_2_5"  src="\images\icons\favorite_empty.png" width="16px" height="16px"></td>';
			echo '</tr>';
		echo '<tr><td style="padding-right:24px;">Communication </td>';
			echo '<td><img onmouseover="startHoverStarRating(3,1)" onmouseout="stopHoverStarRating(3,1)" onclick="clickStarRating(3,1)" id="starRating_3_1" src="\images\icons\favorite_empty.png" width="16px" height="16px"></td>';
			echo '<td><img onmouseover="startHoverStarRating(3,2)" onmouseout="stopHoverStarRating(3,2)" onclick="clickStarRating(3,2)" id="starRating_3_2"  src="\images\icons\favorite_empty.png" width="16px" height="16px"></td>';
			echo '<td><img onmouseover="startHoverStarRating(3,3)" onmouseout="stopHoverStarRating(3,3)" onclick="clickStarRating(3,3)" id="starRating_3_3"  src="\images\icons\favorite_empty.png" width="16px" height="16px"></td>';
			echo '<td><img onmouseover="startHoverStarRating(3,4)" onmouseout="stopHoverStarRating(3,4)" onclick="clickStarRating(3,4)" id="starRating_3_4"  src="\images\icons\favorite_empty.png" width="16px" height="16px"></td>';
			echo '<td><img onmouseover="startHoverStarRating(3,5)" onmouseout="stopHoverStarRating(3,5)" onclick="clickStarRating(3,5)" id="starRating_3_5"  src="\images\icons\favorite_empty.png" width="16px" height="16px"></td>';
			echo '</tr>';
		echo '</table>';
		?>
<script>
function startHoverStarRating(group,star) {
	var textID, img;
	for (i = 1; i < (star+1); i++) { 
		textID = "starRating_" + group.toString()+"_"+i.toString();
		img = document.getElementById(textID);
		img.src = 'images/icons/favorite_full.png';
	}
	
}

function stopHoverStarRating(group,star) {
   var textID, img;
	for (i = 1; i < (star+1); i++) { 
		textID = "starRating_" + group.toString()+"_"+i.toString();
		img = document.getElementById(textID);
		img.src = 'images/icons/favorite_empty.png';
	}
}

function clickStarRating(group,star) {
	var textID, img;
	
	for (i = 1; i < (star+1); i++) { 
		textID = "starRating_" + group.toString()+"_"+i.toString();
		console.log(textID);
		img = document.getElementById(textID);
		img.src = 'images/icons/favorite_full.png';
	}
	
}

</script>
		<?php
		echo '<input type="text" placeholder="anything else" style="width:258px;margin-bottom:12px;">';
		echo '<input type="text" placeholder="anything else" style="width:258px;margin-bottom:12px;">';
		echo '<div style="text-align:right;padding-right:16px;"><input type="submit" value="Search"></div>';
		echo '</form>';
		echo '</div>';
		echo '</div>';
	}
	
	private function showResults(){
		$query = 'select * from specialist s where s.active_ind = 1';
		if (isset($_REQUEST['speciality']) && strlen($_REQUEST['speciality'])>1){
			$query .= ' and exists (select * from specialist_speciality ss, data_set ds where ss.specialist_id = s.specialist_id and ss.speciality = ds.data_set_id and ds.display = '."'".$_REQUEST['speciality']."'".' and ss.active_ind = 1 and ds.active_ind = 1)';
		}
		echo '<!-- '.$query.' -->';
		$specs = $this->db->query($query);
		echo '<table>';
		foreach ($specs as $spec){
			echo '<tr><td>';
			echo '<table>';
			echo '<tr><td>';
			echo '<img src="/images/faces/c'.str_pad((($spec['specialist_id']+10) % 91),2,'0',STR_PAD_LEFT).'.jpg" height="80" width="80">';
			echo '</td><td valign="top">';
			
			 
			echo '<table>';
			echo '<tr><td style="width:500px;"><span style="font-weight:bold;">'.$spec['title'] . ' ' . $spec['name_first'] . ' ' . $spec['name_last'] . '</span></td>';
			echo '<td>';
				$this->showrating((mt_rand ( 0 , 50)/10));
				echo '</td>';
			echo '<td>';
				$this->showAvalibility($spec['specialist_id']);
				echo '</td>';
			echo '</tr>';
			$specalities = $this->db->query('select * from specialist_speciality ss, data_set ds where ss.specialist_id = '. $spec['specialist_id'] . ' and ss.active_ind = 1 and ds.data_set_id = ss.speciality and ds.active_ind = 1');
			
			echo '<tr><td colspan="3">Specialities: ';
			$i=0;
			foreach ($specalities as $specality){
				if ($i>0)
					echo ', ';
				echo '<b>'.$specality['display'].'</b>';
				$i++;
			}
			echo '</td></tr>';
			echo '<tr><td colspan="3">Address: '. $spec['address'] . '</td></tr>';
			if (isset($_REQUEST['location'])){
				$ta = explode(',',$_REQUEST['location']);
				$suburb = $this->db->get('postcode',array('suburb'=>$ta[0],'state'=>trim($ta[1])),true);
				if (isset($suburb['_id']))
					echo '<tr><td colspan="3">Distance from you: '. floor($this->distance($suburb['latitude'],$suburb['longitude'],$spec['latitude'],$spec['longitude'])) . ' kms</td></tr>';
			}
			echo '</table>';
			
			
			echo '</td></tr>';
			echo '</table>';
			echo '</td></tr>';
		
		}
		echo '</table>';
	}
	
	private function showMap(){
		?>
<script src="underscore.js"></script>
<script src="app.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqrhf1TF4Jxf5sjLxk_aDtwWGLvMnb9RY&callback=initMap"></script>
		<?php
	}
	
	
	private function main(){
		echo '<div class="main">';
		
		
		echo '<ul class="tab">';
		echo '<li><a href="#" class="tablinks" onclick="'."openTab(event, 'Results')".'">Results</a></li>';
		echo '<li><a href="#" class="tablinks" onclick="'."openTab(event, 'Map')".'">Map</a></li>';
		echo '</ul>';
		
		echo '<div id="Results" class="tabcontent">';
		$this->showResults();
		echo '</div>';//ID RESULTS
		
		echo '<div id="Map" class="tabcontent">';
		echo '<h3>Map</h3>';
		$this->showMap();
		echo '</div>';//ID MAP
		
		?>
<script>
openTab("Results")
function openTab(evt, tabName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the link that opened the tab
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>
<script>
var mybtn = document.getElementsByClassName("tablinks")[0];
mybtn.click();
</script>


		<?php
		
		echo '</div>';//ID Main
	}
	
	
	
	public function show_body(){
		
		echo '<div class="container">';
		$this->sideBar();
		$this->main();
		
		
		echo '</div>';// ID Container
		
		
	}

}
?>
