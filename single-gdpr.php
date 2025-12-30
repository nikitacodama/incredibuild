<?php
/*
Template Name: legalForm
Template Post Type:page, legal
*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>


</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php
$template_part_block = '<!-- wp:template-part {"slug":"global-header","theme":"incredibuild_24"} /-->';
echo do_blocks( $template_part_block );
?>



<?php wp_body_open(); ?>


<div class="formC">

<?php


$globalId;
function updateJsonFile($file_path, $new_data) {
    $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
    $pageUrl =  'https://' . $_SERVER['HTTP_HOST'] . $uri_parts[0] . "?id=";
    $current_data = file_get_contents($file_path);
    $current_data_array = json_decode($current_data, true);

    $sessionId = session_id(); // Get the session ID
    $email = $new_data['email'];
    $combinedID = $sessionId . '_' . md5($email); // Combine session ID and hashed email

    $new_data['id'] = $combinedID;
    $current_data_array[] = $new_data;
    
    $updated_data = json_encode($current_data_array, JSON_PRETTY_PRINT);
    $globalId = $combinedID;
    if (file_put_contents($file_path, $updated_data) !== false) {
        //$to =  get_field('to_email');
		$to =  "ziv.rozenberg@incredibuild.com";
        $subject = "Privacy request email verification";
        $message = "<table style='width: 100%;max-width:600px;margin:auto;'><tr><td><table style='width: 100%;'><tr><td height='50'><img src='https://www.incredibuild.com/wp-content/themes/incredibuild/img/incredibuild-logo.svg' alt='Incredibuild' aria-label='Incredibuild Company Logo'></td></tr><tr><td height='100'>Hi " . $new_data['first_name'] . " " .$new_data['last_name'] .", please click the link below to verify your email. <br/><br/>This link will expire in 48 hours.</td></tr><tr><td height='100'><a style='font-weight:bold;color:#171E37;text-decoration:none;display:block;background-color: #34F1BA;border-radius: 20px; display: block; padding: 10px 28px; height: 40px;  line-height: 100%; display: flex; align-items: center; justify-content: center; ' href='" . $pageUrl .$new_data['id']."'>Verify Email</a></td></tr><tr><td></td></tr></table></td></tr></table>";
        $headers = array('Content-Type: text/html; charset=UTF-8','From: Incredibuild Privacy Control Center');        
        
       // if (get_field('cc_email')){
       // $headers[] = 'Cc: '.get_field('cc_email');      
       // }
                        wp_mail( $email, $subject, $message, $headers );
                                   
        return "<span class='msg'>Thank you for contacting us.<br/>We sent you an email to verify your request.<br/><br/>Please verify your email in the next 48 hours.</span>";
     
    } else {
        return "Failed to add new data to JSON file.";
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $request_type = $_POST['request_type'];
    $relationship = $_POST['relationship'];
    $additional_info = $_POST['additional_info'];

    // Prepare data as an array
    $new_data = array(
        "first_name" => $first_name,
        "last_name" => $last_name,
        "email" => $email,
        "phone" => $phone,
        "country" => $country,
        "request_type" => $request_type,
        "relationship" => $relationship,
        "additional_info" => $additional_info,
        "verified" => "false"
    );

    // Update the JSON file
    $file_path = get_template_directory() .'/gdprdta/data.json';  // Replace this with your file path
    $result = updateJsonFile($file_path, $new_data);
    echo $result; // Output the result of the update
}

// Function to retrieve data based on ID
function getDataById($file_path, $id) {
    $current_data = file_get_contents($file_path);
    $current_data_array = json_decode($current_data, true);

    foreach ($current_data_array as $record) {
        if ($record['id'] === $id) {
            return $record; // Return the record with the matching ID
        }
    }

    return null; // Return null if no record found for the ID
}

// Function to update the JSON file with "verified" field
function updateVerifiedField($file_path, $id) {
    $current_data = file_get_contents($file_path);
    $current_data_array = json_decode($current_data, true);

    foreach ($current_data_array as &$record) {
        if ($record['id'] === $id) {
            $record['verified'] = 'true'; // Set "verified" field to true
        }
    }

    $updated_data = json_encode($current_data_array, JSON_PRETTY_PRINT);
    
    if (file_put_contents($file_path, $updated_data) !== false) {
   //     return "Verification status updated for ID: " . $id;
    } else {
   //     return "Failed to update verification status for ID: " . $id;
    }
}
$formSubmitted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Your form submission handling code goes here

    // Set the flag to true since the form is submitted
    $formSubmitted = true;

    // You can process the form data and update the JSON file as needed
}
// Check if the link is clicked
if (isset($_GET['id'])) {
    $file_path = get_template_directory() .'/gdprdta/data.json'; // Replace this with your file path
    $id = $_GET['id'];

    // Retrieve data based on the provided ID
    $record = getDataById($file_path, $id);

    if ($record !== null) {
      //  print_r($record);
      echo "<span class='msg'>Thank you for verifying!<br/><br/>We are on it.</span>";
        //GDPR_Compliance@incredibuild.com Update the JSON entry with "verified" field set to "true"
        $verificationResult = updateVerifiedField($file_path, $id);
       // echo "email verified";
       $to =  get_field('to_email');
       $subject = "gdpr form request";
       $message = "<table><tr><td>First Name </td><td>" .  $record['first_name'] ."</td></tr><tr><td>Last Name </td><td>".  $record['last_name'] ."</td></tr><tr><td>Email </td><td>".  $record['email'] ."</td></tr><tr><td>Phone Number </td><td>".  $record['phone'] ."</td></tr><tr><td>Country of residence </td><td>".  $record['country'] ."</td></tr><tr><td>type of request </td><td>".  $record['request_type'] ."</td></tr><tr><td>relationship to Incredibuild </td><td>".  $record['relationship'] ."</td></tr><tr><td>information</td><td>".  $record['additional_info'] ."</td></tr></table>";
       $headers = array('Content-Type: text/html; charset=UTF-8');        
       if (get_field('cc_email')){
       //$headers[] = 'Cc: '.get_field('cc_email');      
       }
        wp_mail( $to, $subject, $message, $headers );
    } else {
        echo "No data found for ID: " . $id;
    }
    $formSubmitted = true;
}

?>
  <?php if (!$formSubmitted ): 
        // Data doesn't exist, and the form is not yet submitted
        // Display the form
        ?>




    <form action="" method="post">
    <span class="mandetory"><input type="text" name="first_name" id="first_name" placeholder="First Name" required="" data-uw-rm-form="fx" aria-required="true" aria-label="First Name"></span>
    <span class="mandetory"><input type="text" name="last_name" id="last_name" placeholder="Last Name" required="" data-uw-rm-form="fx" aria-required="true" aria-label="Last Name"></span>
    <span class="mandetory"><input type="email" name="email" id="email" placeholder="Email" required="" data-uw-rm-form="fx" aria-required="true" aria-label="Email"></span>
    <span class="mandetory"><input type="tel" name="phone" id="phone" placeholder="Phone Number" required="" data-uw-rm-form="fx" aria-required="true" aria-label="Phone Number"></span>
    <span class="mandetory"><select name="country" id="country" placeholder="Country of residence" required="" data-uw-rm-form="fx" aria-required="true" aria-label="Country of residence">
    <option value="" disabled="" selected="">Country of residence</option>
    <option value="Afghanistan">Afghanistan</option><option value="Albania">Albania</option><option value="Algeria">Algeria</option><option value="American Samoa">American Samoa</option><option value="Andorra">Andorra</option><option value="Angola">Angola</option><option value="Anguilla">Anguilla</option><option value="Antigua and Barbuda">Antigua and Barbuda</option><option value="Argentina">Argentina</option><option value="Armenia">Armenia</option><option value="Aruba">Aruba</option><option value="Australia">Australia</option><option value="Austria">Austria</option><option value="Azerbaijan">Azerbaijan</option><option value="Bahamas">Bahamas</option><option value="Bahrain">Bahrain</option><option value="Bangladesh">Bangladesh</option><option value="Barbados">Barbados</option><option value="Belarus">Belarus</option><option value="Belgium">Belgium</option><option value="Belize">Belize</option><option value="Benin">Benin</option><option value="Bermuda">Bermuda</option><option value="Bhutan">Bhutan</option><option value="Bolivia">Bolivia</option><option value="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option><option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option><option value="Botswana">Botswana</option><option value="Brazil">Brazil</option><option value="Brunei Darussalam">Brunei Darussalam</option><option value="Bulgaria">Bulgaria</option><option value="Burkina Faso">Burkina Faso</option><option value="Burundi">Burundi</option><option value="Cambodia">Cambodia</option><option value="Cameroon">Cameroon</option><option value="Canada">Canada</option><option value="Cape Verde">Cape Verde</option><option value="Cayman Islands">Cayman Islands</option><option value="Central African Republic">Central African Republic</option><option value="Chad">Chad</option><option value="Chile">Chile</option><option value="China">China</option><option value="Christmas Island">Christmas Island</option><option value="Colombia">Colombia</option><option value="Comoros">Comoros</option><option value="Congo">Congo</option><option value="Congo, the Drc">Congo, the Drc</option><option value="Cook Islands">Cook Islands</option><option value="Costa Rica">Costa Rica</option><option value="Cote d'Ivoire">Cote d'Ivoire</option><option value="Croatia">Croatia</option><option value="Cyprus">Cyprus</option><option value="Czech Republic">Czech Republic</option><option value="Denmark">Denmark</option><option value="Djibouti">Djibouti</option><option value="Dominica">Dominica</option><option value="Dominican Republic">Dominican Republic</option><option value="Ecuador">Ecuador</option><option value="Egypt">Egypt</option><option value="El Salvador">El Salvador</option><option value="Equatorial Guinea">Equatorial Guinea</option><option value="Eritrea">Eritrea</option><option value="Estonia">Estonia</option><option value="Ethiopia">Ethiopia</option><option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option><option value="Faroe Islands">Faroe Islands</option><option value="Fiji">Fiji</option><option value="Finland">Finland</option><option value="France">France</option><option value="French Guiana">French Guiana</option><option value="French Polynesia">French Polynesia</option><option value="Gabon">Gabon</option><option value="Gambia">Gambia</option><option value="Georgia">Georgia</option><option value="Germany">Germany</option><option value="Ghana">Ghana</option><option value="Gibraltar">Gibraltar</option><option value="Greece">Greece</option><option value="Greenland">Greenland</option><option value="Grenada">Grenada</option><option value="Guadeloupe">Guadeloupe</option><option value="Guam">Guam</option><option value="Guatemala">Guatemala</option><option value="Guinea">Guinea</option><option value="Guinea-Bissau">Guinea-Bissau</option><option value="Guyana">Guyana</option><option value="Haiti">Haiti</option><option value="Honduras">Honduras</option><option value="Hong Kong">Hong Kong</option><option value="Hungary">Hungary</option><option value="Iceland">Iceland</option><option value="India">India</option><option value="Indonesia">Indonesia</option><option value="Iran (Islamic Republic Of)">Iran (Islamic Republic Of)</option><option value="Iraq">Iraq</option><option value="Ireland">Ireland</option><option value="Israel">Israel</option><option value="Italy">Italy</option><option value="Jamaica">Jamaica</option><option value="Japan">Japan</option><option value="Jordan">Jordan</option><option value="Kazakhstan">Kazakhstan</option><option value="Kenya">Kenya</option><option value="Kiribati">Kiribati</option><option value="Kuwait">Kuwait</option><option value="Kyrgyzstan">Kyrgyzstan</option><option value="Laos">Laos</option><option value="Latvia">Latvia</option><option value="Lebanon">Lebanon</option><option value="Lesotho">Lesotho</option><option value="Liberia">Liberia</option><option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option><option value="Liechtenstein">Liechtenstein</option><option value="Lithuania">Lithuania</option><option value="Luxembourg">Luxembourg</option><option value="Macao">Macao</option><option value="Macedonia">Macedonia</option><option value="Madagascar">Madagascar</option><option value="Malawi">Malawi</option><option value="Malaysia">Malaysia</option><option value="Maldives">Maldives</option><option value="Mali">Mali</option><option value="Malta">Malta</option><option value="Marshall Islands">Marshall Islands</option><option value="Martinique">Martinique</option><option value="Mauritania">Mauritania</option><option value="Mauritius">Mauritius</option><option value="Mexico">Mexico</option><option value="Micronesia, Federated States Of">Micronesia, Federated States Of</option><option value="Moldova, Republic Of">Moldova, Republic Of</option><option value="Monaco">Monaco</option><option value="Montenegro">Montenegro</option><option value="Montserrat">Montserrat</option><option value="Morocco">Morocco</option><option value="Mozambique">Mozambique</option><option value="Myanmar">Myanmar</option><option value="Namibia">Namibia</option><option value="Nauru">Nauru</option><option value="Nepal">Nepal</option><option value="Netherlands">Netherlands</option><option value="Netherlands Antilles">Netherlands Antilles</option><option value="New Caledonia">New Caledonia</option><option value="New Zealand">New Zealand</option><option value="Nicaragua">Nicaragua</option><option value="Niger">Niger</option><option value="Nigeria">Nigeria</option><option value="Norfolk Island">Norfolk Island</option><option value="Northern Mariana Islands">Northern Mariana Islands</option><option value="Norway">Norway</option><option value="Oman">Oman</option><option value="Pakistan">Pakistan</option><option value="Panama">Panama</option><option value="Papua New Guinea">Papua New Guinea</option><option value="Paraguay">Paraguay</option><option value="Peru">Peru</option><option value="Philippines">Philippines</option><option value="Poland">Poland</option><option value="Portugal">Portugal</option><option value="Qatar">Qatar</option><option value="Republic of Korea">Republic of Korea</option><option value="Reunion">Reunion</option><option value="Romania">Romania</option><option value="Russian Federation">Russian Federation</option><option value="Rwanda">Rwanda</option><option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option><option value="Saint Lucia">Saint Lucia</option><option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option><option value="Samoa">Samoa</option><option value="San Marino">San Marino</option><option value="Sao Tome and Principe">Sao Tome and Principe</option><option value="Saudi Arabia">Saudi Arabia</option><option value="Senegal">Senegal</option><option value="Serbia">Serbia</option><option value="Serbia and Montenegro">Serbia and Montenegro</option><option value="Seychelles">Seychelles</option><option value="Sierra Leone">Sierra Leone</option><option value="Singapore">Singapore</option><option value="Sint Maarten (Dutch part)">Sint Maarten (Dutch part)</option><option value="Slovakia">Slovakia</option><option value="Slovenia">Slovenia</option><option value="Solomon Islands">Solomon Islands</option><option value="Somalia">Somalia</option><option value="South Africa">South Africa</option><option value="South Sudan">South Sudan</option><option value="Spain">Spain</option><option value="Sri Lanka">Sri Lanka</option><option value="St. Helena">St. Helena</option><option value="Sudan">Sudan</option><option value="Suriname">Suriname</option><option value="Swaziland">Swaziland</option><option value="Sweden">Sweden</option><option value="Switzerland">Switzerland</option><option value="Syrian Arab Republic">Syrian Arab Republic</option><option value="Taiwan">Taiwan</option><option value="Tajikistan">Tajikistan</option><option value="Tanzania, United Republic Of">Tanzania, United Republic Of</option><option value="Thailand">Thailand</option><option value="Timor-Leste">Timor-Leste</option><option value="Togo">Togo</option><option value="Tokelau">Tokelau</option><option value="Tonga">Tonga</option><option value="Trinidad and Tobago">Trinidad and Tobago</option><option value="Tunisia">Tunisia</option><option value="Turkey">Turkey</option><option value="Turkmenistan">Turkmenistan</option><option value="Turks and Caicos Islands">Turks and Caicos Islands</option><option value="Tuvalu">Tuvalu</option><option value="U.S. Minor Islands">U.S. Minor Islands</option><option value="Uganda">Uganda</option><option value="Ukraine">Ukraine</option><option value="United Arab Emirates">United Arab Emirates</option><option value="United Kingdom">United Kingdom</option><option value="United States">United States</option><option value="Uruguay">Uruguay</option><option value="Uzbekistan">Uzbekistan</option><option value="Vanuatu">Vanuatu</option><option value="Venezuela">Venezuela</option><option value="Vietnam">Vietnam</option><option value="Virgin Islands (British)">Virgin Islands (British)</option><option value="Yemen">Yemen</option><option value="Zambia">Zambia</option><option value="Zimbabwe">Zimbabwe</option>
            </select></span>
            <div class="selectorparentcontainer">
                <div class="selector-container">
  <span class="selector"><i class="chevron"></i></span>
  <input class="typeofrequest" type="text" name="request_type" id="request_type" required="" data-uw-rm-form="fx" aria-required="true" aria-label="Text field">
  <ul class="list-unstyled selectMenu">
    <li class="init" seelctval="All"><span class="qchar">*</span>Type of Request</li>
    
            <li seelctval="Download">
        <strong>Download</strong>
         We will provide a report of your personal data across our systems    </li>
        <li seelctval="Transfer">
        <strong>Transfer</strong>
        Package up your data and send it to a desired recipient    </li>
        <li seelctval="Delete">
        <strong>Delete</strong>
        Delete your personal data found in our systems    </li>
        <li seelctval="Object to Processing">
        <strong>Object to Processing</strong>
        Ask us to stop processing your data for certain purposes (eg, public interest, legitimate interests, direct marketing)    </li>
        <li seelctval="Update Inaccuracies">
        <strong>Update Inaccuracies</strong>
        Update any inaccuracy you've found in our systems    </li>
    </ul>
</div>
</div>

           
            <fieldset>
                <legend><span class="qchar">*</span>Your relationship to Incredibuild</legend>


        <div>
        <input type="radio" id="employee" name="relationship" value="employee" required="" data-uw-rm-form="nfx">
        <label for="employee">employee</label>
    </div>
        <div>
        <input type="radio" id="employee" name="relationship" value="job applicant" required="" data-uw-rm-form="nfx">
        <label for="employee">job applicant</label>
    </div>
        <div>
        <input type="radio" id="employee" name="relationship" value="prospect" required="" data-uw-rm-form="nfx">
        <label for="employee">prospect</label>
    </div>
        <div>
        <input type="radio" id="employee" name="relationship" value="customer" required="" data-uw-rm-form="nfx">
        <label for="employee">customer</label>
    </div>
        <div>
        <input type="radio" id="employee" name="relationship" value="partner" required="" data-uw-rm-form="nfx">
        <label for="employee">partner</label>
    </div>
        <div>
        <input type="radio" id="employee" name="relationship" value="supplier" required="" data-uw-rm-form="nfx">
        <label for="employee">supplier</label>
    </div>
        <div>
        <input type="radio" id="employee" name="relationship" value="recipient of marketing communication" required="" data-uw-rm-form="nfx">
        <label for="employee">recipient of marketing communication</label>
    </div>
        <div>
        <input type="radio" id="employee" name="relationship" value="other" required="" data-uw-rm-form="nfx">
        <label for="employee">other</label>
    </div>
    
            </fieldset>
            <textarea rows="4" cols="50" name="additional_info" id="additional_info" placeholder="Additional information..." data-uw-rm-form="fx" aria-label="Additional information..."></textarea>
                <input type="submit" name="send" value="Send" data-uw-rm-form="fx" aria-labelledby="uw39d047b">
        </form>
      
    
    </div>
	<?php endif; ?>



<?php
$template_part_block = '<!-- wp:template-part {"slug":"incredibuild-footer","theme":"incredibuild_24"} /-->';
echo do_blocks( $template_part_block );
?>

<?php wp_footer(); ?>
<script>
jQuery("ul.selectMenu").on("click", ".init", function() {
    jQuery(this).closest("ul.selectMenu").children('li:not(.init)').toggle();
});

var allOptions = jQuery("ul.selectMenu").children('li:not(.init)');
jQuery("ul").on("click", "li:not(.init)", function() {
    allOptions.removeClass('selected');
    jQuery(this).addClass('selected');
    jQuery("ul.selectMenu").children('.init').html(jQuery(this).attr("seelctval"));
	jQuery(".typeofrequest").val(jQuery(this).attr("seelctval"));
    allOptions.toggle();
});
</script>

</body>
</html>