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

$METADATA = "FILENAME,BAMPFA.TITLE,BAMPFA.ARTIST,BAMPFA.YEAR,EVENTS.DC-COVERAGE,EVENTS.DC-PUBLISHER,EVENTS.RELATED_EXHIBITIONS,EVENTS.EVENT_LOCATION,EVENTS.DC-DESCRIPTION,EVENTS.DC-TYPE,EVENTS.DC-SUBJECT,EVENTS.TOPICAL_SUBJECT,EVENTS.ORGANIZER,EVENTS.DC-CONTRIBUTOR,EVENTS.DC-RIGHTS,EVENTS.DC-AUTHOR,EVENTS.TAGS,EVENTS.BAM_PFA_CAPTION,EVENTS.RESTRICTIONS,EVENTS.DC-CREATOR,FILM.BAM_PFA_CAPTION,FILM.DC-CONTRIBUTOR,FILM.DC-CREATOR,FILM.DC-DESCRIPTION,FILM.DC-PUBLISHER,FILM.DC-RIGHTS,FILM.DC-SUBJECT,FILM.DC-TYPE,FILM.RESTRICTIONS,FILM.TAGS,GALLERY EXHIBITION.ARTWORK_CREDIT_LINE,GALLERY EXHIBITION.ARTWORK_MEDIUM,GALLERY EXHIBITION.BAM_PFA_CAPTION,GALLERY EXHIBITION.CURATOR,GALLERY EXHIBITION.DC-CONTRIBUTOR,GALLERY EXHIBITION.DC-COVERAGE,GALLERY EXHIBITION.DC-CREATOR,GALLERY EXHIBITION.DC-DESCRIPTION,GALLERY EXHIBITION.DC-PUBLISHER,GALLERY EXHIBITION.DC-RIGHTS,GALLERY EXHIBITION.DC-TITLE,GALLERY EXHIBITION.DC-TYPE,GALLERY EXHIBITION.EXHIBITION LOCATION,GALLERY EXHIBITION.FULL_EXHIBIT_DATE,GALLERY EXHIBITION.PHOTO_CREDIT,GALLERY EXHIBITION.RESTRICTIONS,GALLERY EXHIBITION.TAGS\n";


//  ------  MOVE FILES -------------
foreach($_FILES['file']['tmp_name'] as $key => $tmp_name ){
    $file_name = $_FILES['file']['name'][$key];
    // $file_name = preg_replace('/\s+/', '_', $file_name);
    $file_tmp = $_FILES['file']['tmp_name'][$key];
    $basename = basename($file_name);
    echo "<div>" . $basename . "</div>";
    include 'ftp.php';
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
        $eventphotocredit = $_POST['eventphotocredit'];
        $eventtagarray = $_POST['eventtagarray'];
        $eventtags = implode(";", $eventtagarray);
        $eventbampfacaption = $_POST['eventbampfacaption'];
        $eventrestrictions = $_POST['eventrestrictions'];
        $eventuploader = $_POST['eventuploader'];
        $filmbampfacaption = $_POST['filmbampfacaption'];
        $filmcontrib = $_POST['filmcontrib'];
        $filmuploader = $_POST['filmuploader'];
        $filmdescription = $_POST['filmdescription'];
        $filmseries = $_POST['filmseries'];
        $filmrights = $_POST['filmrights'];
        $filmpeople = $_POST['filmpeople'];
        $filmtype = $_POST['filmtype'];
        $filmrestrictions = $_POST['filmrestrictions'];
        $filmtagarray = $_POST['filmtagarray'];
        $filmtags = implode(";", $filmtagarray);
        $filmtags = $_POST['filmtags'];
        $exhcreditline = $_POST['exhcreditline'];
        $exhmedium = $_POST['exhmedium'];
        $exhcaption = $_POST['exhcaption'];
        $exhcurator = $_POST['exhcurator'];
        $exhsource = $_POST['exhsource'];
        $exhyearofexh = $_POST['exhyearofexh'];
        $exhuploader = $_POST['exhuploader'];
        $exhdescription = $_POST['exhdescription'];
        $exhnameofexh = $_POST['exhnameofexh'];
        $exhcopyright = $_POST['exhcopyright'];
        $exhartworktitle = $_POST['exhartworktitle'];
        $exhimagetype = $_POST['exhimagetype'];
        $exhlocation = $_POST['exhlocation'];
        $exhfulldates = $_POST['exhfulldates'];
        $exhphotocredit = $_POST['exhphotocredit'];
        $exhrestrictions = $_POST['exhrestrictions'];
        $exhtagarray = $_POST['exhtagarray'];
        $exhtags = implode(";", $exhtagarray);

        $METADATA .= "$filepath,$bampfatitle,$bampfaartist,$bampfayear,$eventfulldate,$eventseries,$eventrelatedex,$eventlocation,$eventdescription,$eventtype,$eventpeople,$eventsubject,$eventorganizer,$eventimagesource,$eventimagecopyright,$eventphotocredit,$eventtags,$eventbampfacaption,$eventrestrictions,$eventuploader,$filmbampfacaption,$filmcontrib,$filmuploader,$filmdescription,$filmseries,$filmrights,$filmpeople,$filmtype,$filmrestrictions,$filmtags,$exhcreditline,$exhmedium,$exhcaption,$exhcurator,$exhsource,$exhyearofexh,$exhuploader,$exhdescription,$exhnameofexh,$exhcopyright,$exhartworktitle,$exhimagetype,$exhlocation,$exhfulldates,$exhphotocredit,$exhrestrictions,$exhtags\n";


    } else { 
        // file upload failed
        echo "FILE UPLOAD FOR ".$basename." FAILED";

    }
}



$metaCSVname = "/Users/michael/Sites/pictionHelper/uploads/metadata.csv";

file_put_contents($metaCSVname, $METADATA);










?>