<?php
echo "<html><body>";

include 'ftp.php';

// echo "<pre>"; 
// print_r($_FILES); 
// echo "/<pre>"; 

$METADATA = "FILENAME,BAMPFA.TITLE,BAMPFA.ARTISTFILMMAKER,BAMPFA.YEAR,EVENTS.DC-COVERAGE,EVENTS.DC-PUBLISHER,EVENTS.RELATED_EXHIBITIONS,EVENTS.EVENT_LOCATION,EVENTS.DC-DESCRIPTION,EVENTS.DC-TYPE,EVENTS.DC-SUBJECT,EVENTS.TOPICAL_SUBJECT,EVENTS.ORGANIZER,EVENTS.DC-CONTRIBUTOR,EVENTS.DC-RIGHTS,EVENTS.DC-AUTHOR,EVENTS.TAGS,EVENTS.BAM_PFA_CAPTION,EVENTS.RESTRICTIONS,EVENTS.DC-CREATOR,FILM.BAM_PFA_CAPTION,FILM.DC-CONTRIBUTOR,FILM.DC-CREATOR,FILM.DC-DESCRIPTION,FILM.DC-PUBLISHER,FILM.DC-RIGHTS,FILM.DC-SUBJECT,FILM.DC-TYPE,FILM.RESTRICTIONS,FILM.TAGS,GALLERY EXHIBITION.ARTWORK_CREDIT_LINE,GALLERY EXHIBITION.ARTWORK_MEDIUM,GALLERY EXHIBITION.BAM_PFA_CAPTION,GALLERY EXHIBITION.CURATOR,GALLERY EXHIBITION.DC-CONTRIBUTOR,GALLERY EXHIBITION.DC-COVERAGE,GALLERY EXHIBITION.DC-CREATOR,GALLERY EXHIBITION.DC-DESCRIPTION,GALLERY EXHIBITION.DC-PUBLISHER,GALLERY EXHIBITION.DC-RIGHTS,GALLERY EXHIBITION.DC-TITLE,GALLERY EXHIBITION.DC-TYPE,GALLERY EXHIBITION.EXHIBITION LOCATION,GALLERY EXHIBITION.FULL_EXHIBIT_DATE,GALLERY EXHIBITION.PHOTO_CREDIT,GALLERY EXHIBITION.RESTRICTIONS,GALLERY EXHIBITION.TAGS\n";
$metadataFields = array("bampfatitle","bampfaartist","bampfayear","eventfulldate","eventseries","eventrelatedex","eventlocation","eventdescription","eventtype","eventpeople","eventsubject","eventorganizer","eventimagesource","eventimagecopyright","eventphotocredit","eventbampfacaption","eventrestrictions","eventtagarray","eventuploader","filmbampfacaption","filmcontrib","filmuploader","filmdescription","filmseries","filmrights","filmpeople","filmtype","filmtagarray","filmrestrictions","exhcreditline","exhmedium","exhcaption","exhcurator","exhsource","exhyearofexh","exhuploader","exhdescription","exhnameofexh","exhcopyright","exhartworktitle","exhimagetype","exhlocation","exhfulldates","exhphotocredit","exhtagarray","exhrestrictions");
$METADATA_VALUES = "";
$category = $_POST['category'];
echo "<div><b>".$category."</b></div>";
$ftpDir = "zz_hothothotfolders\\" . $category;
// echo $ftpDir;

//  ------  GET TEMP FILES -------------
foreach($_FILES['file']['tmp_name'] as $key => $tmp_name ){
    $file_name = $_FILES['file']['name'][$key];
    $file_tmp = $_FILES['file']['tmp_name'][$key];
    $basename = basename($file_name);
    
    // ----- GENERATE CSV VALUES ----------
    $filepath =  "K:\\ftp_ucbcspace\\BAMPFA\\" . $ftpDir . "\\" . $basename;

    foreach($metadataFields as $field){
        if (!isset($_POST[$field])){
            $field = NULL;                       // SET EMPTY $_POST VALUES TO EMPTY STRING OR ARRAY
            if (strpos($field, 'array')){
                $field = array();
            }
        }
        else $$field = $_POST[$field];
    }
    
    if (isset($eventtagarray[1])){
        $eventtags = implode(";", $eventtagarray);      
    }
    if (isset($filmtagarray[0])){
        $filmtags = implode(";", $filmtagarray); 
        echo $filmtags;     
    }
    if (isset($exhtagarray[1])){
        $exhtags = implode(";", $exhtagarray);      
    }

    $METADATA .= "$filepath,$bampfatitle,$bampfaartist,$bampfayear,$eventfulldate,$eventseries,$eventrelatedex,$eventlocation,$eventdescription,$eventtype,$eventpeople,$eventsubject,$eventorganizer,$eventimagesource,$eventimagecopyright,$eventphotocredit,$eventtags,$eventbampfacaption,$eventrestrictions,$eventuploader,$filmbampfacaption,$filmcontrib,$filmuploader,$filmdescription,$filmseries,$filmrights,$filmpeople,$filmtype,$filmrestrictions,$filmtags,$exhcreditline,$exhmedium,$exhcaption,$exhcurator,$exhsource,$exhyearofexh,$exhuploader,$exhdescription,$exhnameofexh,$exhcopyright,$exhartworktitle,$exhimagetype,$exhlocation,$exhfulldates,$exhphotocredit,$exhrestrictions,$exhtags\n";
    $METADATA_VALUES .= "$filepath,$bampfatitle,$bampfaartist,$bampfayear,$eventfulldate,$eventseries,$eventrelatedex,$eventlocation,$eventdescription,$eventtype,$eventpeople,$eventsubject,$eventorganizer,$eventimagesource,$eventimagecopyright,$eventphotocredit,$eventtags,$eventbampfacaption,$eventrestrictions,$eventuploader,$filmbampfacaption,$filmcontrib,$filmuploader,$filmdescription,$filmseries,$filmrights,$filmpeople,$filmtype,$filmrestrictions,$filmtags,$exhcreditline,$exhmedium,$exhcaption,$exhcurator,$exhsource,$exhyearofexh,$exhuploader,$exhdescription,$exhnameofexh,$exhcopyright,$exhartworktitle,$exhimagetype,$exhlocation,$exhfulldates,$exhphotocredit,$exhrestrictions,$exhtags\n";
    ftpFile($file_tmp,$ftpDir,$basename);

}

date_default_timezone_set('America/Los_Angeles');
$today = date('Y-m-d');
$metaCSVname = getcwd() . "/uploads/" . $today . "_" . $category . "_metadata.csv";
// use this to get the date in the metadata file --> substr($metaCSVname,0,10)

// -------- IF METADATA CSV ALREADY EXISTS, APPEND TO IT, OTHERWISE CREATE IT 
if (file_exists($metaCSVname)){
    file_put_contents($metaCSVname, $METADATA_VALUES, FILE_APPEND);
} else{
    file_put_contents($metaCSVname, $METADATA);
}

ftpFile($metaCSVname,$ftpDir,"metadata.csv");

?>
