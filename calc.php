<!doctype html>
<html class="no-js" lang="en" dir="rtl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>اسبة الدراجات</title>
	<link rel="stylesheet" href="css/foundation.css">
	<link rel="stylesheet" href="css/app.css">
	<link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/droid-arabic-kufi" type="text/css"/>

	<style type="text/css">
		* { 
			font-family: 'DroidArabicKufiRegular'; 
			font-weight: normal; 
			font-style: normal; 
		}

		body {
			background: #F0F0F3;
		}
		.login-box {
			background: #fff;
			border: 1px solid #ddd; 
			margin: 100px 0;
			padding: 40px 20px 0 20px;
		}
	</style>
</head>
<body>

	<div class="row align-center align-middle ">
		<div class="large-12 medium-12 small-12 large-centered columns">
			<div class="login-box">
			<table dir="ltr">
  <thead>
    <tr>
      <th>Course Code</th>
      <th>Course Name</th>
      <th >Course Hours</th>
      <th >Course Status</th>
      <th>Course Grade</th>

    </tr>
  </thead>
    <tbody>

<?php

// First, include Requests
include('library/Requests.php');
include('library/simple_html_dom.php');
if (isset($_POST['submit']) && isset($_POST['ID']) && isset($_POST['PASS'])) {
	$html = file_get_html('http://sisonline.arabou.edu.kw/egyeng/Login.aspx');

	$VIEWSTATE = $html->find('input[id=__VIEWSTATE]')[0]->value;
	$VIEWSTATEGENERATOR = $html->find('input[id=__VIEWSTATEGENERATOR]')[0]->value;
	$EVENTVALIDATION = $html->find('input[id=__EVENTVALIDATION]')[0]->value;

	Requests::register_autoloader();
	$headers = array(
		'Host' => 'sisonline.arabou.edu.kw',
		'User-Agent' => 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:51.0) Gecko/20100101 Firefox/51.0',
		'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
		'Accept-Language' => 'en-US,en;q=0.5',
		'Referer' => 'http://sisonline.arabou.edu.kw/egyeng/Login.aspx?ReturnUrl=%2fegyeng%2fForms%2fStudentPlan.aspx',
		'Connection' => 'keep-alive',
		'Upgrade-Insecure-Requests' => '1',
		'Cookie' => ''
		);
	$data = array(
		'__EVENTTARGET' => '',
		'__EVENTARGUMENT' => '',
		'__VIEWSTATE' => $VIEWSTATE,
		'__VIEWSTATEGENERATOR' => $VIEWSTATEGENERATOR,
		'__EVENTVALIDATION' => $EVENTVALIDATION,
		'UNametxt' => $_POST['ID'],
		'UPasstxt' =>$_POST['PASS'],
		'loginImgBtn.x' => '0',
		'loginImgBtn.y' => '0'
		);
	$session = new Requests_Session('http://sisonline.arabou.edu.kw/egyeng/Login.aspx/');
	$session->headers['X-ContactAuthor'] = 'rmccue';
	$session->useragent = 'My-Awesome-App';

	$response = $session->post('http://sisonline.arabou.edu.kw/egyeng/Login.aspx?ReturnUrl=%2fegyeng%2fForms%2fStudentPlan.aspx', $headers, $data);

	$html = str_get_html($response->body);
	$Hours = 0;
	$Points = 0;
	$a7eh = $html->find("span[id=TopMenu1_unamelbl]");
	if(strlen($a7eh[0]->plaintext) >= 10){
		foreach($html->find("#tr[style=background-color:PaleGreen;]") as $row) 
		{
			$Year = $row->children(8)->plaintext;
			$Semester = $row->children(9)->plaintext;
			if($Year == '2016' && $Semester = 'First'){
				$CourseCode = $row->children(0)->plaintext;
				$CourseName = $row->children(1)->plaintext;
				$CourseHours = $row->children(2)->plaintext;
				$CourseStatus = $row->children(3)->plaintext;
				$CourseGrade = $row->children(5)->plaintext;
				$Hours += $CourseHours;
				$Points += PointsCalc($CourseGrade) * $CourseHours;
				echo "<tr>";    
				echo "<td>".$CourseCode."</td>";    
				echo "<td>".$CourseName."</td>";    
				echo "<td>".$CourseHours."</td>";    
				echo "<td>".$CourseStatus."</td>";    
				echo "<td>".$CourseGrade."</td>";    
				echo "</tr>";    
			}
		}

		$response2 = $session->get('http://sisonline.arabou.edu.kw/egyeng/forms/StudentGrades.aspx');
		$html2 = str_get_html($response2->body);
		$FinalTotalPoint = '0';
		$FinalTotalHours = '0';

		foreach($html2->find("span") as $row2) 
		{  
			$IDAttribute = $row2->getAttribute('id');
			$Total = $row2->plaintext;
			$Total = substr($Total, 0, -1);
			if(preg_match('/totpointtxt/', $IDAttribute, $matches, PREG_OFFSET_CAPTURE)){
				if(1 === preg_match('~[0-9]~', $Total)){
					if($Total > $FinalTotalPoint){
						$FinalTotalPoint =$Total;
					}
				}
			}

			if(preg_match('/tothourstxt/', $IDAttribute, $matches, PREG_OFFSET_CAPTURE)){
				if(1 === preg_match('~[0-9]~', $Total)){
					if($Total > $FinalTotalHours){
						$FinalTotalHours =$Total;
					}
				}
			}

		}

	}else{
		header("Location: http://localhost/aou/5/index.php?error=notLogin");
		die();
	}
}else{
	header("Location: http://localhost/aou/5/");
	die();

}
function PointsCalc($Grad){
	if($Grad == 'A'){
		return 4.0;
	}elseif ($Grad == 'B+') {
		return 3.5;
	}elseif ($Grad == 'B') {
		return 3.0;
	}elseif ($Grad == 'C+') {
		return 2.5;
	}elseif ($Grad == 'C') {
		return 2.0;
	}elseif ($Grad == 'D') {
		return 1.5;
	}elseif ($Grad == 'F') {
		return 0.0;
	}
}
?>
  </tbody>
</table>
<?php
echo "<h3><span>عدد الساعات للترم ده</span><span style='color:Red;'>" . $Hours ."</span></h3>";
echo "<h3><span>عدد النقاط للترم ده</span><span style='color:Red;'>" . $Points ."</span></h3>";
echo "<h3><span>GPA للترم ده</span><span style='color:Red;'>" . ($Points/$Hours) ."</span></h3>";
echo "<h3><span>GPA للترمات كلها</span><span style='color:Red;'>" . (($Points+$FinalTotalPoint)/($Hours+$FinalTotalHours)) ."</span></h3>";

?>
			</div>
		</div>
	</div>

</body>
</html>
