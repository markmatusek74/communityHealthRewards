<?
require_once("includes/header.php");
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script type="text/javascript" src="scripts/jquery.validate.min.js"></script>
<script type="text/javascript">
    $( document ).ready(function() {
        $("#loginForm").validate({
            rules: {
                fname: { required: true },
                lname: { required: true },
                orgName: { required: true},
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                fname: "Enter a first name",
                lname: "Enter a las tname",
                email: {
                    required: "Please enter a valid email address",
                    minlength: "Please enter a valid email address"
                }
            }
        });
    });
</script>
<style type="text/css">
     .error { color: red; font-size: 12px;}
</style>

    <div class="welcomeMessage">
        Subscriber Savings is a <b>FREE</b> program designed to say "thanks" to our <b>All Access</b> subscribers.  This membership provides access to premium discounts locally, as well as all across North America.  Subscribrs can enjoy a variety of discounts from restaaurants, entetainment venues, services and so much more.  Simply print the coupon from home or download the app and show on your phone or mobile device.
    </div>

    <div class="wrapper">
        <div class="signup1">
            <div id="greatDealsHeader" class="deallist-header">

                <div class="titleBar">Request Your Member ID</div></div>
            <p>Please complete the form below and click "Request Now" to receive your individual member ID and a link to register for your account.
            </p>

            <form name="loginForm" id="loginForm" method="POST" action="import-member-xml.php">
                    <div id="postmsg"></div>
                    <label>Email Address</label>
                    <input type="text" name="email" class="required email" size=50 />
                    <label>First Name</label>
                    <input type="text" name="fname" size=50 />
                    <label>Last Name</label>
                    <input type="text" name="lname" size=50 />
                    <label>Phone Number</label>
                    <input type="text" name="phone" size=50 />
                    <label>Publication</label>
                    <select name="publication">

                    <option selected disabled>Choose one</option>
                    <optgroup label="Illinois">
                        <option value="Hoopeston Chronicle">Hoopeston Chronicle</option>
                        <option value="Iroquois Times-Republic">Iroquois Times-Republic</option>
                    </optgroup>
                    
                    <optgroup label="Indiana">
                        <option value="Fountain County Neighbor">Fountain County Neighbor</option>
                        <option value="Hartford City News-Times">Hartford City News-Times</option>
                        <option value="Herald Journal">Herald Journal</option>
                        <option value="KV Post News">KV Post News</option>
                        <option value="Lafayette Leader">Lafayette Leader</option>
                        <option value="Newton County Enterprise">Newton County Enterprise</option>
                        <option value="Rensselaer Republican">Rensselaer Republican</option>
                        <option value="Review-Republican">Review-Republican</option>
                        <option value="Winchester News-Gazette">Winchester News-Gazette</option>
                     </optgroup>

                     <optgroup label="Iowa">
                        <option value="Atlantic News Telegraph">Atlantic News Telegraph</option>
                        <option value="Audubon Co. Advocate-Journal">Audubon Co. Advocate-Journal</option>
                        <option value="Barr’s Post Card News">Barr's Post Card News</option>
                        <option value="Collector’s Journal">Collector's Journal</option>
                        <option value="Independence Bulletin-Journal">Independence Bulletin-Journal</option>
                        <option value="Fort Madison Daily Democrat">Fort Madison Daily Democrat</option>
                        <option value="Hancock Co. Journal-Pilot">Hancock Co. Journal-Pilot</option>
                        <option value="Keokuk Daily Gate City">Keokuk Daily Gate City</option>
                        <option value="Oelwein Daily Register">Oelwein Daily Register</option>
                        <option value="Vinton Newspapers">Vinton Newspapers</option>
                        <option value="Waverly Newspapers">Waverly Newspapers</option>
                    </optgroup>

                    <optgroup label="Michigan">
                        <option value="Iosco County News-Herald">Iosco County News-Herald</option>
                        <option value="Ludington Daily News">Ludington Daily News</option>
                        <option value="Oceana’s Herald Journal">Oceana's Herald Journal</option>
                        <option value="Oscoda Press">Oscoda Press</option>
                        <option value="White Lake Beacon">White Lake Beacon</option>
                    </optgroup>

                    <optgroup label="New York">
                        <option value="Finger Lakes Times">Finger Lakes Times</option>
                        <option value="Olean Times Herald">Olean Times Herald</option>
                        <option value="Salamanca Press">Salamanca Press</option>
                    </optgroup>

                    <optgroup label="Pennsylvania">
                        <option value="Bradford Era">Bradford Era</option>
                        <option value="Clearfield Progress">Clearfield Progress</option>
                        <option value="Courier Express">Courier Express</option>
                        <option value="Free Press Courier">Free Press Courier</option>
                        <option value="Jeffersonian Democrat">Jeffersonian Democrat</option>
                        <option value="Leader Vindicator">Leader Vindicator</option>
                        <option value="Potter Leader-Enterprise">Potter Leader-Enterprise</option>
                        <option value="Reporter Argus">Reporter Argus</option>
                        <option value="Tri-County Sunday">Tri-County Sunday</option>
                        <option value="Wellsboro Gazette">Wellsboro Gazette</option>
                    </optgroup>
                    </select>
                <input type="submit" name="register" id="register" value="Request Now" class="btn_details" />
            </form>
        </div>

        <div class="signup2">
            <img src="./img/subscriber-savings-screenshot.png" width="550px">
        </div>
    </div>
<?
require_once("includes/footer.php");
?>
