<?php

session_start();
if ($_POST['submit'] == "go") {
//checktoken
    if ($_POST['token'] == $_SESSION['token']) {
//strip_tags
        $name = strip_tags($_POST['name']);
        $name = substr($name, 0, 40);
//cleanoutanypotentialhexadecimalcharacters
        $name = cleanHex($name);
//continueprocessing….
    } else {
//stopallprocessing!remoteformpostingattempt!
    }
}
$token = md5(uniqid(rand(), true));
$_SESSION['token'] = $token;
function cleanHex($input)
{
    $clean = preg_replace("![\][xX]([A-Fa-f0-9]{1,3})!", "", $input);
    return $clean;
}
?>

<form action="<?php echo$_SERVER['PHP_SELF']; ?>" method="post">
    <p>
        <label for="name">Name</label>
        <input type="text" name="name" id="name" size="20" maxlength="40" />
    </p>
<input type="hidden" name="token" value="<?php echo $token; ?>"/>
<p>
    <input type="submit" name="submit" value="go"/>
</p>
</form>
