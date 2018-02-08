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
        <b>Welcome</b> to your <b>Community Health Rewards</b> program.  Start receiving discounts and specials from businesses in your area including fitness and healthy lifestyle options!
    </div>

    <div class="wrapper">
        <div class="signup1">
            <div id="greatDealsHeader" class="deallist-header">

                <div class="titleBar">REQUEST YOUR MEMBER ID</div></div>
            <p>Please enter your email addres and organization name below to receive your individual member ID and a link to register for your account.
            </p>

            <form name="loginForm" id="loginForm" method="POST" action="import-member-xml.php">
                    <div id="postmsg"></div>
                    <label>Email Address</label>
                    <input type="text" name="email" class="required email" size=50 />
                    <label>First Name</label>
                    <input type="text" name="fname" size=50 />
                    <label>Last Name</label>
                    <input type="text" name="lname" size=50 />
                    <label>Organization Name</label>
                    <input type="text" name="orgName" size=50 />
                <input type="submit" name="register" id="register" value="Request Now" class="btn_details" />
            </form>
        </div>

        <div class="signup2">
            <img src="http://intranet.communitymediagroup.com/demo/chrewards/site.png" width="550px">
        </div>
    </div>
<?
require_once("includes/footer.php");
?>
