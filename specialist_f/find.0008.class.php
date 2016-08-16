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
	
	private function rg_spec($level){
		if ($level > 20)
			return '1AAF5D';
		if ($level > 5)
			return 'E87E04';
		return 'EA4B35';
	}
	
	private function getSlots($spec_id){
		$url = 'https://lorenzofhir.healthhost.net/api/appointmentslots?specialityCode=40&postcode=2075';
	
		$spec = $this->db->get('specialist',array('specialist_id'=>$spec_id),true);
		$avail[0] = $spec['avail_1'];
		$avail[1] = $spec['avail_2'];
		$avail[2] = $spec['avail_3'];
		return $avail;
	}
	
	
	private function showAvalibility($spec_id){
		$avail = $this->getSlots($spec_id);
		echo '<table>';
			echo '<tr>';
			echo '<td rowspan="2" style="padding-left:40px;">Availability </td>';
			echo '<td style="width:32px;text-align:center;font-size:10px;">0-2</td>';
			echo '<td style="width:32px;text-align:center;font-size:10px;">2-4</td>';
			echo '<td style="width:32px;text-align:center;font-size:10px;">4-6</td>';
			echo '</tr>';
			echo '<tr>';
			
			
			echo '<td style="width:32px;height:16px;text-align:center;background-color:#'.$this->rg_spec($avail[0]).';color:#fff">'.$avail[0].'</td>';
			echo '<td style="width:32px;height:16px;text-align:center;background-color:#'.$this->rg_spec($avail[1]).';color:#fff">'.$avail[1].'</td>';
			echo '<td style="width:32px;height:16px;text-align:center;background-color:#'.$this->rg_spec($avail[2]).';color:#fff">'.$avail[2].'</td>';
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
		echo '<select name="speciality" style="width:258px;margin-bottom:12px;">';
			echo '<option value="All">All</option>';
		$specs = $this->db->get('data_set',array('data_set'=>'SPEC'),false,array('display'=>'ASC'));
		foreach ($specs as $spec){
			$sel = '';
			if (isset($_REQUEST['speciality']) && $_REQUEST['speciality'] == $spec['display'])
				$sel = ' SELECTED ';
			echo '<option value="'.$spec['display'].'" '.$sel.'>'.$spec['display'].'</option>';
		}
		echo '</select>';
		$val ="";
		if (isset($_REQUEST['location'])){
			$val = $_REQUEST['location'];
			$ta = explode(',',$val);
			$suburb = $this->db->get('postcode',array('suburb'=>$ta[0],'state'=>trim($ta[1])),true);
			if (isset($suburb['_id']))
				$val = ucwords(strtolower($suburb['suburb'])).', '.$suburb['state'];
		}
		//echo '<input type="text" name="location" placeholder="Your Location" value="'.$val.'" style="width:258px;margin-bottom:12px;">';
		echo '<select name="location" style="width:262px;margin-bottom:12px;">';
			$suburbs = $this->db->get('postcode',array(),false,array('suburb'=>'asc'));
			echo '<option>Select Your Location</option>';
			foreach ($suburbs as $suburb){
				$sel = '';
				if (isset($_REQUEST['location']) && $_REQUEST['location'] == (ucwords(strtolower($suburb['suburb'])).', '.$suburb['state']))
					$sel = ' SELECTED ';
				echo '<option value="'.ucwords(strtolower($suburb['suburb'])).', '.$suburb['state'].'"  '.$sel.'>'.ucwords(strtolower($suburb['suburb'])).', '.$suburb['state'].'</option>';
			}
			echo '</select>';
		
		
		echo '<select name="distance"  placeholder="Distance" style="width:262px;margin-bottom:12px;">';
			echo '<option value="999999">Distance</option>';
			$options = $this->db->get('data_set',array('data_set'=>'DIST'));
			foreach ($options as $option)		{
				$sel = '';
				if (isset($_REQUEST['distance']) && $_REQUEST['distance'] == $option['alt'])
					$sel = ' SELECTED ';
				echo '<option value="'.$option['alt'].'" '.$sel.'>'.$option['display'].'</option>';
			}
			echo '</select>';
			
		echo '<select name="avail_appt" style="width:262px;margin-bottom:12px;">';
			echo '<option value="999">Available Appointments Within</option>';
			$sel = '';
			if (isset($_REQUEST['avail_appt']) && $_REQUEST['avail_appt'] == '2')
				$sel = ' SELECTED ';
			echo '<option value="2" '.$sel.'>2 Weeks</option>';
			$sel = '';
			if (isset($_REQUEST['avail_appt']) && $_REQUEST['avail_appt'] == '4')
				$sel = ' SELECTED ';
			echo '<option value="4" '.$sel.'>4 Weeks</option>';
			$sel = '';
			if (isset($_REQUEST['avail_appt']) && $_REQUEST['avail_appt'] == '6')
				$sel = ' SELECTED ';
			echo '<option value="6" '.$sel.'>6 Weeks</option>';
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
		echo '<div style="text-align:right;padding-right:16px;"><input type="submit" value="Search"></div>';
		echo '</form>';
		echo '</div>';
		echo '</div>';
	}
	
	private function showResults(){
		$query = 'select * from specialist s where s.active_ind = 1';
		if (isset($_REQUEST['speciality']) && strlen($_REQUEST['speciality'])>1 && $_REQUEST['speciality'] != 'All'){
			$query .= ' and exists (select * from specialist_speciality ss, data_set ds where ss.specialist_id = s.specialist_id and ss.speciality = ds.data_set_id and ds.display = '."'".$_REQUEST['speciality']."'".' and ss.active_ind = 1 and ds.active_ind = 1)';
		}
		
		if (isset ($_REQUEST['avail_appt']) && $_REQUEST['avail_appt'] < 3){
			$query .= ' and  s.avail_1 > 0 ';
		}elseif (isset ($_REQUEST['avail_appt']) && $_REQUEST['avail_appt'] < 5){
			$query .= ' and  (s.avail_1 > 0 || s.avail_2 > 0) ';
		}elseif (isset ($_REQUEST['avail_appt']) && $_REQUEST['avail_appt'] < 7){
			$query .= ' and  (s.avail_1 > 0 || s.avail_2 > 0  || s.avail_3 > 0) ';
		}
		echo '<!-- '.$query.' -->';
		$specs = $this->db->query($query);
		echo '<table>';
		foreach ($specs as $spec){
			
			
			
			$dist_away = 999999;
			if (isset($_REQUEST['location'])){
				$ta = explode(',',$_REQUEST['location']);
				$suburb = $this->db->get('postcode',array('suburb'=>$ta[0],'state'=>trim($ta[1])),true);
				if (isset($suburb['_id']))
					$dist_away = floor($this->distance($suburb['latitude'],$suburb['longitude'],$spec['latitude'],$spec['longitude']));
			}
			
			
			$show = true;
			
			if ($dist_away > 0 && $dist_away < 999){
					if (isset($_REQUEST['distance']) && $_REQUEST['distance'] > 0 && $_REQUEST['distance'] < 999){
						if ($_REQUEST['distance'] < $dist_away)
							$show = false;
					}
			}
			
			
					
			if ($show){
				echo '<tr><td>';
				echo '<table>';
				echo '<tr><td>';
				echo '<a href="specialist.php?specialist_id='.$spec['specialist_id'].'"><img src="/images/faces/c'.str_pad((($spec['specialist_id']+10) % 91),2,'0',STR_PAD_LEFT).'.jpg" height="80" width="80"></a>';
				echo '</td><td valign="top">';
				
				 
				echo '<table>';
				echo '<tr><td style="width:400px;"><a href="specialist.php?specialist_id='.$spec['specialist_id'].'" style="font-weight:bold;color:#000;text-decoration:none;">'.$spec['title'] . ' ' . $spec['name_first'] . ' ' . $spec['name_last'] . '</a></td>';
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
				if ($dist_away< 999999){
					
						echo '<tr><td colspan="3">Distance from you: '. $dist_away . ' kms</td></tr>';
				}
				echo '</table>';
				
				
				echo '</td></tr>';
				echo '</table>';
				echo '</td></tr>';
			}
		}
		echo '</table>';
	}
	
	private function showMap(){
		
		
		echo '<div id="map"> </div>';
		?>
<script src="jquery.js"></script>
<script src="underscore.js"></script>
<script src="app2.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqrhf1TF4Jxf5sjLxk_aDtwWGLvMnb9RY&callback=initMap"></script>
		<?php
		
		
		//echo '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26185.80949469353!2d150.59791926438768!3d-34.875666111004634!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b148019678317f1%3A0x525c25f6dccc9d89!2s33+Berry+St%2C+Nowra+NSW+2541!5e0!3m2!1sen!2sau!4v1469509658434" width="1000" height="600" frameborder="0" style="border:0" allowfullscreen></iframe>';
		
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
