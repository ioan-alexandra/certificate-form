<?php
$today = date("Y/m/d");
if (isset($_POST["subtip"])) {
    $subtip = $_POST["subtip"];
} else {
    $subtip  = "nu";
}

if (isset($_POST["daNu"]) && $_POST["daNu"] == "NU") {
    $factura = $_POST["persoanafiz"];
} else {
    $factura = "nu";
}

if (isset($_POST["CUI"]) && isset($_POST)) {
    $ip = $_POST["IP"];
    $cui = $_POST["CUI"];
    $denumire = $_POST["denumire"];
    $email = $_POST["email"];
    $telefon = $_POST["telefon"];
    $tip = $_POST["tip"];


    $servername = "remotemysql.com";
    $username = "ypdDh2eISO";
    $password = "rkNyae2LJD";
    $db = "VluNiaBiL4";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn = new PDO($dsn, $user, $pwd, $options);

        echo "Connected successfully";

        $sql = "INSERT INTO certificate(Timestamp, CUI, Denumire, Email, Telefon, TipDocument, Subtip, Factura, Pret, IP) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $stmt =  $conn->prepare($sql);
        $stmt->execute([date("Y/m/d"), $cui, $denumire, $email, $telefon, $tip, $subtip, $factura, $_POST["pret"], $ip]);
        $sql2 = "SELECT * FROM `certificate` ORDER BY Id DESC LIMIT 1;";
        $stmt2 = $conn->query($sql2);

        while ($row = $stmt2->fetch()) {
            $id = $row["Id"];
        }

        $to = $email;
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
        // More headers
        $headers .= 'From: <contact@alexwritescode.eu>' . "\r\n";
        $headers .= 'Cc: contact@alexwritescode.eu' . "\r\n";
        if ($tip != "Furnizare informatii") {
            $t = "Certificat constatator";
            $a = "https://mpy.ro/h6s8z7ev";
            $p = "74";
            $redirect = "https://www.certificatconstatator.com/plata-certificat-constatator/";

            $mail = "<h4 style='text-transform: capitalize; margin-bottom: 0'>Selectează Tipul De Document Dorit</h4>
        <div>$tip</div>
        <h4 style='text-transform: capitalize; margin-bottom: 0'>Serveste la</h4>
        <div>$subtip</div>";
        } else {
            $t = "Furnizare informatii";
            $a = "https://mpy.ro/h6s8z6ev";
            $p = "49";
            $redirect = "https://www.certificatconstatator.com/plata-furnizare-informatii/";
            $mail = "<h4 style='text-transform: capitalize; margin-bottom: 0'>Selectează Tipul De Document Dorit</h4>
        <div>$tip</div>";
        }
        if ($factura != "nu") {
            $addFactura = "<h4 style='text-transform: capitalize; margin-bottom: 0'>Doresc Emiterea Facturii Pe Numele Firmei Pentru Care Am Comandat Certificatul.
        </h4>
        <div>NU</div>
        <h4 style='text-transform: capitalize; margin-bottom: 0'>CUI / Persoana Fizica Pentru Factura</h4>
        <div>$factura</div>";
        } else {
            $addFactura = "<h4 style='text-transform: capitalize; margin-bottom: 0'>Doresc Emiterea Facturii Pe Numele Firmei Pentru Care Am Comandat Certificatul.
        </h4>
        <div>DA</div>";
        }
        $subjectEu = "Proforma: $id - $t - $ip - $email - $telefon";
        $messageEu = " <h4 style='text-transform: capitalize; margin-bottom: 0'>CUI/CIF Firmă Pentru Care Se Dorește Certificatul</h4>
            <div>$cui</div>
            <h4 style='text-transform: capitalize; margin-bottom: 0'>Denumire Firmă</h4>
            <div>$denumire</div>
            $mail
            <h4 style='text-transform: capitalize; margin-bottom: 0'>Email</h4>
            <div>$email</div>
            <h4 style='text-transform: capitalize; margin-bottom: 0'>Telefon</h4>
            <div>$telefon</div>
            $addFactura ";

        $subject = "Certificat constatator - certificatconstatator.com";
        $message = "
    <html><head><title>HTML email</title>
        </head>
        <body>
            <p>Buna ziua!</p>
            <p>Vă mulțumim pentru comanda. Vom obține de la Registru Comerțului Certificatul constatator comandat de dvs.</p>
            <p>Dacă plata dvs. cu cardul nu a fost confirmată de către prcesatorul de plăți NETOPIA Payments SRL (Mobilpay) prin transmiterea unui email, puteti reîncerca plata cu cardul prin accesarea linkului:</p>
            <p><a href=$a>Plateste cu cardul $p lei.</a></p>
            <p> După ce ați plătit cu cardul, veți primi un email de confirmare de la Mobilpay - Netopia.</p>
            <p>În câteva minute (în condiții de funcționare optimă a serverului ONRC) după confirmarea de la Mobilpay, veti primi pe email si documentul solicitat.</p>
            <p>Daca ați optat pentru plata prin virament bancar cu OP, folosiți datele proformei de mai jos și vă rugăm să ne comunicați o copie a documentului de plată la adresa de email contact@alexwritescode.eu. În câteva minute (în condiții de funcționare optimă a serverului ONRC) de la primirea confirmării plății, veți primi pe email documentul solicitat.</p><br>
            <p><b>Proforma numarul $id din data $today</b></p>
            <p>$t ONRC $p lei</p>
            <p>Taxa ONRC inclusă în pret.</p>
            <p>______________________________________</p>
            <b>Total de plată - $p lei</b>
            <p>________________________________________</p>
            <p>Furnizor: Ioan Alexandra Diana Persoana Fizica Autorizata</p>
            <p>Adjud, Sat Adjudu Vechi, str. Armoniei 9</p>
            <p>CUI: 42941741</p>
            <p>Nr. ONRC: F39/316/2020</p>
            <p>Cont bancar: ING</p>
            <p>IBAN: RO65INGB0000999908482488</p>
            <p>Comanda dvs.:</p>
            $messageEu
            <p> <b>Acord prelucrare date personale</b></p><p>Am luat la cunostință despre modul de prelucrare a datelor cu caracter personal cuprinse în acest formular, conform <a href='https://tinyurl.com/y2pkw4ba'>Politici de prelucrare date caracter personal</a> și <a href='https://tinyurl.com/y3us2dk8'>Termeni și Condiții</a>. Împuternicesc un reprezentant certificatconstatator.com să figureze ca solicitant pe documentul comandat.
            </p>
            <p>Cu stima,</p>
            <p>Alexandra Ioan</p></body>
    </html>";
        //wp_mail($to, $subject, $message, $headers);
        echo $to;
        $messageEu .= "<h4 style='text-transform: capitalize; margin-bottom: 0'>IP</h4>
            <div>$ip</div>";
        //wp_mail("contact@alexwritescode.eu", $subjectEu, $messageEu, $headers);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    exit();
}
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale= 1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <style>
        #rezultat {
            color: #8A1D00;
            font-size: 1em;
            display: none;
        }

        .form-elements p,
        .form-elements label {
            font-family: "Poppins", Sans-serif !important;
            font-size: 1.1em;
        }

        .pure-form fieldset {
            font-family: "Poppins", Sans-serif !important;
            font-size: 1em;
        }

        .form-elements input,
        .form-elements select {
            font-family: "Poppins", Sans-serif;
            font-size: 1.2em !important;
        }

        #payment-total {
            font-size: 1.2em !important;
        }

        #myForm {
            padding: 5%;
        }

        #verifica {
            z-index: 900 !important;
        }

        .button-style {
            display: inline-block;
            font-family: inherit;
            font-weight: 600;
            letter-spacing: 0.1em;
            line-height: 1;
            -webkit-transition: all 0.3s ease;
            -moz-transition: all 0.3s ease;
            -ms-transition: all 0.3s ease;
            -o-transition: all 0.3s ease;
            transition: all 0.3s ease;
            background-color: #88bdbc !important;
            border: none;
            color: white !important;
            padding: 0.7em;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 18px !important;
            margin: 4px 2px;
            transition-duration: 0.4s !important;
            width: 100%;
            cursor: pointer;
        }

        .button-style:hover {
            background-color: white !important;
            border: 3px solid #88bdbc !important;
            color: #88bdbc !important;
            cursor: pointer;
        }

        .content-head {
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin: 2em 0 1em;
        }

        .is-center {
            text-align: center;
        }

        #name,
        #email {
            width: 50%;
        }

        .honeypot-field {
            display: none;
        }

        #persoana,
        #imm,
        #baza,
        #insol,
        #factura,
        #cuifact {
            display: none;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            z-index: 900 !important;
            position: fixed;
            z-index: 1;
            padding-top: 15%;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content,
        .modal-content-2 {
            background-color: #fefefe;
            margin: auto;
            z-index: 900 !important;
            padding: 20px;
            text-align: center;
            border: 1px solid #888;
            width: 80%;
        }

        .modal-content p,
        .modal-content-2 p {
            font-family: "Poppins", Sans-serif !important;
            font-size: 1.2em;
            margin: -0.5px !important;

        }

        .modal-content h2,
        .modal-content-2 h2 {
            font-family: "Poppins", Sans-serif !important;
        }

        /* The Close Button */
        .close {
            background-color: #3A6868;
            border: none;
            color: white;
            padding: 12px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 15px;
            margin: 4px 2px;
            transition-duration: 0.4s;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            background-color: white;
            border: 1px solid #3A6868;
            color: #3A6868;
            text-decoration: none;
            cursor: pointer;
        }

        #validati {
            color: #FF002E;
        }
    </style>
