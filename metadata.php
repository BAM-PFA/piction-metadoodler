<?php
echo "<html><body>";
// ############################################
// -------- USER INPUT ------------------------

echo "<div><br><br>HELLOOOOOOOOO</div>";
$targetdir = 'uploads/';
echo $_POST['tagarray'];
echo $_FILES;
echo "<pre>"; 
 print_r($_FILES); 
echo "/<pre>"; 

$METADATA = "FILENAME,BAMPFA.TITLE,BAMPFA.ARTIST,BAMPFA.YEAR,EVENTS.DC-COVERAGE,
    EVENTS.DC-PUBLISHER,EVENTS.RELATED_EXHIBITIONS,EVENTS.EVENT_LOCATION,EVENTS.DC-DESCRIPTION,EVENTS.DC-TYPE,
    EVENTS.DC-SUBJECT,EVENTS.TOPICAL_SUBJECT,EVENTS.ORGANIZER,EVENTS.DC-CONTRIBUTOR,EVENTS.DC-RIGHTS,
    EVENTS.DC-AUTHOR,EVENTS.TAGS,EVENTS.BAM_PFA_CAPTION,EVENTS.RESTRICTIONS,EVENTS.DC-CREATOR,
    OTHER.STUFF\n";


//  ------  MOVE FILES -------------
foreach($_FILES['file']['tmp_name'] as $key => $tmp_name ){
    $file_name = $_FILES['file']['name'][$key];
    // $file_name = preg_replace('/\s+/', '_', $file_name);
    $file_tmp = $_FILES['file']['tmp_name'][$key];
    $basename = basename($file_name);
    echo "<div>" . $basename . "</div>";
    $uploadedfile = $targetdir . basename($file_name);
    if (move_uploaded_file($file_tmp, $uploadedfile)) {
        // file uploaded succeeded
        echo "success";

        // ----- GENERATE CSV VALUES ----------
        $filepath = "ftp://something.or.other/" . $file_name;
        $bampfatitle = $_POST['bampfatitle'];
        $bampfaartist = $_POST['bampfaartist'];
        $bampfayear = $_POST['bampfayear'];
        $eventfulldate = $_POST['eventfulldate'];
        $eventseries = $_POST['eventseries'];
        $eventrelatedex = $_POST['eventrelatedex'];
        $eventlocation = $_POST['eventlocation'];
        $eventdescription = $_POST['eventdescription'];
        $eventtype = $_POST['eventtype'];
        $eventpeople = $_POST['eventpeople'];
        $eventsubject = $_POST['eventsubject'];
        $eventorganizer = $_POST['eventorganizer'];
        $eventimagesource = $_POST['eventimagesource'];
        $eventimagecopyright = $_POST['eventimagecopyright'];
        $eventcredit = $_POST['eventcredit'];
        $eventtagarray = $_POST['eventtagarray'];
        $eventtags = implode(";", $eventtagarray);
        $eventbampfacaption = $_POST['eventbampfacaption'];
        $eventrestrictions = $_POST['eventrestrictions'];
        $eventuploader = $_POST['eventuploader'];

        $METADATA .= "$filepath,$bampfatitle,$bampfayear,$eventfulldate,
            $eventseries,$eventrelatedex,$eventlocation,$description,$eventtype,
            $eventpeople,$eventsubject,$eventorganizer,$eventimagesource,$eventimagecopyright,
            $tags,$eventbampfacaption,$eventrestrictions,$eventuploader,
            
            \n";


    } else { 
        // file upload failed
        echo "FILE UPLOAD FOR ".$basename." FAILED";

    }
}



$metaCSVname = "/Users/michael/Sites/pictionHelper/uploads/metadata.csv";

file_put_contents($metaCSVname, $METADATA);










?>