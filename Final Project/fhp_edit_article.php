<html>

<head>
<?php

/*
*Name: Cameron Cromer
*Date: Nov. 19, 2017
*Purpose: to edit articles. ADMIN and EDITOR can see all. AUTHOR can only see their own. 
*/
session_start();

//kicks unauthorized users
if($_SESSION['account'] == ""){
	header("Location: fhp_home.php");
}

//required for db interactions
require_once('connect.php');

//checks for get set and kicks if not set
if(isset($_GET['id'])){
    $id = $_GET['id'];

    //checks to see if account level is author
    if ($_SESSION['account'] == "author")
    {
	    $query = query("SELECT * FROM Post WHERE id = '$id'");
	  	confirm($query);
	  	$post = fetch_array($query);
	  	$fname = $_SESSION['firstname'];
		$lname = $_SESSION['lastname'];
		$name  = $fname . ' ' . $lname;

		//checks account name to the articles author's name to ensure they are allowed (ONLY FOR ACCOUNT LEVLE: AUTHOR)
	  	if($post['author'] != $name)
	  	{
	  		header("Location: fhp_article_list.php");
	  	}
 	}
}else{
	header("Location: fhp_article_list.php");
}

    $query = query("SELECT * FROM Post WHERE id = '$id'");
    confirm($query);
    $results = fetch_array($query);
?>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="fhp_test.css">
<title>FHP Edit Article</title>
</head>

<body>

		<div id="banner-top">
		<img id="title-img" src="fhp_logo.png"></img>

		<ul>
			<a href="fhp_home.html"><li>Home</li></a>
			
			<a href="fhp_institute.php"><li>Institute</li></a>
			
			<a href="#"><li>Contact</li></a>
						
			<div class="dropdown">
				<li class="about">About &#x25BC</li>
					<div class="dropdown-content">
						<a href="fhp_about.html">Freedom's Hill Primer</a>
						<a href="fhp_about_institute.html">Institute</a>
					</div>
			</div> 									
		</ul>
	</div>
	
<main>
<div id="div-section-holder">
	<h1 id="section-name">Edit Article</h1>
</div>

<div id="div-section-holder">
	<form action="" method="post">
      	<div class="row">
        <div class="col-md-12">
        	<?php get_article_edit($id); ?>
	    <br>
	    <br>
	    <select id="artcategory" name="artcategory">
		  <?php get_category_edit($results['category']); ?>
		</select>
		<br>
		<br>
	    <button class="button" type="submit" name="submit">Update Article</button>
	    </div>
      	</div>
  	</form>
</div>


<?php
if ($_SERVER['REQUEST_METHOD'] == "POST"){

              $title = escape_string($_POST['arttitle']);
              $content = escape_string($_POST['artcontent']);
              $author = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
              $date = date("Y-m-d h:i:sH");
              $date = substr($date, 0, -2);
              $category = escape_string($_POST['artcategory']);
              $id = $results['id'];

              $query = query("UPDATE Post SET title='$title', content='$content', timestamp='$date', category = '$category' WHERE id=$id");
              confirm($query);

             echo "<script type=\"text/javascript\">window.location.replace(\"fhp_article_list.php\")</script>";
}?>
<script type="text/javascript" src="jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="tinymce/tinymceinit-100.js"></script>
<script type="text/javascript" src="tinymce/tinymceinit-200.js"></script>
<script type="text/javascript" src="tinymce/tinymceinit-300.js"></script>
</main>
</html>