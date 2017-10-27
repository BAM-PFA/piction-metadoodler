<?php
echo "<html><body>";
// ############################################
// -------- USER INPUT ------------------------

echo "<div><br><br>HELLOOOOOOOOO</div>";
$targetdir = '/Users/michael/Sites/pictionHelper/uploads/';
    echo $_POST['tagarray'];
    echo $_FILES;
    echo "<pre>"; 
     print_r($_POST['tagarray']); 
    echo "/<pre>"; 
    //  ------  MOVE FILES -------------
    foreach($_FILES['file']['tmp_name'] as $key => $tmp_name ){
        $file_name = $_FILES['file']['name'][$key];
        $file_name = preg_replace('/\s+/', '_', $file_name);
        $file_tmp = $_FILES['file']['tmp_name'][$key];
        $basename = basename($file_name);
        echo "<div>" . $basename . "</div>";
        $uploadedfile = $targetdir . basename($file_name);
        if (move_uploaded_file($file_tmp, $uploadedfile)) {
            // file uploaded succeeded
            echo "success";


        } else { 
            // file upload failed
            echo "FILE UPLOAD FOR ".$basename." FAILED";

        }
    }

    // ----- GENERATE CSV ----------
    $filepath = "ftp://something.or.other/" . $file_name;
    $title = $_POST['title'];
    $year = $_POST['year'];
    $fulldate = $_POST['fulldate'];
    $eventseries = $_POST['eventseries'];
    $relatedex = $_POST['relatedex'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $eventtype = $_POST['eventtype'];
    $people = $_POST['people'];
    $subject = $_POST['subject'];
    $organizer = $_POST['organizer'];
    $source = $_POST['source'];
    $copyright = $_POST['copyright'];
    $credit = $_POST['credit'];
    $tagarray = $_POST['tagarray'];
    $tags = implode(";", $tagarray);
    $caption = $_POST['caption'];
    $restrictions = $_POST['restrictions'];
    $uploader = $_POST['uploader'];


    $METADATA = "filepath,title,year,fulldate,eventseries,relatedex,location,description,eventtype,people,subject,organizer,source,copyright,tags,caption,restrictions,uploader\n";
    $METADATA .= "$filepath,$title,$year,$fulldate,$eventseries,$relatedex,$location,$description,$eventtype,$people,$subject,$organizer,$source,$copyright,$tags,$caption,$restrictions,$uploader\n";

    $metaCSVname = "/Users/michael/Sites/pictionHelper/uploads/metadata.csv";

    file_put_contents($metaCSVname, $METADATA);










?>