</head>

<body>
    <form class="gform pure-form pure-form-stacked" method="POST" id="myForm" target="_self">
        <div class="form-elements">
            <fieldset class="pure-group">
                <label>CUI/CIF firmă pentru care se dorește certificatul</label>
                <input type="text" id="cui" required name="CUI" placeholder="Fara RO">
                <p id="rezultat"></p>
                <div id="verifica" class="button-style">Validati CUI
                </div>
                <div>Doar pentru firme înregistrate la Registrul Comerțului</div>
            </fieldset>

            <fieldset class="pure-group">
                <label>Denumire firmă</label>
                <input type="text" id="denumire" name="denumire">
            </fieldset>

            <fieldset class="pure-group">
                <label>Selectează tipul de document dorit</label>
                <select aria-invalid="false" name="tip" id="tip">
                    <option value="Furnizare informatii" data-amount="49.00">Furnizare informatii</option>
                    <option value="Certificat constatator de bază" data-amount="74.00">Certificat constatator de baza</option>
                    <option value="Certificat constatator fonduri IMM" data-amount="74.00">Certificat constatator fonduri IMM</option>
                    <option value="Certificat constatator pentru insolvență" data-amount="74.00">Certificat constatator pentru insolventa</option>
                </select>
            </fieldset>

            <fieldset id="baza" class="pure-group">
                <label>Certificat Constatator de Bază care servește la:</label>
                <select id="certBaza" name="subtip">
                    <option value="Accesare Fonduri">Accesare Fonduri</option>
                    <option value="Accesare Fonduri Europene">Accesare Fonduri Europene</option>
                    <option value="Administratia financiara">Administratia financiara</option>
                    <option value="Administraţia Fondului pentru Mediu">Administraţia Fondului pentru Mediu</option>
                    <option value="Administrația Finanțelor Publice">Administrația Finanțelor Publice</option>
                    <option value="Agenţia pentru Finanţarea Investiţiilor Rurale (AFIR)">Agenţia pentru Finanţarea Investiţiilor Rurale (AFIR)</option>
                    <option value="Agenția Națională de Administrare Fiscală">Agenția Națională de Administrare Fiscală</option>
                    <option value="Agenția Națională pentru Ocuparea Forței de Muncă">Agenția Națională pentru Ocuparea Forței de Muncă</option>
                    <option value="Agenția Națională pentru Protecția Mediului">Agenția Națională pentru Protecția Mediului</option>
                    <option value="Agenția Națională pentru Resurse Minerale">Agenția Națională pentru Resurse Minerale</option>
                    <option value="Ambasadă">Ambasadă</option>
                    <option value="Autoritatea Rutieră Română">Autoritatea Rutieră Română</option>
                    <option value="Autorizare">Autorizare</option>
                    <option value="Banca Națională a României">Banca Națională a României</option>
                    <option value="Bancă">Banca</option>
                    <option value="Birou notar public">Birou notar public</option>
                    <option value="Casa Națională de Asigurări de Sănătate">Casa Națională de Asigurări de Sănătate</option>
                    <option value="Casa Națională de Pensii">Casa Națională de Pensii</option>
                    <option value="Direcţia Generală a Vămilor">Direcţia Generală a Vămilor</option>
                    <option value="Eliberare cazier judiciar">Eliberare cazier judiciar</option>
                    <option value="Fonduri SAPARD">Fonduri SAPARD</option>
                    <option value="Informare">Informare</option>
                    <option value="Insolvență">Insolventa</option>
                    <option value="Inspectoratul General pentru Imigrări">Inspectoratul General pentru Imigrări</option>
                    <option value="Instanță">Instanță</option>
                    <option value="Leasing">Leasing</option>
                    <option value="Licitație">Licitație</option>
                    <option value="Ministerul Muncii și Justiţiei Sociale">Ministerul Muncii și Justiţiei Sociale</option>
                    <option value="Obținere viză">Obținere viză</option>
                    <option value="Oficiul de Cadastru și Publicitate Imobiliară">Oficiul de Cadastru și Publicitate Imobiliară</option>
                    <option value="Parchet">Parchet</option>
                    <option value="Poliție">Poliție</option>
                    <option value="Primãrie">Primãrie</option>
                    <option value="Registrul Auto Român">Registrul Auto Român</option>
                    <option value="Registrul Operatorilor Intracomunitari">Registrul Operatorilor Intracomunitari</option>
                    <option value="Înregistrare în scopuri de TVA">Înregistrare în scopuri de TVA</option>
                </select>
            </fieldset>

            <fieldset id="imm" class="pure-group">
                <label>Certificat Constatator Fonduri IMM care servește la:</label>
                <select id="certIMM" name="subtip">
                    <option value="Accesare Fonduri">Accesare Fonduri</option>
                    <option value="Accesare Fonduri Europene">Accesare Fonduri Europene</option>
                    <option value="Agenţia pentru Finanţarea Investiţiilor Rurale (AFIR)">Agenţia pentru Finanţarea Investiţiilor Rurale (AFIR)</option>
                    <option value="Fonduri IMM">Fonduri IMM</option>
                    <option value="Fonduri SAPARD">Fonduri SAPARD</option>
                    <option value="MINIMIS">MINIMIS</option>
                    <option value="Ministerul Muncii și Justiţiei Sociale">Ministerul Muncii și Justiţiei Sociale</option>
                    <option value="Primãrie">Primãrie</option>
                </select>
            </fieldset>

            <fieldset class="pure-group" id="insol">

                <label>Certificat Constatator pentru Insolvență care servește la:</label>
                <select name="subtip" id="certIns">
                    <option value="Licitație">Licitație</option>
                    <option value="Procedura de insolventa">Procedura de insolventa</option>
                    <option value="Tribunal">Tribunal</option>
                </select>
            </fieldset>

            <fieldset class="pure-group">
                <label>Email</label>
                <input type="email" required name="email">
            </fieldset>

            <fieldset class="pure-group">
                <label>Număr telefon</label>
                <input type="text" required name="telefon" placeholder="07xxxxxxxx">
            </fieldset>

            <fieldset class="pure-group">
                <label>Doresc emiterea facturii pe numele firmei pentru care am comandat certificatul.</label>
                <select name="daNu" id="daNu">
                    <option value="DA">DA</option>
                    <option value="NU">NU</option>
                </select>
            </fieldset>

            <fieldset class="pure-group" id="persoana">
                <label>CUI sau Nume și Prenume daca se dorește factura pe persoană fizică</label>
                <input type="text" name="persoanafiz" id="persfactura">
            </fieldset>

            <fieldset class="pure-group">
                <label>Total (taxa ONRC inclusă)</label>
                <div id="payment-total">49.00 lei</div>
                <input type="hidden" name="pret" id="total" value="49.00 lei">
            </fieldset>
            <fieldset class="pure-group honeypot-field">
                <label for="honeypot">To help avoid spam, utilize a Honeypot technique with a hidden text field; must be empty to submit the form! Otherwise, we assume the user is a spam bot.</label>
                <input id="honeypot" type="text" name="honeypot" value="" />
            </fieldset>
            <fieldset class="pure-group">
                <input type="hidden" name="IP" id="ip" value="nu">
            </fieldset>

            <fieldset>
                <label>Acord prelucrare date personale </label>
                <input type="checkbox" value="termeni" required name="termeni">Am luat la cunoștință despre condițiile de încheiere a <a href="https://www.certificatconstatator.com/conditii-incheiere-contracte-la-distanta/" target="_blank">contractelor la distantă</a> și modul de prelucrare a datelor cu caracter personal cuprinse în acest formular, conform <a href="https://www.certificatconstatator.com/privacy-policy/" target="_blank"> Politica de confidențialitate</a>. Îmi exprim acordul prealabil expres pentru începerea executării contractului. Am luat cunoștință de faptul că îmi voi pierde dreptul la retragere după executarea completă a contractului. Împuternicesc un reprezentant <b>www.certificatconstatator.com</b> să figureze ca solicitant pe documentul obținut de la O.N.R.C.
            </fieldset>

            <button id="submit" class="button-style" class="g-recaptcha" data-sitekey="6Lc-wNoZAAAAAFifXdf2riXbmBkIBI0aE8e9wvYL" type="submit" disabled>
                <i class="fa fa-paper-plane"></i>&nbsp;Trimite</button>
            <p id="validati"> Va rugam sa validati CUI-ul inainte sa trimiteti comanda.

            </p>
        </div>

    </form>
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <h2>
                Date companie
            </h2>
            <p id="denumire2"></p>
            <p id="judet"></p>
            <p id="adresa"></p>
            <p id="nrReg"></p>
            <p id="stare"></p>
            <center>
                <div class="close" id="pune">
                    Doresc certificat pentru aceasta firma
                </div>
                <div class="close " id="incearca">
                    Introduce alt CUI </div>
            </center>
        </div>
    </div>


    <script>
        var modal = document.getElementById("myModal");
        var span = document.getElementsByClassName("close")[0];
        jQuery(function() {
            jQuery(document).on('click', '#verifica', function() {
                var cif = document.getElementById("cui").value;
                var request = new XMLHttpRequest();

                request.open('GET', `https://api.openapi.ro/api/companies/${cif}`);
                request.setRequestHeader('x-api-key', '4a2yvXHruzK3UUSU8CzjWL9KjLk289WpzXXUizh79rXCxz-chg');

                request.onreadystatechange = function() {
                    if (this.readyState === 4) {
                        var obj = JSON.parse(this.responseText);
                        var denumire = obj.denumire;
                        var reg = obj.numar_reg_com;
                        var jud = obj.judet;
                        var adrs = obj.adresa;
                        var str = obj.stare;
                        if (denumire == null) {
                            document.getElementById("rezultat").innerHTML = "Va rugam sa introduceti un CUI valid si sa incercati din nou";
                            document.getElementById("rezultat").style.display = "block";
                        } else if (reg == null && denumire != null) {
                            document.getElementById("rezultat").innerHTML = "Firma neinregistrata la ONRC. Nu se poate obtine certificat constatator";
                            document.getElementById("rezultat").style.display = "block";
                        } else {
                            document.getElementById("rezultat").style.display = "none";
                            document.getElementById("denumire2").innerHTML = "Firma: " + denumire;
                            document.getElementById("judet").innerHTML = "Judet: " + jud;
                            document.getElementById("adresa").innerHTML = "Adresa: " + adrs;
                            document.getElementById("nrReg").innerHTML = "Nr.Reg ONRC: " + reg;
                            document.getElementById("stare").innerHTML = "Stare Mfinante " + str;

                            modal.style.display = "block";
                            jQuery(document).on('click', '#pune', function() {
                                document.getElementById("denumire").value = denumire;
                                modal.style.display = "none";
                                document.getElementById("submit").disabled = false;
                                document.getElementById("validati").style.display = "none";
                            });

                            jQuery(document).on('click', '#incearca', function() {
                                document.getElementById("cui").value = '';
                                document.getElementById("denumire").value = '';
                                modal.style.display = "none";
                            });
                            jQuery.getJSON('https://ipapi.co/json/', function(data) {
                                document.getElementById("ip").value = JSON.stringify(data.ip, null, 2);
                            });
                        }
                    }
                };
                request.send();
            });
        });

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        jQuery("#tip").change(function() {
            if (tip.options[tip.selectedIndex].text == "Certificat constatator de baza") {
                jQuery('#baza').show();
                jQuery('#insolv').hide();
                jQuery('#imm').hide();

                jQuery('#total').val("74.00 lei");
                document.getElementById("certIMM").disabled = true;
                document.getElementById("certIns").disabled = true;
                document.getElementById("certBaza").disabled = false;
                jQuery('#payment-total').html("74.00 lei");
            } else if (tip.options[tip.selectedIndex].text == "Certificat constatator fonduri IMM") {
                jQuery('#imm').show();
                jQuery('#baza').hide();
                jQuery('#inso').hide();

                document.getElementById("certIMM").disabled = false;
                document.getElementById("certIns").disabled = true;
                document.getElementById("certBaza").disabled = true;

                jQuery('#payment-total').html("74.00 lei");
                jQuery('#total').val("74.00 lei");
            } else if (tip.options[tip.selectedIndex].text == "Certificat constatator pentru insolventa") {
                jQuery('#insol').show();
                jQuery('#imm').hide();
                jQuery('#baza').hide();
                document.getElementById("certIMM").disabled = true;
                document.getElementById("certIns").disabled = false;
                document.getElementById("certBaza").disabled = true;

                jQuery('#total').val("74.00 lei");
                jQuery('#payment-total').html("74.00 lei");

            } else {
                jQuery('#baza').hide();
                jQuery('#insol').hide();
                jQuery('#imm').hide();

                document.getElementById("certIMM").disabled = true;
                document.getElementById("certIns").disabled = true;
                document.getElementById("certBaza").disabled = true;


                jQuery('#total').val("49.00 lei");
                jQuery('#payment-total').html("49.00 lei");
            }
        });
        jQuery("#tip").trigger("change");


        jQuery("#daNu").change(function() {
            if (daNu.options[daNu.selectedIndex].text == "NU") {
                jQuery('#persoana').show();
                jQuery('#persfactura').attr('required', true);
            } else {
                jQuery('#persoana').hide();
                jQuery('#persfactura').attr('required', false);
            }
        });
        jQuery("#daNu").trigger("change");

        var elements = document.getElementsByTagName("INPUT");
        for (var i = 0; i < elements.length; i++) {
            elements[i].oninvalid = function(e) {
                e.target.setCustomValidity("");
                if (!e.target.validity.valid) {
                    e.target.setCustomValidity("Va rugam sa completati campul.");
                }
            };
            elements[i].oninput = function(e) {
                e.target.setCustomValidity("");
            };
        }
    </script>
</body>

</html>