<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';

// Utskrift
$responses = [];
// Kollar så att formuläret skickades
if (isset($_POST['email'], $_POST['subject'], $_POST['name'], $_POST['msg'])) {
	// Validerar e-post addressen
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$responses[] = 'Email is not valid!';
	}
	// Ser till så att inmatningsrutorna inte är tomma
	if (empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['name']) || empty($_POST['msg'])) {
		$responses[] = 'Please complete all fields!';
	} 
	// Om det inte är några error
	if (!$responses) {

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "jfasmtptest@gmail.com";
        $mail->Password = '03JulfhaFhA03J';
        $mail->Port = 465;
        $mail->SMTPSecure = "ssl";

        // E-post addressen som kundens mail skickas till
		$to = 'jfasmtptest@gmail.com';

        // E-mejlets innehåll
        $from    = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['msg'];
        $headers = 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion();
             
        $mail->isHTML(true);
        $mail->setFrom($from);
        $mail->addAddress($to);
        $mail->Subject = ("$subject");
        $mail->AddReplyTo($from, 'Kontakta mig');
        $mail->Body = $message;
		
        // Försöker skicka e-mejlet
		if ($mail->send()) {
			// Lyckas
			$responses[] = 'Meddelandet skickades!';		
		} else {
			// Misslyckas
			$responses[] = 'Meddelandet kunde inte skickas!';
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/skrollning.css">
    <link rel="stylesheet" href="css/carousel.css">

    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">

    <title>Andersson Piano & Flygelteknik</title>
</head>
<body>

    <section class="viewport"> <!--Modifieras istället för <body> då mobilenheter inte ser kroppens attributer-->

        <nav id="navbar">

            <a href="index.php"><img id="logo" src="bilder/logotyp.png" alt="logotyp"></a>

            <ul class="nav-links" id="prenav-links">
                <li class="link"><a id="nav_a" href="#headsec">Hem</a></li>
                <li class="link"><a id="nav_a2" href="#prislista">Prislista</a></li>
                <li class="link"><a id="nav_a3" href="#kontakta">Kontakta</a></li>
                <li class="link"><a id="nav_a4" href="#skickbdm">Skickbedöma</a></li>
                <li class="link"><a id="nav_a5" href="#om_mig">Om mig</a></li>
                <button id="loginBtn"><li><a id="nav_a6" href="login.html">Logga in</a></li></button>
            </ul>

            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>    
    
        <section id="headsec">
            <div class="background-filter"></div>
            <h1 id="rubrik">Andersson Piano & Flygelteknik</h1>
            <p id="slogan">"Bäst utbildning, högsta kvalité"</p>     
            
            <div class="btn-wrapper">
                <a class="button" id="btn1" href="#prislista">Prislista</a>
                <a class="button" href="#kontakta">Kontakta</a>
            </div>   

            <div id="arrowContainer">
                <div class="arrow"></div>      
            </div>

        </section>   
        

        <section id="information">
            <div class="container-inf">

                <div class="viewbox viewbox-1">
                    <h1>Arbetsområden:</h1>
                    <p>
                        Jag stämmer och justerar pianon och flyglar i hela Västra Götaland, Stora Göteborg, Härryda, Bollebygd, Borås, Ulricehamn, Falköping, Skövde,
                        Svenljunga och Tranemo.
                    </p>
                </div>

                <div class="viewbox viewbox-2">
                    <h1>Info COVID-19:</h1>
                    <p>
                        Jag jobbar på som vanligt och följer Folkhälsomyndighetens rekommendationer. Det är endast när jag är fullt frisk som jag arbetar, och avstånd hålls alltid.
                        Jag tvättar även händerna och använder handsprit mellan varje kund. Tillhör ni en riskgrupp, men ändå vill stämma just nu, 
                        så bör ni även befinna er i annat rum under tiden jag är där.
                    </p>
                </div>    

            </div>        
        </section>


        <section id="prislista">

            <div id="priceTextHeader">
                <h2 style="text-align: center">Prislista</h2>
                <p style="text-align: center">Uppdaterad - 2021</p>
            </div>
            
            <div class="table-align" id="table-align-price">

                <div class="table-containers">
                    <table class="priceList">
                        <tr>
                            <td colspan="2" id="colspan-head" style="background-color: rgb(48, 48, 48);">Privatperson</td>
                        </tr>
                        <tr>
                            <td colspan="2" id="colspan-grey">Inklusive moms (SEK)</td>
                        </tr>
                        <tr>
                            <td class="td-term">Pianostämning</td>
                            <td class="td-term pris">1650</td>
                        </tr>
                        <tr>
                            <td class="td-term">Reparation / Justering</td>
                            <td class="td-term pris">800 / tim</td>
                        </tr>
                        <tr>
                            <td class="td-term">Resetidsersättning</td>
                            <td class="td-term pris">350 / tim</td>
                        </tr>
                        <tr>
                            <td class="td-term">Resekostnad</td>
                            <td class="td-term pris">50 / mil</td>
                        </tr>              
                        <tr>
                            <td class="td-term">Fakturaavgift</td>
                            <td class="td-term pris">45</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="colspan-btn"><a href="#kontakta" class="kontakt-button" id="kontakt-button1">Kontakta</a></td>
                        </tr>
                    </table>   
                </div>      
    
               <div class="table-containers">
                    <table class="priceList">
                        <tr>
                            <td colspan="2" id="colspan-head">Företag</td>
                        </tr>
                        <tr>
                            <td colspan="2" id="colspan-grey">Exklusive moms (SEK)</td>
                        </tr>
                        <tr>
                            <td class="td-term">Pianostämning</td>
                            <td class="td-term pris">1320</td>
                        </tr>
                        <tr>
                            <td class="td-term">Reparation / Justering</td>
                            <td class="td-term pris">640 / tim</td>
                        </tr>
                        <tr>
                            <td class="td-term">Resetidsersättning</td>
                            <td class="td-term pris">280 / tim</td>
                        </tr>
                        <tr>
                            <td class="td-term">Resekostnad</td>
                            <td class="td-term pris">40 / mil</td>
                        </tr>              
                        <tr>
                            <td class="td-term">Fakturaavgift</td>
                            <td class="td-term pris">36</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="colspan-btn"><a href="#kontakta" class="kontakt-button">Kontakta</a></td>
                        </tr>
                    </table>   
                </div>
            </div>      
        </section>


        <section id="kontakta">

            <div id="marginDivContact" style="margin-top: 85vh;"></div>

            <div id="contactTextHeader">
                <h2>Kontakta</h2>
                <p>Uppdaterad - 2021</p>
            </div>

            <div class="container-inf">
                <div class="viewbox viewbox-1" id="importantViewBox">
                    <h1>Viktigt</h1>
                    <p>
                        Ni kan kontakta mig via e-post eller telefon valfri tid på dagen.
                        På grund av en enorm efterfrågan på piano- samt flygelstämningar och reparationer
                        kan jag dock behöva ringa upp er under ett senare tillfälle.
                        Nedanför hittar ni min kontaktinformation:
                    </p>
                </div>                       

                <div class="viewbox viewbox-3">
                    <h1>Information</h1>
                    <ul class="punktlagd-lista">
                        <li class="span3"><span>Telefon:</span><span>0705-693344</span></li>
                        <li class="span3"><span>E-post:</span><span>Urbanpiano@telia.com</span></li>
                        <li class="span3"><span>Adress:</span><span id="detailsAddress">Ögärdsvägen 4C, <br> 51532 Viskafors</span></li>
                    </ul>
                </div>      
            </div>

            <div class="" id="form-parent">
                <div id="form-container" class="table-align">

                    <h1 style="font-size: 25px; padding-bottom: 10px;">Har du andra frågor? Skicka gärna ett meddelande!</h1>

                    <form class="contact" method="post" action="">

                        <label for="email">E-post</label>
                        <input id="email" type="email" name="email" placeholder="Din e-postadress..." required>

                        <label for="name">Namn</label>
                        <input type="text" name="name" placeholder="Ditt namn..." required>
                    
                        <label for="subject">Ärende</label>
                        <input type="text" name="subject" placeholder="Ditt ärende..." required>

                        <label for="message">Meddelande</label>
                        <textarea name="msg" placeholder="Ditt meddelande..." style="height: 150px" required></textarea>

                        <?php if ($responses): ?>
                            <p class="responses"><?php echo implode('<br>', $responses); ?></p>
                        <?php endif; ?>

                        <div id="formSendContainer">
                            <input type="submit" id="sendInput"></input>
                        </div>
                    </form>
                </div>
            </div>

        </section>

        <section id="skickbdm">

            <div id="conditionTextHeader">
                <h2 style="text-align: center">Att skickbedöma</h2>
                <p style="text-align: center">Uppdaterad - 2021</p>
            </div>  


            <div class="align-skickbdm">
                <div class="k_viewbox">
                    <h1>Hur bedöms ett begagnat piano?</h1>
                    <p>
                        Följande bilder visar tydligt vad du ska titta efter när du köper ett begagnat piano. 
                        När du sedan har valt ut ett piano är det bäst att avtala en tid med din auktoriserade pianotekniker, som 
                        sedan gör en fackmässig inspektion. 
                        <span><a href="https://youtu.be/1TqTIroFaac">Helst ska ett begagnat piano se ut så här:</a></span>
                    </p>            
                </div>
                <div class="k_image_container"></div>
            </div>


            <div class="align-skickbdm" id="align-skickbdm2">
                <div class="k_viewbox" id="k_viewbox2">
                    <p>
                        <span><a href="https://youtu.be/sobKL95G1ck">och inte så här...</a></span>
                    </p>            
                </div>
                <div class="k_image_container" id="k_image_container2"></div>
            </div>

        </section>

        

        <section id="om_mig">

            <div id="aboutTextHeader">
                <h2 style="text-align: center">Om mig</h2>
                <p style="text-align: center">Uppdaterad - 2021</p>
            </div>  

            <div class="align-ommig">
        
                <div class="repbox">
                    <p>Rekommenderat företag på Reco sedan år 2017</p>      
                </div>
                
                <div class="rep_image_container"  id="rep_image_container1"><img src="./bilder/reco5år.png" alt="5ar"></div>

            </div>

            <div class="align-ommig">
        
                <div class="repbox">
                    <p>Auktoriserad medlem i SPTF - Sveriges Pianostämmare och Tekniker Förening</p>      
                </div>
                
                <div class="rep_image_container" id="rep_image_container2"><img src="./bilder/SPTF.png" alt="5ar"></div>

            </div>

            <div class="align-ommig">
        
                <div class="repbox">
                    <p>Tränad av Steinway</p>      
                </div>
                
                <div class="rep_image_container"  id="rep_image_container3"><img src="./bilder/Steinway.png" alt="5ar"></div>

            </div>
        </section>   
    

        <section id="bilder">       

            <div id="blogTextHeader">
                <h2 style="text-align: center">Blogg</h2>
                <p style="text-align: center">Uppdaterad - 2021</p>
            </div>  

            <div class="carousel" data-flickity='{}'>
                <div class="carousel-cell"><img src="./slideshow/Spring.jpg"></div>
                <div class="carousel-cell"><img src="./slideshow/Intonering.jpg"></div>
                <div class="carousel-cell"><img src="./slideshow/Kurs.jpg"></div>
                <div class="carousel-cell"><img src="./slideshow/Piano.jpg"></div>   
            </div>   

        </section>

            
        <footer>@ 2021 Urbanpiano.se - Alla rättigheter förbehållna</footer>    


        <script src="js/animering.js"></script>  
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    </section>  
</body>
</html>